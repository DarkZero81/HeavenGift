@extends('layouts.app')

@section('title', 'Thank you')

@section('content')
    <div class="text-center">
        <h2>Thank you for your order!</h2>
        <p>We received your order and will contact you with further details.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Return to shop</a>
    </div>
@endsection
