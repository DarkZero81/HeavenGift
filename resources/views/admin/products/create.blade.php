@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
    <style>
        :root {
            --primary: #FF6B00;
            /* Orange */
            --secondary: #50247A;
            /* Purple */
            --dark: #0F061E;
            /* Very Dark Blue/Black */
            --light: #F8F9FA;
            /* Off-White */
            --accent: #FFD200;
            /* Yellow Accent */
        }

        body {
            /* Full screen gradient background matching the GiftHaven.html file */
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--dark) 100%);
            color: var(--light);
            font-family: 'Inter', sans-serif;
        }
    </style>
    <h2>Create Product</h2>
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3"><label>Name</label><input name="name" class="form-control"></div>
        <div class="mb-3"><label>Price</label><input name="price" class="form-control"></div>
        <div class="mb-3"><label>Category</label><select name="category_id" class="form-select">
                <option value="">None</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select></div>
        <div class="mb-3">
            <label>Image (upload or provide URL)</label>
            <input type="file" name="image" class="form-control mb-2">
            <input type="url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg">
            <small class="form-text text-muted">You can either upload an image or paste an external image URL. If both are
                provided, the URL is used.</small>
        </div>
        <div class="mb-3"><label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3"><label>Stock</label><input name="stock" class="form-control"></div>
        <button class="btn btn-primary">Create</button>
    </form>
@endsection
