@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category Management</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Category
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">قائمة التصنيفات</h6>
                <div class="d-flex align-items-center" aria-hidden="false">
                    @php
                        $baseParams = request()->except(['page']);
                    @endphp
                    <a href="{{ route('admin.categories.index', array_merge($baseParams, [])) }}"
                        class="text-decoration-none" aria-label="Show all categories">
                        <span class="badge bg-secondary me-2 {{ request()->has('is_active') ? '' : 'fw-bold' }}"
                            data-bs-toggle="tooltip" title="Show all categories">Total:
                            {{ $total ?? $categories->total() }}</span>
                    </a>
                    <a href="{{ route('admin.categories.index', array_merge($baseParams, ['is_active' => 1])) }}"
                        class="text-decoration-none" aria-label="Show active categories">
                        <span class="badge bg-success me-2 {{ request('is_active') === '1' ? 'fw-bold' : '' }}"
                            data-bs-toggle="tooltip" title="Show only active categories">Active:
                            {{ $activeCount ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.categories.index', array_merge($baseParams, ['is_active' => 0])) }}"
                        class="text-decoration-none" aria-label="Show inactive categories">
                        <span class="badge bg-danger {{ request('is_active') === '0' ? 'fw-bold' : '' }}"
                            data-bs-toggle="tooltip" title="Show only inactive categories">Inactive:
                            {{ $inactiveCount ?? 0 }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <!-- Per-page selector -->
                        <form method="GET" class="form-inline" id="perPageForm" aria-label="Items per page form">
                            @foreach (request()->except(['per_page', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <label for="per_page" class="mr-2">Items per page:</label>
                            <select name="per_page" id="per_page" class="form-control form-control-sm mr-2"
                                onchange="document.getElementById('perPageForm').submit()"
                                aria-label="Select items per page">
                                @foreach ([10, 20, 50, 100] as $n)
                                    <option value="{{ $n }}"
                                        {{ request('per_page', 20) == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div>
                        <!-- Clear filters button -->
                        @if (request()->query())
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary"
                                title="Clear filters">Clear filters</a>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Category Name</th>
                                <th>Product Amount</th>
                                <th>State</th>
                                <th>Add Date</th>
                                <th>Prcedures</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}" class="img-thumbnail"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->products_count ?? 0 }}</td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge text-success">Active</span>
                                        @else
                                            <span class="badge text-danger">Not Active</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا التصنيف؟')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination and summary -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        @if ($categories->total() > 0)
                            <p class="mb-0 text-muted">Showing
                                {{ $categories->firstItem() }}&ndash;{{ $categories->lastItem() }} of
                                {{ $categories->total() }}</p>
                        @else
                            <p class="mb-0 text-muted">No categories found.</p>
                        @endif
                    </div>
                    <div>
                        <nav aria-label="Categories pagination">
                            {{ $categories->links('vendor.pagination.custom') }}
                        </nav>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        try {
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                                tooltipTriggerList.forEach(function(el) {
                                    new bootstrap.Tooltip(el);
                                });
                            }
                        } catch (e) {
                            // ignore if bootstrap isn't available
                            console && console.debug && console.debug('Tooltip init skipped', e);
                        }
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
