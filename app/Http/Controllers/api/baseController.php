<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class baseController extends Controller
{
    public static function response(bool $successful = false, string $message = 'text', array $payload = [], int $code = 200){
        return response([
            'successful'=>$successful,
            'code'=>$code,
            'message'=>$message,
            'payload'=>$payload
        ], $code);
    }
}
