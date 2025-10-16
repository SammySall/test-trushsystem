<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="d-flex bg-body-secondary">

    @php
        // เก็บ path ปัจจุบัน เช่น 'admin/trash_can_installation'
        $path = request()->path();
    @endphp

    <!-- Sidebar -->
    <div class="d-flex flex-column flex-shrink-0 bg-white p-3" style="width: 250px; height: 100vh;">
        <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
            <span class="fs-4">
                <i class="bi bi-database-fill me-2" style="color:#696cff;"></i>
                ระบบค่าขยะ
            </span>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="/admin/waste_payment"
                    class="nav-link {{ Str::contains($path, 'waste_payment') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill pe-2"></i> Dashboard
                </a>
            </li>

            <div class="mt-3 fw-bold">Manage</div>

            <li>
                <a href="/admin/showdata" class="nav-link {{ Str::contains($path, 'showdata') ? 'active' : '' }}">
                    ข้อมูลฟอร์มที่ส่งเข้ามา
                </a>
            </li>

            <li>
                <a href="/admin/trash_can_installation"
                    class="nav-link {{ Str::contains($path, 'trash_can_installation') ? 'active' : '' }}">
                    ตำแหน่งที่ติดตั้งถังขยะ
                </a>
            </li>

            <li>
                <a href="/admin/trash_installer"
                    class="nav-link {{ Str::contains($path, 'trash_installer') ? 'active' : '' }}">
                    ผู้ใช้บริการติดตั้งถังขยะ
                </a>
            </li>

            <div class="mt-3 fw-bold">Report</div>

            <li>
                <a href="/admin/verify_payment"
                    class="nav-link {{ Str::contains($path, 'verify_payment') ? 'active' : '' }}">
                    ตรวจสอบการชำระเงิน
                </a>
            </li>

            <li>
                <a href="/admin/payment_history"
                    class="nav-link {{ Str::contains($path, 'payment_history') ? 'active' : '' }}">
                    ประวัติการชำระเงิน
                </a>
            </li>

            <li>
                <a href="/admin/non_payment"
                    class="nav-link {{ Str::contains($path, 'non_payment') ? 'active' : '' }}">
                    บิลที่รอการชำระเงิน
                </a>
            </li>
        </ul>
    </div>

    <div class="p-4" style="flex:1;">
        {{-- search bar --}}
        <div class="bg-white my-4 p-2 rounded-3 d-flex align-items-center justify-content-between">
            <form class="d-flex align-items-center mb-0">
                <i class="bi bi-search me-2"></i>
                <input type="search" class="search-menu" placeholder="Search..." aria-label="Search">
            </form>

            <div class="avatar">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

        {{-- content --}}
        <div class="bg-white p-2 rounded-3">
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
