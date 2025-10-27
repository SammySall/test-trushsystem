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

<body class="d-flex bg-body-secondary">

    @php
        // เก็บ path ปัจจุบัน เช่น 'admin/trash_can_installation'
        $path = request()->path();
    @endphp

    <!-- Sidebar -->

    <!-- Sidebar -->
    <!-- Sidebar -->
    <div class="flex-shrink-0 p-3 bg-white border-end" style="width: 280px; height: 100vh;">
        @php
            $path = request()->path();

            // ตรวจคำใน path
            $isPublicHealth = str_contains($path, 'public-health');
            $isEngineering = str_contains($path, 'engineering');

            // ตั้งชื่อหัวเรื่อง
            $departmentName = 'ระบบใบคำร้อง';
            if ($isPublicHealth) {
                $departmentName = 'กองสาธารณสุขฯ';
            } elseif ($isEngineering) {
                $departmentName = 'กองช่าง';
            }
        @endphp

        <!-- หัวข้อหลัก -->
        <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <i class="bi bi-database-fill me-2 fs-4" style="color:#696cff;"></i>
            <span class="fs-6 fw-semibold">{{ $departmentName }}</span>
        </a>

        <ul class="list-unstyled ps-0">
            {{-- ✅ ถ้าเป็นกองช่าง --}}
            @if ($isEngineering)
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start"
                        data-bs-toggle="collapse" data-bs-target="#new-collapse" aria-expanded="false">
                        คำขอใบอนุญาตก่อสร้าง
                    </button>
                    <div class="collapse" id="new-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="/admin/request/engineering/showdata/new-license-engineer" class="link-dark rounded">รับเรื่อง</a></li>
                            <li><a href="#" class="link-dark rounded">การนัดหมาย</a></li>
                            <li><a href="#"
                                    class="link-dark rounded">ออกสำรวจ</a></li>
                            <li><a href="/admin/request/engineering/showdata/new-license-engineer"
                                    class="link-dark rounded">ชำระเงิน</a></li>
                            <li><a href="/admin/request/engineering/showdata/new-license-engineer"
                                    class="link-dark rounded">ออกใบอนุญาต</a></li>
                            <li><a href="/admin/request/engineering/showdata/new-license-engineer"
                                    class="link-dark rounded">ใบอนุญาตใกล้หมดอายุ</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start"
                        data-bs-toggle="collapse" data-bs-target="#renew-collapse" aria-expanded="false">
                        คำขอต่ออายุใบอนุญาตก่อสร้างฯ
                    </button>
                    <div class="collapse" id="renew-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="/admin/request/engineering/showdata/renew-license-engineer" class="link-dark rounded">รับเรื่อง</a></li>
                            <li><a href="#" class="link-dark rounded">การนัดหมาย</a></li>
                            <li><a href="/admin/request/engineering/showdata/renew-licenseengineer"
                                    class="link-dark rounded">ออกสำรวจ</a></li>
                            <li><a href="/admin/request/engineering/showdata/renew_license_engineer"
                                    class="link-dark rounded">ชำระเงิน</a></li>
                            <li><a href="/admin/request/engineering/showdata/renew_license_engineer"
                                    class="link-dark rounded">ออกใบอนุญาต</a></li>
                            <li><a href="/admin/request/engineering/showdata/renew_license_engineer"
                                    class="link-dark rounded">ใบอนุญาตใกล้หมดอายุ</a></li>
                        </ul>
                    </div>
                </li>

                {{-- ✅ ถ้าเป็นกองสาธารณสุข --}}
            @elseif ($isPublicHealth)
                {{-- <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start"
                        data-bs-toggle="collapse" data-bs-target="#trash-collapse" aria-expanded="false">
                        คำร้องขออนุญาตลงถังขยะ
                    </button>
                    <div class="collapse" id="trash-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="/admin/request/public-health/showdata/trash-request"
                                    class="link-dark rounded">รับเรื่อง</a></li>
                            <li><a href="/admin/request/public-health/appointment/trash-request"
                                    class="link-dark rounded">การนัดหมาย</a></li>
                            <li><a href="/admin/request/public-health/explore/trash-request"
                                    class="link-dark rounded">ออกสำรวจ</a></li>
                            <li><a href="/user/engineering/history/renew_license_engineer"
                                    class="link-dark rounded">ชำระเงิน</a></li>
                            <li><a href="/user/engineering/history/renew_license_engineer"
                                    class="link-dark rounded">ออกใบอนุญาต</a></li>
                            <li><a href="/user/engineering/history/renew_license_engineer"
                                    class="link-dark rounded">ใบอนุญาตใกล้หมดอายุ</a></li>
                        </ul>
                    </div>
                </li> --}}

                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start"
                        data-bs-toggle="collapse" data-bs-target="#market-collapse" aria-expanded="false">
                        คำขอรับใบอนุญาตจัดตั้งตลาด
                    </button>
                    <div class="collapse" id="market-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="/admin/request/public-health/showdata/market-establishment-license"
                                    class="link-dark rounded">รับเรื่อง</a></li>
                            <li><a href="/admin/request/public-health/appointment/market-establishment-license"
                                    class="link-dark rounded">การนัดหมาย</a></li>
                            <li><a href="/admin/request/public-health/explore/market-establishment-license"
                                    class="link-dark rounded">ออกสำรวจ</a></li>
                            <li><a href="/admin/request/public-health/confirm_payment/market-establishment-license"
                                    class="link-dark rounded">ชำระเงิน</a></li>
                            <li><a href="/admin/request/public-health/Issue-a-license/market-establishment-license"
                                    class="link-dark rounded">ออกใบอนุญาต</a></li>
                            <li><a href="/user/engineering/history/renew_license_engineer"
                                    class="link-dark rounded">ใบอนุญาตใกล้หมดอายุ</a></li>
                        </ul>
                    </div>
                </li>

                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start"
                        data-bs-toggle="collapse" data-bs-target="#food-collapse" aria-expanded="false">
                        คำขอรับใบอนุญาตสถานที่จำหน่ายอาหาร
                    </button>
                    <div class="collapse" id="food-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="/admin/request/public-health/showdata/food-sales-license"
                                    class="link-dark rounded">รับเรื่อง</a></li>
                            <li><a href="/admin/request/public-health/appointment/food-sales-license"
                                    class="link-dark rounded">การนัดหมาย</a></li>
                            <li><a href="/admin/request/public-health/explore/food-sales-license"
                                    class="link-dark rounded">ออกสำรวจ</a></li>
                            <li><a href="/admin/request/public-health/confirm_payment/food-sales-license"
                                    class="link-dark rounded">ชำระเงิน</a></li>
                            <li><a href="/admin/request/public-health/Issue-a-license/food-sales-license"
                                    class="link-dark rounded">ออกใบอนุญาต</a></li>
                            <li><a href="/user/engineering/history/renew_license_engineer"
                                    class="link-dark rounded">ใบอนุญาตใกล้หมดอายุ</a></li>
                        </ul>
                    </div>
                </li>

                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start"
                        data-bs-toggle="collapse" data-bs-target="#hazard-collapse" aria-expanded="false">
                        คำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ
                    </button>
                    <div class="collapse" id="hazard-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="/admin/request/public-health/showdata/health-hazard-license"
                                    class="link-dark rounded">รับเรื่อง</a></li>
                            <li><a href="/admin/request/public-health/appointment/health-hazard-license"
                                    class="link-dark rounded">การนัดหมาย</a></li>
                            <li><a href="/admin/request/public-health/explore/health-hazard-license"
                                    class="link-dark rounded">ออกสำรวจ</a></li>
                            <li><a href="/admin/request/public-health/confirm_payment/health-hazard-license"
                                    class="link-dark rounded">ชำระเงิน</a></li>
                            <li><a href="/admin/request/public-health/Issue-a-license/health-hazard-license"
                                    class="link-dark rounded">ออกใบอนุญาต</a></li>
                            <li><a href="/user/engineering/history/renew_license_engineer"
                                    class="link-dark rounded">ใบอนุญาตใกล้หมดอายุ</a></li>
                        </ul>
                    </div>
                </li>

                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start"
                        data-bs-toggle="collapse" data-bs-target="#waste-collapse" aria-expanded="false">
                        คำขอรับใบอนุญาตประกอบกิจการเก็บ ขน หรือกำจัดสิ่งปฏิกูลฯ
                    </button>
                    <div class="collapse" id="waste-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="/admin/request/public-health/showdata/waste-disposal-business-license"
                                    class="link-dark rounded">รับเรื่อง</a></li>
                            <li><a href="/admin/request/public-health/appointment/waste-disposal-business-license"
                                    class="link-dark rounded">การนัดหมาย</a></li>
                            <li><a href="/admin/request/public-health/explore/waste-disposal-business-license"
                                    class="link-dark rounded">ออกสำรวจ</a></li>
                            <li><a href="/admin/request/public-health/confirm_payment/disposal-business-license"
                                    class="link-dark rounded">ชำระเงิน</a></li>
                            <li><a href="/admin/request/public-health/Issue-a-license/disposal-business-license"
                                    class="link-dark rounded">ออกใบอนุญาต</a></li>
                            <li><a href="/user/engineering/history/renew_license_engineer"
                                    class="link-dark rounded">ใบอนุญาตใกล้หมดอายุ</a></li>
                        </ul>
                    </div>
                </li>

                {{-- ✅ ถ้าไม่เข้ากองใดเลย --}}
            @else
                <li class="text-muted text-center mt-3">ไม่พบหน่วยงานที่เกี่ยวข้อง</li>
            @endif
        </ul>
    </div>



    <div class="p-4" style="flex:1;">
        {{-- search bar --}}
        <div class="bg-white my-4 p-2 rounded-3 d-flex align-items-center justify-content-between">
            <form class="d-flex align-items-center mb-0">
                <i class="bi bi-search me-2"></i>
                <input type="search" class="search-menu" placeholder="Search..." aria-label="Search">
            </form>

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
        <div class="bg-white p-2 rounded-3 p-5">
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
