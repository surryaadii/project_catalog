<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ContactController extends ApiController
{
    public function sendEmail(Request $request)
    {
        $sTime = microtime(true);
        $status = true;
        $message = 'success';
        $data = [
            'fullName' => $request->get('fullName'),
            'email' => $request->get('email'),
            'phoneNumber' => $request->get('phoneNumber'),
            'message' => $request->get('message')
        ];

        return response()->json([
            'status' => $status,
            'message' => $message,
            'time' => microtime(true)-$sTime
        ]);
    }
}
