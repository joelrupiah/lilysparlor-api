<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Mail\AdminCredential;
use App\Mail\CreateAdmin;

class AdminController extends Controller
{

    public function index()
    {
        // $admins = Admin::with(['roles', 'permission'])->get();

        $admins = Admin::get();

        $admins->transform(function($admin){
            $admin->role = $admin->getRoleNames()->first();
            $admin->adminPermissions = $admin->getPermissionNames();
            return $admin;
        });

        return response()->json([
            'admins' => $admins
        ], 200);
    }

    public function getAllUsers()
    {
      $users = User::get();

      return response()->json([
        'users' => $users
      ], 200);
    }

    public function showUserSpecificHistory(Request $request, $id)
    {
      $orders = Order::where('user_id', $request->id)
                  ->with('admin')
                  ->get();
      return response()->json([
        'orders' => $orders
      ], 200);
    }

    public function store(Request $request)
    {
      // return $request;
      $request->validate([
          'name' => 'required|string',
          'password' => 'required|min:6',
          'role' => 'required',
          'email' => 'required|email|unique:admins'
      ]);

      $admin = new Admin();
      $admin->name = $request->name;
      $admin->email = $request->email;
      $admin->password = bcrypt($request->password);

      $admin->assignRole($request->role);
      if ($request->has('permissions')) {
          $admin->givePermissionTo($request->permissions);
      }

      $data = [
          'title' => 'Lilys Parlor',
          'body' => 'Dear ' . $request->name . '. Welcome to Lilys Parlor. This are your login credentials.
                      You are adviced to change after the first login',
          'email' => $request->email,
          'password' => $request->password
      ];

      \Mail::to($request->email)->send(new CreateAdmin($data));

      $admin->save();

      return response()->json('success', 201);
    }

    public function show(Admin $admin, $id)
    {
      $adminData = Admin::where('id', $id)->first();

      return response()->json([
          'adminData' => $adminData
      ], 200);
    }

    public function update(Request $request, $id)
    {
      // return $request;
      $request->validate([
          'name' => 'string',
          'password' => 'nullable|min:6',
          'role' => 'required',
          'email' => 'email|unique:users,email,'.$id
      ]);

      $admin = Admin::findOrFail($id);

      $admin->name = $request->name;
      $admin->email = $request->email;

      if ($request->has('password')) {
          $admin->password = bcrypt($request->password);
      }

      if ($request->has('role')) {
          $adminRole = $admin->getRoleNames();
          foreach ($adminRole as $role) {
              $admin->removeRole($role);
          }

          $admin->assignRole($request->role);
      }

      if ($request->has('permissions')) {
          $adminPermissions = $admin->getPermissionNames();
          foreach ($adminPermissions as $permission) {
              $admin->revokePermissionTo($permission);
          }

          $admin->givePermissionTo($request->permissions);
      }

      $details = [
          'title' => 'Mail from Lilys Parlor',
          'body' => 'You requested a password change. This is your new password please update it after accessing your account again',
          'email' => $request->email,
          'password' => $request->password
      ];

      \Mail::to($request->email)->send(new AdminCredential($details));

      $admin->save();

      return response()->json('success', 200);
    }

    public function destroy($id)
    {
      // return $id;
      $admin = Admin::findOrFail($id);
      $admin->delete();
      return response()->json('success', 200);
    }
}
