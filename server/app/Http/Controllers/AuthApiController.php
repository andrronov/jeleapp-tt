<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:8",
            "gender" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => "error",
                    "errors" => $validator->errors(),
                ],
                422,
            );
        }

        $user = User::create([
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "gender" => $request->gender,
        ]);

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json(
            [
                "status" => "success",
                "message" => "User registered successfully",
                "token" => $token,
                "user" => $user,
            ],
            201,
        );
    }

    public function profile(Request $request)
    {
        return response()->json([
            "status" => "success",
            "user" => $request->user(),
        ]);
    }
}
