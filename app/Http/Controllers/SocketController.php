<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $redis = new \Predis\Client([
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
        $redis->publish('chat', $request->message);
        return redirect('writemessage');
    }
}
