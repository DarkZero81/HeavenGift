@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <h2>Your Cart</h2>
    @if ($cart && $cart->items->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cart->items as $item)
                    @php
                        $subtotal = $item->price * $item->quantity;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item->product?->name }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $item->id) }}" class="d-flex">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                    class="form-control form-control-sm me-2" style="width:80px">
                                <button class="btn btn-sm btn-secondary">Update</button>
                            </form>
                        </td>
                        <td>${{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <div><strong>Total:</strong> ${{ number_format($total, 2) }}</div>
            <div>
                <form method="POST" action="{{ route('cart.clear') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-danger">Clear Cart</button>
                </form>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary ms-2">Proceed to Checkout</a>
            </div>
        </div>
    @else
        <div class="alert alert-info">Your cart is empty.</div>
    @endif
@endsection
