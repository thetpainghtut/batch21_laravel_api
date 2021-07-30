<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validation

        // Data insert
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $data = [
            'message' => 'Successfully Register!',
            'user' => new UserResource($user)
        ];
        return response($data,201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('Mobile',['server:update']);

        $data = [
            'message' => 'Successfully Login!',
            'token' => $token->plainTextToken
        ];
        return response($data,200);
    }

    public function testing(Request $request)
    {
        if (!$request->user()->tokenCan('server:testing')) {
            $data = [
                'message' => 'Unauthorized!',
            ];

            return response($data,403);
        }
        return 'a';
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $data = [
            'message' => 'Successfully Logout!',
        ];
        return response($data,200);
    }
}
