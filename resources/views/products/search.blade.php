@extends('layouts.app')

@section('title', 'Search Results - ' . $searchQuery)

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Search Results for "{{ $searchQuery }}"</h2>

                @if ($products->count() > 0)
                    <p class="text-muted mb-4">Found {{ $products->total() }} product(s)</p>
                @else
                    <div class="alert alert-warning">
                        <h4>No products found</h4>
                        <p>We couldn't find any products matching "{{ $searchQuery }}".</p>
                        <p>Try:</p>
                        <ul>
                            <li>Checking your spelling</li>
                            <li>Using more general keywords</li>
                            <li>Browsing our categories</li>
                        </ul>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Browse All Products</a>
                    </div>
                @endif

                @if ($products->count() > 0)
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-4">
                                @include('partials.product_card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
