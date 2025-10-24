<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu-admin-trash.css') }}">
</head>

<body class="d-flex body-bg">

    @php
        // เก็บ path ปัจจุบัน เช่น 'admin/trash_can_installation'
        $path = request()->path();
    @endphp

    <!-- Sidebar -->
    <div class="d-flex flex-column flex-shrink-0 sidebar-bg p-3" style="width: 250px;">
        <img src="{{ url('../img/trash-system/Coin.png') }}" alt="Coin" class="img-fluid logo-img">
        <div class="d-flex flex-column justify-content-center align-items-center mb-3 mb-md-0 text-decoration-none">
            <div>ระบบจัดการค่าบริการจัดการ
            </div>
            <h1>ขยะมูลฝอย</h1>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="/admin/waste_payment"
                    class="nav-link {{ Str::contains($path, 'waste_payment') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill pe-2"></i> Dashboard
                </a>
            </li>

            <div class="mt-3 fw-bold">
                <h4>จัดการ <img src="{{ url('../img/trash-system/Manage-icon.png') }}" alt="Manage-icon"
                        class="img-fluid logo-img">
                </h4>
            </div>

            <li>
                <a href="/admin/showdata" class="nav-link {{ Str::contains($path, 'showdata') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-1.png') }}" alt="icon-1" class="img-fluid logo-img">
                    ข้อมูลฟอร์มที่ส่งเข้ามา
                </a>
            </li>

            <li>
                <a href="/admin/trash_can_installation"
                    class="nav-link {{ Str::contains($path, 'trash_can_installation') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-3.png') }}" alt="icon-3" class="img-fluid logo-img">
                    ตำแหน่งที่ติดตั้งถังขยะ
                </a>
            </li>

            <li>
                <a href="/admin/trash_installer"
                    class="nav-link {{ Str::contains($path, 'trash_installer') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-2.png') }}" alt="icon-2" class="img-fluid logo-img">
                    ผู้ใช้บริการติดตั้งถังขยะ
                </a>
            </li>

            <div class="mt-3 fw-bold">
                <h4>รายงาน <img src="{{ url('../img/trash-system/Report-icon.png') }}" alt="Manage-icon"
                        class="img-fluid logo-img">
                </h4>
            </div>
            <li>
                <a href="/admin/verify_payment"
                    class="nav-link {{ Str::contains($path, 'verify_payment') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-7.png') }}" alt="icon-7" class="img-fluid logo-img">
                    ตรวจสอบการชำระเงิน
                </a>
            </li>

            <li>
                <a href="/admin/payment_history"
                    class="nav-link {{ Str::contains($path, 'payment_history') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-6.png') }}" alt="icon-6" class="img-fluid logo-img">
                    ประวัติการชำระเงิน
                </a>
            </li>

            <li>
                <a href="/admin/non_payment"
                    class="nav-link {{ Str::contains($path, 'non_payment') ? 'active' : '' }}">
                    <img src="{{ url('../img/trash-system/icon-7.png') }}" alt="icon-7" class="img-fluid logo-img">
                    บิลที่รอการชำระเงิน
                </a>
            </li>
        </ul>
    </div>

    <div class="p-4" style="flex:1;">
        {{-- search bar --}}
        <div class="bg-white my-4 p-2 rounded-3 d-flex align-items-end justify-content-end">
            <div class="nav-item dropdown">
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
                        <!-- บรรทัดแรก: รูป Avatar + ชื่อผู้ใช้งาน -->
                        <li class="dropdown-item-text d-flex align-items-end gap-2">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ $tokenData['name'] }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <!-- บรรทัดสอง: Logout -->
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

        {{-- content --}}
        <div class="content-trash-bg px-2 py-4 rounded-3">
            @yield('content')
        </div>
    </div>

</body>

</html>

<style>
    .search-menu {
        border: none;
        outline: none;
        box-shadow: none;
        background: transparent;
    }

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

    /* สีลิงก์ใน sidebar */
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
</style>
