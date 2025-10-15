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
                <a href="/admin/waste_payment" class="nav-link"><i class="bi bi-bar-chart-fill pe-2"></i>Dashboard</a>
            </li>
            <div>Manage</div>
            <li>
                <a href="/admin/showdata" class="nav-link">ข้อมูลฟอร์มที่ส่งเข้ามา</a>
            </li>
            <li>
                <a href="/admin/trash_can_installation" class="nav-link active">ตำแหน่งที่ติดตั้งถังขยะ</a>
            </li>
            <li>
                <a href="/admin/trash_installer" class="nav-link">ผู้ใช้บริการติดตั้งถังขยะ</a>
            </li>
            <li><span>Report</span></li>
            <li><a href="#" class="nav-link">ตรวจสอบการชำระเงิน</a></li>
            <li><a href="#" class="nav-link">ประวัติการชำระเงิน</a></li>
            <li><a href="#" class="nav-link">บิลที่รอการชำระเงิน</a></li>
        </ul>
    </div>

    <div class="p-4" style="flex:1;">
        {{-- Search bar --}}
        <div class="bg-white my-4 p-2 rounded-3 d-flex align-items-center justify-content-between">
            <form class="d-flex align-items-center mb-0">
                <i class="bi bi-search me-2"></i>
                <input type="search" class="search-menu" placeholder="Search..." aria-label="Search">
            </form>
            <div class="avatar">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

        {{-- Content --}}
        <div class="bg-white p-4 rounded-3">
            <h3 class="text-center px-2">ตำแหน่งที่ติดตั้งถังขยะ</h3>

            {{-- ฟิลเตอร์ --}}
            <div id="data_table_wrapper" class="mb-3">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                        <label class="d-flex align-items-center">
                            <span class="me-1">แสดง</span>
                            <select name="data_table_length" class="form-select form-select-sm me-1"
                                style="width:auto;">
                                <option value="10">10</option>
                                <option value="40">40</option>
                                <option value="80">80</option>
                                <option value="-1">ทั้งหมด</option>
                            </select>
                            <span>รายการ</span>
                        </label>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label class="d-flex align-items-center justify-content-end">
                            <span class="me-2">ค้นหา :</span>
                            <input type="search" class="form-control form-control-sm" style="width:auto;">
                        </label>
                    </div>
                </div>

                {{-- ตารางข้อมูล --}}
                <table class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">ชื่อ</th>
                            <th class="text-center">ที่อยู่</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locations as $index => $location)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->address }}</td>
                                <td class="text-center">
                                    @if ($location->status == 'เสร็จสิ้น')
                                        <span class="text-success">เสร็จสิ้น</span>
                                    @else
                                        <span class="text-danger">รอเรียกชำระเงิน</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="detail/{{ $location->id }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-search"></i>
                                    </a>
                                    @if ($location->status != 'เสร็จสิ้น')
                                        <a href="#" class="btn btn-warning btn-sm text-white confirm-wallet"
                                            data-id="{{ $location->id }}">
                                            <i class="bi bi-wallet"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.confirm-wallet').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;

                if (confirm('ยืนยันการเรียกชำระเงิน?')) {
                    fetch(`/admin/trash_can_installation/${id}/confirm-payment`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => {
                            if (!res.ok) throw new Error('Network response was not ok');
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                const row = button.closest('tr');
                                row.querySelector('.status-cell').innerHTML =
                                    `<span class="text-success">${data.status_text}</span>`;
                                button.style.display = 'none';
                                alert('อัปเดตสำเร็จ');
                            } else {
                                alert('เกิดข้อผิดพลาด: ' + data.message);
                            }
                        })
                        .catch(err => console.error('Error:', err));
                }
            });
        });
    </script>


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
</body>

</html>
