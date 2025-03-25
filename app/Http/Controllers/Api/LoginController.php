<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // handle login request
    public function __invoke(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // validation failed?
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // get credentials
        $credentials = $request->only('email', 'password');

        // authentication failed?
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect Email or Password'
            ], 401);
        }

        // return response
        return response()->json([
            'success' => true,
            'user' => auth()->guard('api')->user(),
            'token' => $token
        ], 200);
    }
}
