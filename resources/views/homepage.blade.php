@extends('layout.layout-user')
@section('title', 'Home Page')
@section('content')
    <div class="container">

        {{-- =========================
            Desktop/Tablet Layout
        ========================= --}}
        <div class="row desktop-row">
            <div class="col-5 d-none d-lg-flex flex-column justify-content-center align-items-end pt-3 me-3">
                <img src="../img/homepage/นายก.png" alt="nayok" class="img-fluid" width="350">
                <div class="image-stack">
                    <img src="../img/homepage/Object.png" alt="Object" class="img-fluid bottom-img" width="350">
                    <a href="/user/request/health_hazard_license">
                        <img src="../img/homepage/Buton-1.png" alt="ขอใบอนุญาติประกอบกิจการ" class="img-fluid top-img"
                            width="350">
                    </a>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 d-flex flex-column justify-content-center align-content-center px-0">
                <div class="d-flex justify-content-center align-items-center row">
                    <img src="../img/homepage/1.png" alt="ear-phone" class="img-fluid">
                    <div class="col-5 img-stack">
                        <div class="image-stack phone-bg p-2">
                            <div class="p-2 pt-5 mb-2 justify-content-center align-content-center">
                                <img src="../img/homepage/In-Phone-Banner.png" alt="Banner" class="img-fluid bottom-img"
                                    width="200px">
                                <a href="https://eservice.demo.sosmartsolution.com/login">
                                    <img src="../img/homepage/E-Service-Button.png" alt="E-Service"
                                        class="img-fluid top-phone-img">
                                </a>
                            </div>
                            <div class="pt-2 ps-1">
                                <a href="#">
                                    <img src="../img/homepage/Phone-Button-1.png" alt="Banner"
                                        class="img-fluid btn-phone">
                                </a>
                            </div>
                            <div class="pt-2 ps-1">
                                <a href="#">
                                    <img src="../img/homepage/Phone-Button-2.png" alt="Banner"
                                        class="img-fluid btn-phone">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-7">
                        <div class="justify-content-center align-content-center">
                            <a href="user/waste_payment">
                                <img src="../img/homepage/Button-2.png" alt="E-Service" class="img-fluid btn-receive">
                            </a>
                        </div>
                        {{-- แจ้งเหตุ --}}
                        <div class="emergency-bg d-flex flex-wrap justify-content-center align-items-center">
                            <!-- แถวบน 3 ปุ่ม -->
                            <a href="/user/emergency/accident" class="btn-emergency me-2">
                                <img src="../img/homepage/Button-3.png" alt="แจ้งเหตุฉุกเฉิน" class="img-fluid">
                            </a>
                            <a href="/user/emergency/fire" class="btn-emergency me-2">
                                <img src="../img/homepage/Button-4.png" alt="แจ้งไฟไหม้" class="img-fluid">
                            </a>
                            <a href="/user/emergency/tree-fall" class="btn-emergency">
                                <img src="../img/homepage/Button-5.png" alt="แจ้งต้นไม้ล้ม" class="img-fluid">
                            </a>

                            <!-- แถวล่าง 2 ปุ่ม อยู่ตรงกลาง -->
                            <div class="w-100 d-flex justify-content-center gap-2 mt-2">
                                <a href="/user/emergency/broken-road" class="btn-emergency">
                                    <img src="../img/homepage/Button-7.png" alt="ถนนเสีย" class="img-fluid">
                                </a>
                                <a href="/user/emergency/elec-broken" class="btn-emergency">
                                    <img src="../img/homepage/Button-6.png" alt="ไฟเสีย" class="img-fluid">
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- =========================
            Mobile <480px Layout
        ========================= --}}
        <div class="row mobile-row" style="display:none;">
            {{-- ear-phone --}}
            <div class="col-12 text-center mb-2">
                <img src="../img/homepage/1.png" alt="ear-phone" class="img-fluid">
            </div>

            {{-- phone-bg --}}
            <div class="col-12 text-center mb-2">
                <div class="image-stack phone-bg mx-auto">
                    <div class="p-2 pt-5 mb-2 justify-content-center align-content-center">
                        <img src="../img/homepage/In-Phone-Banner.png" alt="Banner" class="img-fluid bottom-img"
                            width="200px">
                        <a href="https://eservice.demo.sosmartsolution.com/login">
                            <img src="../img/homepage/E-Service-Button.png" alt="E-Service" class="img-fluid top-phone-img">
                        </a>
                    </div>
                    <div class="pt-2 ps-1">
                        <a href="#">
                            <img src="../img/homepage/Phone-Button-1.png" alt="Banner" class="img-fluid btn-phone">
                        </a>
                    </div>
                    <div class="pt-2 ps-1">
                        <a href="#">
                            <img src="../img/homepage/Phone-Button-2.png" alt="Banner" class="img-fluid btn-phone">
                        </a>
                    </div>
                </div>
            </div>

            {{-- E-Service --}}
            <div class="col-12 text-center mb-2">
                <a href="user/waste_payment">
                    <img src="../img/homepage/Button-2.png" alt="E-Service" class="img-fluid btn-receive">
                </a>
            </div>

            {{-- emergency-bg --}}
            <div class="emergency-bg d-flex flex-wrap justify-content-center align-items-center">
                <!-- แถวบน 3 ปุ่ม -->
                <a href="/user/emergency/accident" class="btn-emergency me-2">
                    <img src="../img/homepage/Button-3.png" alt="แจ้งเหตุฉุกเฉิน" class="img-fluid">
                </a>
                <a href="/user/emergency/fire" class="btn-emergency me-2">
                    <img src="../img/homepage/Button-4.png" alt="แจ้งไฟไหม้" class="img-fluid">
                </a>
                <a href="/user/emergency/tree-fall" class="btn-emergency">
                    <img src="../img/homepage/Button-5.png" alt="แจ้งต้นไม้ล้ม" class="img-fluid">
                </a>

                <!-- แถวล่าง 2 ปุ่ม อยู่ตรงกลาง -->
                <div class="w-100 d-flex justify-content-center gap-2 mt-2">
                    <a href="/user/emergency/broken-road" class="btn-emergency">
                        <img src="../img/homepage/Button-6.png" alt="ถนนเสีย" class="img-fluid">
                    </a>
                    <a href="/user/emergency/elec-broken" class="btn-emergency">
                        <img src="../img/homepage/Button-7.png" alt="ไฟเสีย" class="img-fluid">
                    </a>
                </div>
            </div>

            {{-- ขอใบอนุญาติประกอบกิจการ --}}
            <div class="col-12 text-center mb-2">
                <div class="image-stack mx-auto">
                    <img src="../img/homepage/Object.png" alt="Object" class="img-fluid bottom-img">
                    <a href="/user/request/health_hazard_license">
                        <img src="../img/homepage/Buton-1.png" alt="ขอใบอนุญาติประกอบกิจการ" class="img-fluid top-img">
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
