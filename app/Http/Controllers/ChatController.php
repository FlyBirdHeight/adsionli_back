<?php

namespace App\Http\Controllers;

use GatewayClient\Gateway;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        Gateway::$registerAddress = '116.238.27.248:';
    }

    public function sendMessage(Request $request){
        $client_id = $request->get('client_id');
        
    }
}
