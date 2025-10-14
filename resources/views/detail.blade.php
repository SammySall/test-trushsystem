<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="d-flex bg-body-secondary">

    <!-- Sidebar -->
    <div class="d-flex flex-column flex-shrink-0 bg-white p-3" style="width: 250px; height: 100vh;">
        <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
            <span class="fs-4"><i class="bi bi-database-fill me-2 " style="color:#696cff;"></i>ระบบค่าขยะ</span>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="/admin/waste_payment" class="nav-link" aria-current="page"><i
                        class="bi bi-bar-chart-fill pe-2"></i>
                    Dashboard</a>
            </li>
            <div>
                Manage
            </div>
            <li>
                <a href="/admin/showdata" class="nav-link">ข้อมูลฟอร์มที่ส่งเข้ามา</a>
            </li>
            <li>
                <a href="/admin/trash_can_installation" class="nav-link active">ตำแหน่งที่ติดตั้งถังขยะ</a>
            </li>
            <li>
                <a href="/admin/trash_installer" class="nav-link">ผู้ใช้บริการติดตั้งถังขยะ</a>
            </li>
            <li>
                <span>Report</span>
            </li>
            <li>
                <a href="#" class="nav-link ">ตรวจสอบการชำระเงิน</a>
            </li>
            <li>
                <a href="#" class="nav-link ">ประวัติการชำระเงิน</a>
            </li>
            <li>
                <a href="#" class="nav-link ">บิลที่รอการชำระเงิน</a>
            </li>
        </ul>
    </div>

    <div class="p-4" style="flex:1;">
        {{-- seach bar --}}
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
        <div class="bg-white p-4 rounded-3">
    <h3 class="text-center px-2">รายละเอียดข้อมูลการติดตั้งถังขยะ</h3>
    <div>ชื่อ : {{ $location->name?? '-' }}</div>
    <div>ที่อยู่ : {{ $location->address?? '-' }}</div>
    <div>เบอร์โทรศัพท์ : {{ $location->tel ?? '-' }}</div>
    <div><strong>สถานะ : </strong>
        @if($location->status == 'เสร็จสิ้น')
            <span class="badge bg-success">ติดตั้งถังขยะแล้ว</span>
        @else
            <span class="badge bg-warning">รอติดตั้ง</span>
        @endif
    </div>
    <div>map</div>
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
        width: 100%;
        height: auto;
        font-size: 2.375rem;
    }
</style>
