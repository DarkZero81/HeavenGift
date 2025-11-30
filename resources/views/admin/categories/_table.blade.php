<div id="categories-table">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Category Name</th>
                    <th class="text-center">Product Amount</th>
                    <th class="text-center">State</th>
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
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
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
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    class="d-inline">
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

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            @if ($categories->total() > 0)
                <p class="mb-0 text-muted">Showing {{ $categories->firstItem() }}&ndash;{{ $categories->lastItem() }} of
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
</div>
