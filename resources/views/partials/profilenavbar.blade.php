@php
    $u = auth()->user();
    $avatarUrl = null;
    if ($u) {
        if (!empty($u->profile_photo_url) && filter_var($u->profile_photo_url, FILTER_VALIDATE_URL)) {
            $avatarUrl = $u->profile_photo_url;
        } elseif (!empty($u->profile_photo_url)) {
            $avatarUrl = \Illuminate\Support\Facades\Storage::url($u->profile_photo_url);
        }
    }

    // Add cache busting for avatar
    $avatarUrlWithVersion = null;
    if (!empty($avatarUrl)) {
        $ts = $u->updated_at ? $u->updated_at->timestamp : time();
        $sep = strpos($avatarUrl, '?') !== false ? '&' : '?';
        $avatarUrlWithVersion = $avatarUrl . $sep . 'v=' . $ts;
    }
@endphp

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle d-flex align-items-center nav-link-custom" href="#" role="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        <div class="user-avatar me-2">
            @if ($avatarUrl)
                <img src="{{ $avatarUrlWithVersion ?? $avatarUrl }}" alt="User" class="rounded-circle"
                    style="width: 32px; height: 32px; object-fit: cover;" />
            @else
                <div class="default-avatar d-flex align-items-center justify-content-center rounded-circle"
                    style="width: 32px; height: 32px; background: linear-gradient(45deg, #2196f3, #1976d2); color: white;">
                    <i class="fas fa-user"></i>
                </div>
            @endif
        </div>
        <span>{{ $u->name ?? 'User' }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="{{ route('userinfo') }}">
                <i class="fas fa-user-circle me-2"></i>Profile
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('profile.show') }}">
                <i class="fas fa-cog me-2"></i>Settings
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
        @csrf
    </form>
</li>

<style>
    /* Profile Dropdown Styles - Matching Header Design */
    .nav-link.dropdown-toggle {
        color: #2196f3 !important;
        padding: 0.75rem 1.25rem !important;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 1.05rem;
    }

    .nav-link.dropdown-toggle:hover {
        background-color: rgba(33, 150, 243, 0.1);
        color: #1976d2 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.2);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 8px 30px rgba(33, 150, 243, 0.15);
        border-radius: 15px;
        padding: 0.5rem 0;
        margin-top: 0.5rem;
        background: white;
    }

    .dropdown-item {
        color: #2196f3 !important;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .dropdown-item:hover {
        background-color: rgba(33, 150, 243, 0.1);
        color: #1976d2 !important;
        transform: translateX(5px);
    }

    .dropdown-item.text-danger {
        color: #dc3545 !important;
    }

    .dropdown-item.text-danger:hover {
        background-color: rgba(220, 53, 69, 0.1);
        color: #c82333 !important;
    }

    .dropdown-item i {
        font-size: 1.1rem;
        margin-right: 0.5rem;
    }

    .dropdown-divider {
        border-top: 1px solid rgba(33, 150, 243, 0.2);
        margin: 0.5rem 0;
    }

    /* User Avatar Styles */
    .user-avatar img {
        border: 2px solid rgba(33, 150, 243, 0.3);
        transition: all 0.3s ease;
    }

    .user-avatar:hover img {
        border-color: #2196f3;
        transform: scale(1.05);
    }

    .default-avatar {
        border: 2px solid rgba(33, 150, 243, 0.3);
        transition: all 0.3s ease;
    }

    .default-avatar:hover {
        border-color: #2196f3;
        transform: scale(1.05);
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .nav-link.dropdown-toggle {
            margin: 0.25rem 0;
            font-size: 1.1rem;
        }
    }
</style>
