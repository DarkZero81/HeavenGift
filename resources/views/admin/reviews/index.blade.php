@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">إدارة التقييمات</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">قائمة التقييمات</h6>
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

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المنتج</th>
                                <th>المستخدم</th>
                                <th>التقييم</th>
                                <th>التعليق</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>
                                        @if ($review->product)
                                            <a href="{{ route('products.show', $review->product) }}" target="_blank">
                                                {{ $review->product->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">منتج محذوف</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($review->user)
                                            {{ $review->user->name }}
                                        @else
                                            <span class="text-muted">مستخدم محذوف</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                            <span class="text-dark">({{ $review->rating }})</span>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($review->comment, 50) }}</td>
                                    <td>
                                        @if ($review->approved)
                                            <span class="badge badge-success">مقبول</span>
                                        @else
                                            <span class="badge badge-warning">بانتظار المراجعة</span>
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if (!$review->approved)
                                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        title="قبول التقييم">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
