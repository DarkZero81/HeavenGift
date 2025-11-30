@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">تفاصيل الطلب #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> رجوع
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">عناصر الطلب</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>المنتج</th>
                                        <th>السعر</th>
                                        <th>الكمية</th>
                                        <th>المجموع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                @if ($item->product)
                                                    {{ $item->product->name }}
                                                @else
                                                    {{ $item->name }} (محذوف)
                                                @endif
                                            </td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>الإجمالي:</strong></td>
                                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">معلومات العميل</h6>
                    </div>
                    <div class="card-body text-info">
                        <p><strong>الاسم:</strong> {{ $order->customer_name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $order->customer_email }}</p>
                        <p><strong>الهاتف:</strong> {{ $order->customer_phone }}</p>
                        <p><strong>العنوان:</strong> {{ $order->customer_address }}</p>
                        @if ($order->user)
                            <p><strong>حساب المستخدم:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
                        @endif
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">حالة الطلب</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="text-dark">State:</label>
                                <select name="status" class="form-control" required>
                                    @foreach ($statuses as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ $order->status == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">تحديث الحالة</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
