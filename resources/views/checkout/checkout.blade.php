@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h2>Checkout</h2>
    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input name="customer_phone" value="{{ old('customer_phone') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="customer_address" class="form-control">{{ old('customer_address') }}</textarea>
        </div>
        <button class="btn btn-success">Confirm Purchase</button>
    </form>
@endsection
