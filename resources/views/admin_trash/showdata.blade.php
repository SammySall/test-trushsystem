@extends('layout.layout-admin-trash')
@section('title', 'ข้อมูลคำขอถังขยะ')

@section('content')
        <h3 class="text-center px-2">แบบคำขอรับการประเมินค่าธรรมเนียม และขอรับถังขยะมูลฝอยทั่วไป</h3>
        <h4 class="text-center px-2">ตารางแสดงข้อมูลฟอร์มที่ส่งเข้ามา</h4>
    <div class="container p-5">

        {{-- ฟิลเตอร์ --}}
        <div id="data_table_wrapper" class="mt-3">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <label class="d-flex align-items-center">
                        <span class="me-1">แสดง</span>
                        <select id="data_table_length" class="form-select form-select-sm me-1" style="width:auto;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="-1">ทั้งหมด</option>
                        </select>
                        <span>รายการ</span>
                    </label>
                </div>
                <div class="col-sm-12 col-md-6">
                    <label class="d-flex align-items-center justify-content-end">
                        <span class="me-2">ค้นหา :</span>
                        <input type="search" id="data_table_search" class="form-control form-control-sm"
                            style="width:auto;">
                    </label>
                </div>
            </div>

            {{-- ตารางข้อมูล --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle" id="data_table">
                    <thead>
                        <tr>
                            <th>วันที่ส่ง</th>
                            <th>ชื่อผู้ส่งฟอร์ม</th>
                            <th>ผู้กดรับฟอร์ม</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashRequests as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>{{ $item->fullname ?? '-' }}</td>
                                <td>{{ $item->receiver_name ?? '-' }}</td>
                                <td>
                                    @if ($item->status === 'done')
                                        <span style="font-size: 20px; color:blue;"><i class="bi bi-check-circle"></i></span>
                                    @elseif($item->status === 'รอรับเรื่อง')
                                        <span style="font-size: 20px; color:orange;"><i
                                                class="bi bi-hourglass-split"></i></span>
                                    @else
                                        <span style="font-size: 20px; color:gray;"><i class="bi bi-dash-circle"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm view-file"
                                        data-row='@json($item)'>
                                        <i class="bi bi-filetype-pdf"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm reply-btn"
                                        data-id="{{ $item->id }}" data-name="{{ $item->fullname }}">
                                        <i class="bi bi-reply"></i>
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">ไม่มีข้อมูลฟอร์ม</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- pagination --}}
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div>แสดง 1 ถึง 2 จาก 2 รายการ</div>
                </div>
                <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                    <ul class="pagination">
                        <li class="paginate_button page-item previous disabled"><a class="page-link">ก่อนหน้า</a></li>
                        <li class="paginate_button page-item active"><a href="#" class="page-link">1</a></li>
                        <li class="paginate_button page-item next disabled"><a class="page-link">ถัดไป</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        $userId = null;
        if (session('token')) {
            $payload = json_decode(\Illuminate\Support\Facades\Crypt::decryptString(session('token')), true);
            $userId = $payload['userId'] ?? null;
        }
    @endphp

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pdfButtons = document.querySelectorAll(".btn.btn-danger.btn-sm");
            const replyButtons = document.querySelectorAll(".btn.btn-success.btn-sm");
            const userId = @json($userId);

            // ปุ่ม PDF + กดรับแบบฟอร์ม
            pdfButtons.forEach(btn => {
                btn.addEventListener("click", function() {
                    const rowData = JSON.parse(btn.dataset.row);
                    const fileData = rowData.picture_path;
                    const isPending = rowData.status === 'รอรับเรื่อง';

                    let filesArray = [];
                    if (Array.isArray(fileData)) {
                        filesArray = fileData;
                    } else if (typeof fileData === 'string' && fileData.includes(',')) {
                        filesArray = fileData.split(',').map(f => f.trim());
                    } else if (typeof fileData === 'string' && fileData.trim() !== '') {
                        filesArray = [fileData];
                    }

                    let fileLinks = '';
                    if (filesArray.length > 0) {
                        filesArray.forEach((file, index) => {
                            const fileUrl = `{{ asset('storage') }}/${file}`;
                            const fileNumber = index + 1; // เริ่มนับจาก 1

                            if (fileLinks.length === 0) {
                                fileLinks +=
                                    `<div>ไฟล์แนบ ${fileNumber}: <a href="${fileUrl}" target="_blank">${file}</a></div>`;
                            } else {
                                fileLinks +=
                                    `<div>${fileNumber}: <a href="${fileUrl}" target="_blank">${file}</a></div>`;
                            }
                        });
                    } else {
                        fileLinks = '<div>ไม่มีไฟล์แนบ</div>';
                    }


                    const htmlContent = `
                    <div style="text-align:left; font-size:16px; line-height:1.5;">
                        <div style="margin-bottom:10px; ">
                            Preview
                            <button id="openPdfBtn" class="btn btn-danger btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> เปิด PDF
                            </button>
                        </div>
                        ${fileLinks}
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span>รับฟอร์ม</span>
                            <button id="acceptForm" class="btn btn-success btn-sm" ${!isPending ? 'disabled' : ''}>
                                กดรับแบบฟอร์ม
                            </button>
                        </div>
                    </div>
                    `;

                    Swal.fire({
                        title: '<div style="text-align:left;">แสดงข้อมูล</div>',
                        html: htmlContent,
                        showCloseButton: true,
                        showConfirmButton: false,
                        width: '500px'
                    });

                    // event เปิด PDF
                    Swal.getPopup().querySelector('#openPdfBtn').addEventListener('click', () => {
                        window.open(`{{ route('admin_trash.show_pdf', '') }}/${rowData.id}`,
                            '_blank');
                    });


                    if (isPending) {
                        Swal.getPopup().querySelector('#acceptForm').addEventListener('click',
                            () => {
                                fetch("{{ route('admin_trash.accept') }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            request_id: rowData.id,
                                            user_id: userId
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire('สำเร็จ!',
                                                    'คุณได้กดรับแบบฟอร์มเรียบร้อยแล้ว',
                                                    'success')
                                                .then(() => location.reload());
                                        } else {
                                            Swal.fire('ผิดพลาด', 'ไม่สามารถอัปเดตข้อมูลได้',
                                                'error');
                                        }
                                    })
                                    .catch(err => {
                                        console.error(err);
                                        Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                                            'error');
                                    });
                            });
                    }
                });
            });

            // ปุ่ม Reply
            replyButtons.forEach(btn => {
                btn.addEventListener("click", function() {
                    const tr = btn.closest("tr");
                    const sender = tr.children[1]?.textContent || '';
                    const requestId = btn.dataset.id;
                    const rowData = JSON.parse(tr.querySelector('.view-file').dataset
                        .row); // หรือใช้ data-row ของปุ่ม PDF
                    const replies = rowData.histories ?? [];

                    let tableRows = '';
                    if (replies.length === 0) {
                        tableRows = `<tr><td colspan="3" class="text-center">ไม่มีข้อมูล</td></tr>`;
                    } else {
                        replies.forEach(reply => {
                            tableRows += `
                        <tr>
                            <td style="text-align:center;">${reply.responder_name}</td>
                            <td style="text-align:center;">${reply.created_at}</td>
                            <td style="text-align:center;">${reply.message}</td>
                        </tr>
                        `;
                        });
                    }

                    const htmlContent = `
            <div style="text-align:left; font-size:16px; line-height:1.5;">
                <div style="margin-bottom:10px;">ชื่อผู้ส่งฟอร์ม: <strong>${sender}</strong></div>
                <div style="margin-bottom:10px;">ข้อความตอบกลับก่อนหน้า</div>
                <div style="margin-bottom:10px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ผู้ตอบกลับ</th>
                                <th class="text-center">วันที่ตอบกลับ</th>
                                <th class="text-center">ข้อความที่ตอบกลับ</th>
                            </tr>
                        </thead>
                        <tbody>${tableRows}</tbody>
                    </table>
                </div>
                <div style="margin-top:10px;">
                    <label for='reply'>ข้อความตอบกลับ:</label>
                    <textarea id='reply' class="form-control" rows="3" placeholder="พิมพ์ข้อความตอบกลับ..."></textarea>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button id="closeReply" class="btn btn-secondary me-2">ปิด</button>
                    <button id="sendReply" class="btn btn-primary">ส่งตอบกลับ</button>
                </div>
            </div>
        `;

                    Swal.fire({
                        title: 'ตอบกลับฟอร์ม',
                        html: htmlContent,
                        showCloseButton: false,
                        showConfirmButton: false,
                        width: '600px',
                    });

                    document.getElementById('closeReply').addEventListener('click', () => Swal
                        .close());

                    document.getElementById('sendReply').addEventListener('click', () => {
                        const message = document.getElementById('reply').value;
                        if (message.trim() === '') {
                            Swal.showValidationMessage('กรุณาพิมพ์ข้อความก่อนส่ง');
                            return;
                        }

                        fetch(`/admin/reply/${requestId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    request_id: requestId,
                                    user_id: userId,
                                    message: message
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.close();
                                    Swal.fire('สำเร็จ!',
                                            'ส่งข้อความตอบกลับเรียบร้อยแล้ว', 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire('ผิดพลาด!', data.message ||
                                        'ไม่สามารถส่งข้อความได้', 'error');
                                }
                            })
                            .catch(err => {
                                Swal.showValidationMessage(
                                    'เกิดข้อผิดพลาด กรุณาลองใหม่');
                                console.error(err);
                            });

                    });
                });
            });

        });
    </script>
    <script>
        const allHistories = @json($trashRequests);
        console.log(allHistories); // จะเห็นข้อมูลใน console
    </script>

@endsection
