<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
// use Tymon\JWTAuth\Exceptions\TokenExpiredException;
// use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LogoutController extends Controller
{
    // handle logout request
    public function __invoke(Request $request)
    {
        try {
            // invalidate token
            $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

            // return response
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',
            ]);
        } catch (JWTException $exception) {
            // logout failed
            return response()->json([
                'success' => false,
                'message' => 'Gagal logout, silakan coba lagi!',
            ], 500);
        }
    }
}
