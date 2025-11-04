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
    <link rel="stylesheet" href="{{ asset('css/menurequestadmin.css') }}">
</head>

<body class="d-flex body-bg">

    @php
        // เก็บ path ปัจจุบัน เช่น 'admin/trash_can_installation'
        $path = request()->path();
    @endphp

    <!-- Sidebar -->
    <div class="flex-shrink-0 border-end sidebar-bg" style="width: 280px;">
        @php
            $path = request()->path();

            // ตรวจคำใน path
            $isPublicHealth = str_contains($path, 'public-health');
            $isEngineering = str_contains($path, 'engineering');

            // ตั้งชื่อหัวเรื่อง
            $departmentName = 'ระบบใบคำร้อง';
            if ($isPublicHealth) {
                $departmentName = 'กองสาธารณสุข';
            } elseif ($isEngineering) {
                $departmentName = 'กองช่าง';
            }
        @endphp

        <!-- หัวข้อหลัก -->
        <div class="d-flex align-items-center justify-content-center link-dark text-decoration-none border-bottom">
            @if ($isEngineering)
                <img src="{{ url('../img/admin-request/2.png') }}" alt="Coin" class="img-fluid logo-img">
            @else
                <img src="{{ url('../img/admin-request/1.png') }}" alt="Coin" class="img-fluid logo-img">
            @endif
        </div>
        <div class="d-flex align-items-center justify-content-center header-sidebar">
            <h2>{{ $departmentName }}</h2>
        </div>

        <ul class="list-unstyled ps-3">
            @if ($isEngineering)
                @php
                    $menus = [
                        'new' => 'new-license-engineer',
                        // 'renew' => 'renew-license-engineer',
                    ];
                @endphp

                @foreach ($menus as $key => $menuPath)
                    <li class="mb-1">
                        @php $showCollapse = str_contains($path, $menuPath); @endphp
                        <button
                            class="btn btn-toggle align-items-center rounded w-100 text-start {{ $showCollapse ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse" data-bs-target="#{{ $key }}-collapse"
                            aria-expanded="{{ $showCollapse ? 'true' : 'false' }}">
                            <span class="icon me-2">{{ $showCollapse ? '✔' : '+' }}</span>
                            @if ($key == 'new')
                                คำขอใบอนุญาตก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร
                            @elseif($key == 'renew')
                                คำขอต่ออายุใบอนุญาตก่อสร้างฯ
                            @endif
                        </button>

                        <div class="collapse {{ $showCollapse ? 'show' : '' }}" id="{{ $key }}-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="/admin/request/engineering/showdata/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "showdata/$menuPath") ? 'active-submenu' : '' }}">รับเรื่อง</a>
                                </li>
                                <li><a href="/admin/request/engineering/appointment/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "appointment/$menuPath") ? 'active-submenu' : '' }}">การนัดหมาย</a>
                                </li>
                                <li><a href="/admin/request/engineering/explore/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "explore/$menuPath") ? 'active-submenu' : '' }}">ออกสำรวจ</a>
                                </li>
                                <li><a href="/admin/request/engineering/confirm_payment/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "confirm_payment/$menuPath") ? 'active-submenu' : '' }}">ชำระเงิน</a>
                                </li>
                                <li><a href="/admin/request/engineering/Issue-a-license/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "Issue-a-license/$menuPath") ? 'active-submenu' : '' }}">ออกใบอนุญาต</a>
                                </li>
                                <li><a href="/admin/request/engineering/renew-license/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "renew/$menuPath") ? 'active-submenu' : '' }}">ใบอนุญาตใกล้หมดอายุ</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endforeach
            @elseif ($isPublicHealth)
                @php
                    $menus = [
                        'market' => 'market-establishment-license',
                        'food' => 'food-sales-license',
                        'hazard' => 'health-hazard-license',
                        'waste' => 'waste-disposal-business-license',
                    ];
                @endphp

                @foreach ($menus as $key => $menuPath)
                    <li class="mb-1">
                        @php $showCollapse = str_contains($path, $menuPath); @endphp
                        <button
                            class="btn btn-toggle align-items-center rounded w-100 text-start {{ $showCollapse ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse" data-bs-target="#{{ $key }}-collapse"
                            aria-expanded="{{ $showCollapse ? 'true' : 'false' }}">
                            <span class="icon me-2">{{ $showCollapse ? '✔' : '+' }}</span>
                            @if ($key == 'market')
                                คำขอรับใบอนุญาตจัดตั้งตลาด
                            @elseif($key == 'food')
                                คำขอรับใบอนุญาตจัดตั้งสถานที่จำหน่ายอาหาร หรือสะสมอาหาร
                            @elseif($key == 'hazard')
                                คำขอรับใบอนุญาตประกอบกิจการที่เป็นอันตรายต่อสุขภาพ
                            @elseif($key == 'waste')
                                คำขอรับใบอนุญาตประกอบกิจการเก็บ ขน หรือกำจัดสิ่งปฏิกูลฯ
                            @endif
                        </button>
                        <div class="collapse {{ $showCollapse ? 'show' : '' }}" id="{{ $key }}-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="/admin/request/public-health/showdata/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "showdata/$menuPath") ? 'active-submenu' : '' }}">รับเรื่อง</a>
                                </li>
                                <li><a href="/admin/request/public-health/appointment/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "appointment/$menuPath") ? 'active-submenu' : '' }}">การนัดหมาย</a>
                                </li>
                                <li><a href="/admin/request/public-health/explore/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "explore/$menuPath") ? 'active-submenu' : '' }}">ออกสำรวจ</a>
                                </li>
                                <li><a href="/admin/request/public-health/confirm_payment/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "confirm_payment/$menuPath") ? 'active-submenu' : '' }}">ชำระเงิน</a>
                                </li>
                                <li><a href="/admin/request/public-health/Issue-a-license/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "Issue-a-license/$menuPath") ? 'active-submenu' : '' }}">ออกใบอนุญาต</a>
                                </li>
                                <li><a href="/admin/request/public-health/renew-license/{{ $menuPath }}"
                                        class="link-dark rounded {{ str_contains($path, "renew/$menuPath") ? 'active-submenu' : '' }}">ใบอนุญาตใกล้หมดอายุ</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endforeach
            @else
                <li class="text-muted text-center mt-3">ไม่พบหน่วยงานที่เกี่ยวข้อง</li>
            @endif
        </ul>

    </div>

    <div class="p-4" style="flex:1;">
        {{-- search bar --}}
        <div class="bg-white my-4 p-2 rounded-3 d-flex align-items-center justify-content-end">

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
                        <li class="dropdown-item-text d-flex align-items-center gap-2">
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
        <div class="content-bg p-2 rounded-5 p-5">
            @yield('content')
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.has-sub-sub > a').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;

                    // ปิด submenu อื่น ๆ
                    document.querySelectorAll('.submenu-sub').forEach(s => {
                        if (s !== submenu) s.style.maxHeight = null;
                    });

                    // toggle submenu ที่คลิก
                    if (submenu.style.maxHeight) {
                        submenu.style.maxHeight = null; // ปิด
                    } else {
                        submenu.style.maxHeight = submenu.scrollHeight + "px"; // เปิดสมูท
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ตั้งค่าเริ่มต้น
            document.querySelectorAll('.btn-toggle').forEach(btn => {
                const icon = btn.querySelector('.icon');
                const target = document.querySelector(btn.dataset.bsTarget);

                target.addEventListener('shown.bs.collapse', () => {
                    icon.textContent = '✔';
                });

                target.addEventListener('hidden.bs.collapse', () => {
                    icon.textContent = '+';
                });
            });
        });
    </script>


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
