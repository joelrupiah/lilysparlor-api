<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use Illuminate\Foundation\Validation\ValidationException;

class AuthController extends Controller
{

    public function index()
    {
        //
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $adminCreated = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($adminCreated, 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
            
        }

        $success =  $admin;
        $success['token'] =  $admin->createToken('AdminToken',['admin'])->accessToken;

        return response()->json($success, 200);

        // if(auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])){

        //     config(['auth.guards.api.provider' => 'admin']);

        //     $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
        //     $success =  $admin;
        //     $success['token'] =  $admin->createToken('AdminToken',['admin'])->accessToken;

        //     return response()->json($success, 200);
        // }else{
        //     return response()->json(['error' => ['Email and Password are Wrong.']], 401);
        // }
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
