@extends('layouts.admin')
<div id="categories-container">
    @include('admin.categories._table')
</div>
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
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail"
                        style="width: 60px; height: 60px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-image text-muted"></i>
                    </div>
                @endif
            </td>
            <td>
                @php
                    $searchQ = $q ?? request('q');
                    $escapedName = e($category->name);
                    $escapedQ = e($searchQ);
                @endphp
                @if (!empty($searchQ))
                    {!! str_ireplace($escapedQ, '<mark>' . $escapedQ . '</mark>', $escapedName) !!}
                @else
                    {{ $category->name }}
                @endif
            </td>
            <td class="text-center">{{ $category->products_count ?? 0 }}</td>
            <td class="text-center">
                @if ($category->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Not Active</span>
                @endif
            </td>
            <td>{{ $category->created_at->format('Y-m-d') }}</td>
            <td>
                <div class="btn-group">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
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
                                    <span
                                        class="badge bg-secondary me-2 {{ request()->has('is_active') ? '' : 'fw-bold' }}"
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

                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                <div class="d-flex align-items-center" style="gap:.5rem;">
                                    <!-- Search form -->
                                    <form method="GET" class="d-flex" role="search" aria-label="Search categories">
                                        @foreach (request()->except(['q', 'page']) as $key => $value)
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endforeach
                                        <input type="search" name="q" value="{{ old('q', $q ?? request('q')) }}"
                                            class="form-control form-control-sm" placeholder="Search categories"
                                            aria-label="Search categories">
                                        <button class="btn btn-sm btn-primary" type="submit">Search</button>
                                        @if (request()->query())
                                            <a href="{{ route('admin.categories.index') }}"
                                                class="btn btn-sm btn-outline-secondary" title="Clear filters">Clear</a>
                                        @endif
                                    </form>
                                </div>

                                <div class="d-flex align-items-center" style="gap:.5rem;">
                                    <!-- Per-page selector -->
                                    <form method="GET" class="form-inline" id="perPageForm"
                                        aria-label="Items per page form">
                                        @foreach (request()->except(['per_page', 'page']) as $key => $value)
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endforeach
                                        <label for="per_page" class="mr-2">Per page:</label>
                                        <select name="per_page" id="per_page" class="form-control form-control-sm"
                                            onchange="document.getElementById('perPageForm').submit()"
                                            aria-label="Select items per page">
                                            @foreach ([10, 20, 50, 100] as $n)
                                                <option value="{{ $n }}"
                                                    {{ request('per_page', 20) == $n ? 'selected' : '' }}>
                                                    {{ $n }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <div id="categories-container">
                                @include('admin.categories._table')
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
                            <script>
                                // AJAX pagination & filtering for categories
                                (function() {
                                    const container = document.getElementById('categories-container');
                                    if (!container) return;

                                    function initAjaxLinks(scope) {
                                        scope = scope || document;
                                        // intercept pagination links
                                        scope.querySelectorAll('a.page-link').forEach(link => {
                                            const href = link.getAttribute('href');
                                            if (!href) return;
                                            link.addEventListener('click', function(e) {
                                                // allow downloads or JS-disabled links
                                                if (link.getAttribute('target')) return;
                                                e.preventDefault();
                                                fetchAndReplace(href, true);
                                            });
                                        });
                                    }

                                    function fetchAndReplace(url, push) {
                                        fetch(url, {
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                }
                                            })
                                            .then(r => r.text())
                                            .then(html => {
                                                container.innerHTML = html;
                                                // re-init tooltips
                                                try {
                                                    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                                                        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap
                                                            .Tooltip(el));
                                                    }
                                                } catch (e) {}
                                                initAjaxLinks(container);
                                                // update browser URL
                                                if (push && window.history && window.history.pushState) {
                                                    const parsed = new URL(url, window.location.origin);
                                                    window.history.pushState({}, '', parsed.pathname + parsed.search);
                                                }
                                            });
                                    }

                                    // intercept search and per-page forms
                                    document.querySelectorAll('form[role="search"], #perPageForm, form[action][method="GET"]').forEach(form => {
                                        form.addEventListener('submit', function(e) {
                                            // only handle GET forms
                                            if ((form.method || 'get').toLowerCase() !== 'get') return;
                                            e.preventDefault();
                                            const params = new URLSearchParams(new FormData(form));
                                            const url = form.action + (form.action.indexOf('?') === -1 ? '?' : '&') + params
                                                .toString();
                                            fetchAndReplace(url, true);
                                        });
                                    });

                                    // handle back/forward
                                    window.addEventListener('popstate', function() {
                                        fetchAndReplace(window.location.href, false);
                                    });

                                    // initialize on load
                                    initAjaxLinks(container);
                                })();
                            </script>
                        </div>
                    </div>
                </div>
            @endsection
