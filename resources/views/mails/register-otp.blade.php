@extends('mails.layout')

@section('content')
Hi {{ $user->name }},<br>

Ini adalah kode OTP Register Anda: {{ $user->otp_register }}

@endsection

