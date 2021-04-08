<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public $user;

    public function __construct()
    {
        // if (\JWTAuth::getToken()) {
        //     $this->user = \JWTAuth::parseToken()->authenticate();
        // }
    }
}
