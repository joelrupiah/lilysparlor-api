<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Mail;
use Auth;
use App\Mail\ResetPassword;
use Illuminate\Foundation\Validation\ValidationException;

class AuthController extends Controller
{

    public function index()
    {
        //
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required', 'email', 'unique:users',
            'password' => 'required', 'min:6', 'confirmed'
        ]);

        $userCreated = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($userCreated, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required', 'email', 'unique:users',
            'password' => 'required', 'min:6', 'confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);

        }

        $success =  $user;
        $success['token'] =  $user->createToken('UserToken',['user'])->accessToken;

        return response()->json($success, 200);

        // return $user->createToken('User Token', ['user'])->accessToken;

        // if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])){

        //     config(['auth.guards.api.provider' => 'user']);

        //     $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
        //     $success =  $user;
        //     $success['token'] =  $user->createToken('UserToken',['user'])->accessToken;

        //     return response()->json($success, 200);
        // }else{
        //     return response()->json(['error' => ['Email and Password are Wrong.']], 401);
        // }
    }

    public function sendToken(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!isset($user->id)) {
            return response()->json([
                'error' => 'User with this email does not exist'
            ], 401);
        }

        $token = \Str::random(5);
        Mail::to($user)->send(new ResetPassword($token));

        $passwordReset = new PasswordReset();
        $passwordReset->email = $user->email;
        $passwordReset->token = $token;

        $passwordReset->save();
    }

    public function validateToken(Request $request)
    {
        $passwordReset = PasswordReset::where('token', $request->token)->first();

        if (!isset($passwordReset->email)) {
            return response()->json([
                'error' => 'Invalid Token'
            ], 401);
        }

        $user = User::where('email', $passwordReset->email)->first();

        return response()->json($user, 200);
    }

    public function resetPassword(Request $request)
    {
        $user = User::find($request->user_id);

        $passwordReset = PasswordReset::where('email', $user->email)->first();
        $passwordReset->delete();

        $user->password = bcrypt($request->password);
        $user->save();
    }

}
