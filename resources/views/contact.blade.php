@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <h2>Contact Us</h2>
    <p>Use this form to contact the shop (placeholder).</p>
    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label>Message</label>
            <textarea name="message" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Send</button>
    </form>
@endsection
