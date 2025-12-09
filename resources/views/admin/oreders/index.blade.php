@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">إدارة الطلبات</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">قائمة الطلبات</h6>
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
                                <th>رقم الطلب</th>
                                <th>العميل</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>الإجمالي</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->customer_email }}</td>
                                    <td>{{ $order->customer_phone }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'shipped' => 'primary',
                                                'delivered' => 'success',
                                                'cancelled' => 'danger',
                                            ];
                                        @endphp
                                        <span
                                            class="badge text-{{ $statusColors[$order->status] ?? 'secondary' }} text-dark">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#statusModal{{ $order->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Status Modal -->
                                <div class="modal fade" id="statusModal{{ $order->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">تغيير حالة الطلب #{{ $order->id }}</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>الحالة الحالية:
                                                            <strong>{{ $order->status }}</strong></label>
                                                        <select name="status" class="form-control" required>
                                                            <option value="pending"
                                                                {{ $order->status == 'pending' ? 'selected' : '' }}>معلق
                                                            </option>
                                                            <option value="processing"
                                                                {{ $order->status == 'processing' ? 'selected' : '' }}>قيد
                                                                المعالجة</option>
                                                            <option value="shipped"
                                                                {{ $order->status == 'shipped' ? 'selected' : '' }}>تم
                                                                الشحن</option>
                                                            <option value="delivered"
                                                                {{ $order->status == 'delivered' ? 'selected' : '' }}>تم
                                                                التسليم</option>
                                                            <option value="cancelled"
                                                                {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغى
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                    <button type="submit" class="btn btn-primary">تحديث الحالة</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
