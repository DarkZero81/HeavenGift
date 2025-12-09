@extends('layouts.app')
{{-- افترضت أن لديك ملف 'layouts.app' كملف تخطيط أساسي --}}

@section('title', 'الملف الشخصي للمستخدم')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">ملف المستخدم الشخصي</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            {{-- صورة الملف الشخصي --}}
                            <img src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/150?text=User' }}"
                                alt="صورة الملف الشخصي" class="rounded-circle mb-3"
                                style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #f8f9fa;">

                            {{-- اسم المستخدم --}}
                            <h3 class="card-title">{{ $user->name }}</h3>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-3 text-primary">معلومات الحساب:</h5>
                            </div>

                            {{-- اسم المستخدم الكامل --}}
                            <div class="col-md-6 mb-3">
                                <p><strong>الاسم الكامل:</strong></p>
                                <p class="form-control-plaintext">{{ $user->name }}</p>
                            </div>

                            {{-- البريد الإلكتروني --}}
                            <div class="col-md-6 mb-3">
                                <p><strong>البريد الإلكتروني:</strong></p>
                                <p class="form-control-plaintext">{{ $user->email }}</p>
                            </div>

                            {{-- تاريخ الانضمام --}}
                            <div class="col-md-6 mb-3">
                                <p><strong>تاريخ الانضمام:</strong></p>
                                <p class="form-control-plaintext">{{ $user->created_at->format('Y-m-d') }}</p>
                            </div>

                            {{-- آخر تحديث --}}
                            <div class="col-md-6 mb-3">
                                <p><strong>آخر تحديث:</strong></p>
                                <p class="form-control-plaintext">{{ $user->updated_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            {{-- زر لتعديل المعلومات (اختياري) --}}
                            <a href="{{ route('profile.edit') ?? '#' }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square me-1"></i> تعديل الملف الشخصي
                            </a>

                            {{-- زر للعودة --}}
                            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                                <i class="bi bi-arrow-right-short"></i> عودة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
