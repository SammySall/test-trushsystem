<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin-emergency.css') }}">
</head>

<body class="bg-body-secondary">

    @php
        $path = request()->path();
    @endphp

    <!-- Main content -->
    <div class="d-flex flex-column flex-md-row" style="min-height:100vh;">
        <div class="offcanvas-md offcanvas-start bg-white" tabindex="-1" id="sidebarOffcanvas"
            aria-labelledby="sidebarOffcanvasLabel" style="width:250px;">
            <div class="d-flex align-items-center p-3 border-bottom">
                <img src="{{ url('../img/admin-emergency/11.png') }}" alt="Logo" class="img-fluid logo-img">
            </div>
            <div class="d-flex align-items-center justify-content-center header-sidebar">
                <h2 class="fs-5">แจ้งเหตุฉุกเฉิน</h2>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="/admin/emergency/dashboard"
                        class="nav-link text-center {{ Str::contains($path, 'dashboard') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart-fill pe-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/admin/emergency/accident"
                        class="nav-link text-center {{ Str::contains($path, 'accident') ? 'active' : '' }}">
                        <img src="{{ url('../img/admin-emergency/1.png') }}" width="25rem"> เหตุฉุกเฉิน
                    </a>
                </li>
                <li>
                    <a href="/admin/emergency/fire"
                        class="nav-link text-center {{ Str::contains($path, 'fire') ? 'active' : '' }}">
                        <img src="{{ url('../img/admin-emergency/2.png') }}" width="25rem"> เหตุไฟไหม้
                    </a>
                </li>
                <li>
                    <a href="/admin/emergency/tree-fall"
                        class="nav-link text-center {{ Str::contains($path, 'tree-fall') ? 'active' : '' }}">
                        <img src="{{ url('../img/admin-emergency/3.png') }}" width="25rem"> เหตุต้นไม้ล้ม
                    </a>
                </li>
                <li>
                    <a href="/admin/emergency/broken-road"
                        class="nav-link text-center {{ Str::contains($path, 'broken-road') ? 'active' : '' }}">
                        <img src="{{ url('../img/admin-emergency/4.png') }}" width="25rem"> เหตุถนนเสีย
                    </a>
                </li>
                <li>
                    <a href="/admin/emergency/elec-broken"
                        class="nav-link text-center {{ Str::contains($path, 'elec-broken') ? 'active' : '' }}">
                        <img src="{{ url('../img/admin-emergency/5.png') }}" width="25rem"> เหตุต้นไฟเสีย
                    </a>
                </li>
            </ul>
        </div>

        <main class="flex-fill p-4">
            <div class="bg-white my-4 p-2 rounded-3 d-flex align-items-center justify-content-between">
                <div class="nav-item dropdown ms-auto">
                    <a class="nav-link avatar" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if (session('token'))
                            @php
                                $tokenData = json_decode(
                                    \Illuminate\Support\Facades\Crypt::decryptString(session('token')),
                                    true,
                                );
                            @endphp
                            <li class="dropdown-item-text d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ $tokenData['name'] }}</span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="/login">Login</a></li>
                            <li><a class="dropdown-item" href="/register">Register</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="body-bg p-2 rounded-3">
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>

<style>
    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.375rem;
        height: 2.375rem;
        cursor: pointer;
    }

    .avatar i {
        font-size: 2.375rem;
    }

    .nav-link {
        color: #333;
        border-radius: 0.5rem;
        margin-bottom: 4px;
    }

    .nav-link:hover {
        background-color: #f0f0f0;
    }

    .nav-link.active {
        background-color: #696cff;
        color: white !important;
    }

    /* @media (max-width: 767.98px) {
        /* เมื่อจอเล็กให้ซ่อน sidebar คงที่ */
    .offcanvas-md {
        width: 250px !important;
    }
    }

    */
</style>
