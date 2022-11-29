<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $admins = Admin::get();

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
        //
    }

    public function show(Admin $admin)
    {
        //
    }

    public function update(Request $request, Admin $admin)
    {
        //
    }

    public function destroy(Admin $admin)
    {
        //
    }
}
