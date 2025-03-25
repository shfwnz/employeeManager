<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

// use function Laravel\Prompts\password;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8|confirmed'
        ]);

        // validation failed?
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // user created?
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ], 201);
        }

        // registration failed
        return response()->json(['success' => false], 409);
    }
}
