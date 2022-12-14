<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\JwtService;

class SocketController extends Controller
{
    public function index()
    {
        return view('socket');
    }

    public function writemessage()
    {
        return view('writemessage');
    }

    public function sendMessage(Request $request)
    {
        $receiverId = 1;
        $redis = new \Predis\Client([
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);

        $redis->publish('private.chat.' . $receiverId, $request->message);
        return redirect('writemessage');
    }

    public function gettoken(Request $request)
    {
        $user = User::first();

        $key = env('JWT_SECRET');
        // $token = JWTAuth::claims($user->toArray())->attempt(['email' => 'nobmtpro1@gmail.com', 'password' => 123]);
        $token = JwtService::generate($user, $key);

        // return JwtService::validate($token, $key);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
}
