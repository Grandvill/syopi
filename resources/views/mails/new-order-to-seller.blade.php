@extends('mails.layout')

@section('content')
Hi {{ $order->seller->name }}, <br>
<br>
Anda mendapatkan pesanan baru dari {{ $order->user->name }}. <br>
Silakan cek detail pesanan pada dashboard Anda. <br>
<br><br>
Berikut adalah daftar item yang dipesan: <br>
@foreach($order->items as $item)
    {{ $item->product->name }} x ({{ $item->qty }}) <br>

@endforeach

@endsection
