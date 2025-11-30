@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <h2>
        Edit Product</h2>
    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3"><label>Name</label><input name="name" value="{{ $product->name }}" class="form-control"></div>
        <div class="mb-3"><label>Price</label><input name="price" value="{{ $product->price }}" class="form-control"></div>
        <div class="mb-3"><label>Category</label><select name="category_id" class="form-select">
                <option value="">None</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" @if ($product->category_id == $c->id) selected @endif>
                        {{ $c->name }}</option>
                @endforeach
            </select></div>
        <div class="mb-3">
            <label>Image (upload or external URL)</label>
            @if ($product->image)
                <div class="mb-2">
                    @if (filter_var($product->image, FILTER_VALIDATE_URL))
                        <img src="{{ $product->image }}" style="height:80px">
                    @else
                        <img src="{{ asset('storage/' . $product->image) }}" style="height:80px">
                    @endif
                </div>
            @endif
            <input type="file" name="image" class="form-control mb-2">
            <input type="url" name="image_url"
                value="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : '' }}" class="form-control"
                placeholder="https://example.com/image.jpg">
            <small class="form-text text-muted">If both upload and URL are provided, the URL will be used.</small>
        </div>
        <div class="mb-3"><label>Description</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>
        <div class="mb-3"><label>Stock</label><input name="stock" value="{{ $product->stock }}" class="form-control">
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
@endsection
