@extends('layouts.app')

@section('title', isset($selectedCategory) ? $selectedCategory->name : 'Products')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <h5>Categories</h5>
            <ul class="list-group">
                @foreach ($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                        class="list-group-item list-group-item-action {{ isset($selectedCategory) && $selectedCategory->id == $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </ul>
        </div>

        <div class="col-md-9">
            <h3 class="mb-4">{{ isset($selectedCategory) ? $selectedCategory->name : 'All Products' }}</h3>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        @include('partials.product_card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">No products found.</div>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
