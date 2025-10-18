@extends('layout.layout-user')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/menurequest.css') }}">
    <div class="container mt-3">
        <div>
            <a href="/user/waste_payment">
                <img src="../../img/ToxicTrash/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
            </a>
        </div>
        <div class="row g-0">
            {{-- คอลัมน์เมนู (ซ้าย) --}}
            <nav class="menu-list col-md-3 col-lg-3">
                <ul>
                    <li class="menu-item has-sub">
                        <a href="#">สำนักปลัด</a>
                        <ul class="submenu">
                            <li><a href="#">คำร้องทั่วไป</a></li>
                            <li><a href="#">คำร้องขอติดตั้งป้ายโฆษณาริมถนนสาธารณะ</a></li>
                            <li><a href="#">คำร้องเรียนการทุจริตและประพฤติมิชอบของเจ้าหน้าที่</a></li>
                            <li><a href="#">คำขอเครื่องหมายรับรองผู้ประกอบธุรกิจพาณิชย์อิเล็กทรอนิกส์ (DBD
                                    Registered)</a></li>
                            <li><a href="#">คำขอจดทะเบียนพาณิชย์ (ใหม่/เปลี่ยนแปลง/ยกเลิก)</a></li>
                            <li><a href="#">คำร้องทะเบียนพาณิชย์</a></li>
                            <li><a href="#">คําขอตรวจค้นเอกสาร/รับรองสําเนาเอกสาร/ใบแทน</a></li>
                            <li><a href="#">หนังสือมอบอำนาจ</a></li>
                        </ul>
                    </li>

                    <li class="menu-item has-sub">
                        <a href="#">กองช่าง</a>
                        <ul class="submenu">
                            <li><a href="#">คำร้องทั่วไป (ซ่อมไฟฟ้าสาธารณะ , ซ่อมแซมถนน)</a></li>
                            <li><a href="#">ใบแจ้งการขุดดินหรือถมดิน</a></li>
                        </ul>
                    </li>

                    <li class="menu-item has-sub">
                        <a href="#">กองการศึกษา</a>
                        <ul class="submenu">
                            <li><a href="#">ใบสมัครเรียน ศพด.บ้านท่าข้าม</a></li>
                            <li><a href="#">ใบสมัครเรียน ศพด.บ้านท่าข้าม วัดบางแสม</a></li>
                            <li><a href="#">ใบสมัครเรียน ศพด.บ้านท่าข้าม วัดคลองพานทอง</a></li>
                        </ul>
                    </li>

                    <li class="menu-item has-sub">
                        <a href="#">กองยุทธศาสตร์และงบประมาณ</a>
                        <ul class="submenu">
                            <li><a href="#">คำร้องขอข้อมูลข่าวสาร</a></li>
                        </ul>
                    </li>

                    <li class="menu-item has-sub">
                        <a href="#">กองสาธารณสุขฯ</a>
                        <ul class="submenu">
                            <li><a href="#">คำร้องขอถังขยะ</a></li>
                        </ul>
                    </li>

                    <li class="menu-item has-sub">
                        <a href="#">กองสวัสดิการสังคม</a>
                        <ul class="submenu">
                            <li><a href="#">คำร้องทั่วไปขอรับการช่วยเหลือ</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            {{-- คอลัมน์เนื้อหา (ขวา) --}}
            <div class="col-md-8 col-lg-9 request-content px-5">
                <img src="../../img/banner-request/trash-request.png" alt="banner-request" class="ing-banner-request mb-4">
                <div class="form-content mb-3">
                    <div>
                        <h4 class="header-form-name my-2">
                            ฟอร์ม@yield('request-header')
                        </h4>
                    </div>

                    <div class="px-5 pb-4">
                        @yield('request-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
