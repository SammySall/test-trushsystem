@extends('layout.layout-user')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/menurequest.css') }}">

    <div class="container mt-3">
        <div>
            <a href="@yield('back-button', '/')">
                <img src="{{ asset('img/ToxicTrash/Back-Button.png') }}" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
            </a>
        </div>

        {{-- ✅ layout สลับอัตโนมัติ --}}
        <div class="row g-0 flex-wrap">

            {{-- ✅ เมนู (อยู่บนเมื่อจอเล็ก อยู่ซ้ายเมื่อจอใหญ่) --}}
            <nav class="menu-list col-12 col-md-4 col-lg-3 order-1 order-md-1 mb-4 mb-md-0">
                <ul>
                    <li class="menu-item has-sub">
                        <a href="#">กองช่าง</a>
                        <ul class="submenu">
                            <li class="has-sub-sub">
                                <a href="#">คำขอใบอนุญาตก่อสร้าง</a>
                                <ul class="submenu-sub">
                                    <li><a href="/user/request/new_license_engineer">แบบฟอร์มคำร้อง</a></li>
                                    <li><a href="/user/request/history_request/new-license-engineer">ประวัติการส่งคำร้อง</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="#">คำขอต่ออายุใบอนุญาตก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร</a>
                                <ul class="submenu-sub">
                                    <li><a href="/user/request/renew_license_engineer">แบบฟอร์มคำร้อง</a></li>
                                    <li><a
                                            href="/user/request/history_request/renew-license-engineer">ประวัติการส่งคำร้อง</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item has-sub">
                        <a href="#">กองสาธารณสุขฯ</a>
                        <ul class="submenu">
                            <li class="has-sub-sub">
                                <a href="#">คำร้องขออนุญาตลงถังขยะ</a>
                                <ul class="submenu-sub">
                                    <li><a href="/user/request/trash_request">แบบฟอร์มคำร้อง</a></li>
                                    <li><a href="/user/request/history_request/trash-request">ประวัติการส่งคำร้อง</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="#">คำขอรับใบอนุญาตจัดตั้งตลาด</a>
                                <ul class="submenu-sub">
                                    <li><a href="/user/request/market_establishment_license">แบบฟอร์มคำร้อง</a></li>
                                    <li><a
                                            href="/user/request/history_request/market-establishment-license">ประวัติการส่งคำร้อง</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="#">คำขอรับใบอนุญาตสถานที่จำหน่ายอาหาร</a>
                                <ul class="submenu-sub">
                                    <li><a href="/user/request/food_sales_license">แบบฟอร์มคำร้อง</a></li>
                                    <li><a href="/user/request/history_request/food-sales-license">ประวัติการส่งคำร้อง</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="#">คำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ</a>
                                <ul class="submenu-sub">
                                    <li><a href="/user/request/health_hazard_license">แบบฟอร์มคำร้อง</a></li>
                                    <li><a
                                            href="/user/request/history_request/health-hazard-license">ประวัติการส่งคำร้อง</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="#">คำขอรับใบอนุญาตประกอบกิจการรับทำการเก็บ ขน
                                    หรือกำจัดสิ่งปฏิกูลหรือมูลฝอย</a>
                                <ul class="submenu-sub">
                                    <li><a href="/user/request/waste_disposal_business_license">แบบฟอร์มคำร้อง</a></li>
                                    <li><a
                                            href="/user/request/history_request/waste-disposal-business-license">ประวัติการส่งคำร้อง</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            {{-- ✅ เนื้อหา --}}
            <div class="col-12 col-md-8 col-lg-9 request-content order-2 order-md-2">
                @if (Request::is('user/request/history_request*'))
                    <div class="form-content my-3 mx-2">
                        <div class="p-3 pb-4">
                            @yield('request-content')
                        </div>
                    </div>
                @else
                    <img src="{{ asset('img/banner-request/' . $__env->yieldContent('request-header-img') . '.png') }}"
                        alt="banner-request" class="img-fluid mb-3 px-3 px-md-5">
                    <div class="form-content mb-3 mx-2 mx-md-5">
                        <div class="text-center">
                            <h4 class="header-form-name my-2 mx-4">
                                @yield('request-header')
                            </h4>
                        </div>
                        <div class="px-3 px-md-5 pb-4">
                            @yield('request-content')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ✅ JS สำหรับเปิด/ปิด submenu --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.has-sub-sub > a').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;
                    document.querySelectorAll('.submenu-sub').forEach(s => {
                        if (s !== submenu) s.style.maxHeight = null;
                    });
                    submenu.style.maxHeight = submenu.style.maxHeight ? null : submenu
                        .scrollHeight + "px";
                });
            });
        });
    </script>
@endsection
