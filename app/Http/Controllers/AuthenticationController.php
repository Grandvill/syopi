<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function register()
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
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

        \Mail::to($user->email)->send(new \App\Mail\SendRegisterOTP($user));

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
