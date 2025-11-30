@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit category: {{ $category->name }}</h1>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>Back to list
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Classification information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="text-dark">* Category name </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Current image:</label>
                        <div>
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="width: 100px; height: 100px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image" class="text-dark">Change Image</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                            name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="form-text text-muted">Leave blank to keep current image</small>

                    </div>

                    <div class="form-group">

                        <div class="form-check">

                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                {{ $category->is_active ? 'checked' : '' }}>

                            <label class="form-check-label text-dark" for="is_active">
                                Category Active
                            </label>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Category</button>

                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>

                </form>

            </div>
        </div>
    @endsection
