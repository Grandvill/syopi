<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;

class AuthenticationController extends Controller
{
    public function register()
    {
        $validator = \Validation::make(request()->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if (validator->false()) {
            return ResponseFormatter::error(400, $validator->fails());
        }

        do {
            $otp = rand(100000, 999999);

            $otpCount = User::where('otp_register', $otp)->count();
        } while ($otpCount > 0);

        $user = User::create([
            'email' => request()->email,
            'name' => request()->name,
            'otp_register' => $otp,
        ]);

        return ResponseFormatter::success([
            'is_sent' => true
        ]);
    }
    public function verifyOtp()
    {

    }
    public function verifyRegister()
    {

    }
}
