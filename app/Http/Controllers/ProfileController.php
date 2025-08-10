<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = auth()->user();

        return ResponseFormatter::success($user->api_response);
    }
}
