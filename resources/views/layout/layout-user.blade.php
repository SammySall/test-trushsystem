<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/garbage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/emergency.css') }}">

</head>

<body class="d-flex flex-column min-vh-100">
    {{-- header --}}
    <header class="header-bg pt-2 pb-4">
        <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center">
            <div class="d-flex justify-content-center align-items-center text-decoration-none gap-2">
                {{-- รูปโลโก้ --}}
                <img src="{{ url('../img/menuuser/LOGO.png') }}" alt="LOGO" class="img-fluid logo-img">
                {{-- ข้อความข้างโลโก้ --}}
                <div class="d-flex flex-column justify-content-center align-items-start" style="line-height: 1;">
                    <div class="title-header">
                        เทศบาลตำบลท่าข้าม
                    </div>
                    <div class="sub-title-header">ระบบยื่นคำร้องขอออนไลน์ <img src="{{ url('../img/menuuser/2.png') }}"
                            alt="" class="img-fluid logo-img"></div>
                </div>
            </div>
            {{-- ปุ่มล็อกอินและสมัครสมาชิก --}}
            <div class="d-flex flex-column justify-content-center align-items-center mt-3 mt-lg-0">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    {{-- ปุ่มล็อตอิน --}}
                    <a href="#" class="text-center me-3">
                        <img src="../img/menuuser/login.png" alt="login" class="img-fluid btn-hover-effect">
                    </a>
                    {{-- ปุ่มสมัครสมาชิก --}}
                    <a href="/register" class="text-center">
                        <img src="../img/menuuser/register.png" alt="login" class="img-fluid btn-hover-effect"
                            height="46.13px">
                    </a>
                </div>
                <div class="text-warn mt-2 text-center">
                    <strong>*คำแนะนำ*</strong>สมัครสมาชิกเพื่อติดตามสถานะการดำเนินการ
                </div>

            </div>
        </div>
    </header>

    {{-- content --}}
    <main>
        <div class="@yield('body-class', 'body-bg') p-2">
            @yield('content')
        </div>
    </main>

    {{-- footer --}}
    <footer class="footer-bg pt-2 pb-4">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <div class="title-footer">เทศบาลตำบลท่าข้าม จังหวัดฉะเชิงเทรา</div>
            <div class="d-flex flex-column-reverse flex-md-row justify-content-center align-items-center gap-3 pt-2">
                {{-- ที่อยู่ --}}
                <div class="footer-location me-3">
                    <img src="../img/menuuser/Map-icon.png" alt="home">
                    122 หมู่ 3 ตำบลท่าข้าม อำเภอบางประกง จังหวัดฉะเชิงเทรา 24130
                </div>
                {{-- เบอร์โทรติดต่อ --}}
                <div class="footer-location">
                    <img src="../img/menuuser/Call-icon.png" alt="phone">
                    0-3857-3411-2 ต่อ 144
                </div>
            </div>
        </div>
    </footer>

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
        width: 100%;
        height: auto;
        font-size: 2.375rem;
    }
</style>
