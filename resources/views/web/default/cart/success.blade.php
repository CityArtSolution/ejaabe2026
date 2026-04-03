@extends('layouts.app')
@section('content')
<div class="container text-center mt-5">
    <h2>✅ Payment Successful</h2>
    <p>Your order #{{ $order->id ?? '' }} has been paid successfully.</p>
</div>
@endsection
