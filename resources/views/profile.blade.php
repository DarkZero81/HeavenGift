@extends('layouts.admin')

@section('title', 'User Profile Settings')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white py-3 border-bottom border-primary">
                        <h4 class="mb-0">User Profile Settings</h4>
                    </div>
                    <div class="card-body p-4 p-md-5">

                        {{-- نموذج التعديل: الأهم هو إضافة enctype="multipart/form-data" --}}
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                            id="profile-form">
                            @csrf
                            @method('PUT')

                            {{-- رسائل التنبيه والخطأ --}}
                            @if (session('status') === 'profile-updated')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Profile updated successfully!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="text-center mb-5">
                                {{-- صورة الملف الشخصي --}}
                                <img src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/150?text=User' }}"
                                    alt="Profile Image" class="rounded-circle mb-3"
                                    style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #adb5bd;">

                                {{-- وسم المسؤولية --}}
                                @if ($user->is_admin ?? false)
                                    <span class="badge bg-primary text-uppercase fs-6 d-block mx-auto"
                                        style="width: fit-content;">Admin</span>
                                @else
                                    <span class="badge bg-secondary text-uppercase fs-6 d-block mx-auto"
                                        style="width: fit-content;">User</span>
                                @endif
                            </div>

                            {{-- =================================== --}}
                            {{-- حقول تحديث الصورة --}}
                            {{-- =================================== --}}
                            <div class="row g-4 mb-4">
                                <h5 class="text-primary mb-3">Update Profile Picture</h5>

                                {{-- الحقل الأول: رفع الصورة من الجهاز --}}
                                <div class="col-md-6">
                                    <label for="profile_image_file" class="form-label">Upload New Photo (File)</label>
                                    <input type="file" class="form-control" id="profile_image_file"
                                        name="profile_image_file" accept="image/*">
                                    <div class="form-text">Max size 2MB. JPG, PNG, GIF accepted.</div>
                                </div>

                                {{-- الحقل الثاني: رابط الصورة --}}
                                <div class="col-md-6">
                                    <label for="profile_image_url" class="form-label">Or Enter Image URL</label>
                                    <input type="text" class="form-control" id="profile_image_url"
                                        name="profile_image_url" value="{{ old('profile_image_url') }}"
                                        placeholder="e.g., https://example.com/photo.jpg">
                                    <div class="form-text">Paste a direct link to the image.</div>
                                </div>
                            </div>
                            <hr class="my-4">
                            {{-- =================================== --}}

                            <div class="row g-4">
                                {{-- الحقل: الاسم الكامل --}}
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>

                                {{-- الحقل: البريد الإلكتروني --}}
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>

                                <hr class="my-4">

                                {{-- الحقل: كلمة المرور (للتأكيد أو التغيير) --}}
                                <div class="col-md-6">
                                    <label for="password" class="form-label">New Password (optional)</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Leave blank to keep current password">
                                </div>

                                {{-- الحقل: تأكيد كلمة المرور --}}
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm new password">
                                </div>

                                <hr class="my-4">

                                {{-- الحقول للقراءة فقط --}}
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Member Since</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="{{ $user->created_at->format('Y-m-d') }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Last Updated</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="{{ $user->updated_at->format('Y-m-d H:i') }}" readonly>
                                </div>
                            </div>

                            {{-- أزرار الإجراءات --}}
                            <div class="d-flex justify-content-end gap-3 mt-5">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Update Profile
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // كود JavaScript لضمان أن المستخدم يملأ حقلاً واحداً فقط للصورة
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('profile_image_file');
            const urlInput = document.getElementById('profile_image_url');

            // إذا رفع ملف، امسح حقل الرابط
            fileInput.addEventListener('change', function() {
                if (fileInput.value) {
                    urlInput.value = '';
                }
            });

            // إذا كتب رابط، امسح حقل الملف
            urlInput.addEventListener('input', function() {
                if (urlInput.value) {
                    fileInput.value = '';
                }
            });
        });
    </script>
@endsection
