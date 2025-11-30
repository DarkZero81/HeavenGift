@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">إدارة الكوبونات</h1>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">إضافة كوبون جديد</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.coupons.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="code">كود الكوبون *</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="discount_percent">نسبة الخصم % *</label>
                                <input type="number" class="form-control @error('discount_percent') is-invalid @enderror"
                                    id="discount_percent" name="discount_percent" value="{{ old('discount_percent', 10) }}"
                                    min="1" max="100" required>
                                @error('discount_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="user_id">مخصص لمستخدم (اختياري)</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id"
                                    name="user_id">
                                    <option value="">جميع المستخدمين</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="expires_at">تاريخ الانتهاء (اختياري)</label>
                                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                    id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="max_uses">الحد الأقصى للاستخدام (اختياري)</label>
                                <input type="number" class="form-control @error('max_uses') is-invalid @enderror"
                                    id="max_uses" name="max_uses" value="{{ old('max_uses') }}" min="1">
                                @error('max_uses')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">إنشاء الكوبون</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">قائمة الكوبونات</h6>
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
                                        <th>الكود</th>
                                        <th>الخصم %</th>
                                        <th>المستخدم</th>
                                        <th>المستخدم</th>
                                        <th>المتبقي</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>
                                                <strong>{{ $coupon->code }}</strong>
                                                @if ($coupon->user)
                                                    <br><small class="text-muted">مخصص لـ {{ $coupon->user->name }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $coupon->discount_percent }}%</td>
                                            <td>
                                                @if ($coupon->expires_at)
                                                    {{ $coupon->expires_at->format('Y-m-d') }}
                                                    @if ($coupon->expires_at->isPast())
                                                        <br><small class="text-danger">منتهي</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">لا نهائي</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->max_uses)
                                                    {{ $coupon->used_count }} / {{ $coupon->max_uses }}
                                                @else
                                                    <span class="text-muted">لا نهائي</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->is_active)
                                                    <span class="badge text-success">نشط</span>
                                                @else
                                                    <span class="badge text-danger">غير نشط</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                        data-target="#editCouponModal{{ $coupon->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('هل أنت متأكد من حذف هذا الكوبون؟')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editCouponModal{{ $coupon->id }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.coupons.update', $coupon) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">تعديل الكوبون {{ $coupon->code }}</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>كود الكوبون</label>
                                                                <input type="text" class="form-control" name="code"
                                                                    value="{{ $coupon->code }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>نسبة الخصم %</label>
                                                                <input type="number" class="form-control"
                                                                    name="discount_percent"
                                                                    value="{{ $coupon->discount_percent }}"
                                                                    min="1" max="100" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>مخصص لمستخدم</label>
                                                                <select class="form-control" name="user_id">
                                                                    <option value="">جميع المستخدمين</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}"
                                                                            {{ $coupon->user_id == $user->id ? 'selected' : '' }}>
                                                                            {{ $user->name }} ({{ $user->email }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>تاريخ الانتهاء</label>
                                                                <input type="datetime-local" class="form-control"
                                                                    name="expires_at"
                                                                    value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '' }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>الحد الأقصى للاستخدام</label>
                                                                <input type="number" class="form-control"
                                                                    name="max_uses" value="{{ $coupon->max_uses }}"
                                                                    min="1">
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_active" value="1"
                                                                        {{ $coupon->is_active ? 'checked' : '' }}>
                                                                    <label class="form-check-label">الكوبون نشط</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary">تحديث</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
