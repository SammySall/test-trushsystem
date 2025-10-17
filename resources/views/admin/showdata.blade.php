@extends('layout.layout-admin')
@section('title', 'Dashboard')
@section('content')
    <h3 class="text-center px-2">แบบคำขอรับการประเมินค่าธรรมเนียมการกำจัดสิ่งปฏิกูลและมูลฝอย และ แบบขอรับถังขยะมูลฝอยทั่วไป
    </h3>
    <h4 class="text-center px-2">ตารางแสดงข้อมูลฟอร์มที่ส่งเข้ามา</h4>

    {{-- ฟิวเตอร์ --}}
    <div id="data_table_wrapper">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-6">
                <div id="data_table_length">
                    <label class="d-flex align-items-center">
                        <span class="me-1">แสดง</span>
                        <select name="data_table_length" aria-controls="data_table" class="form-select form-select-sm me-1"
                            style="width: auto;">
                            <option value="10">10</option>
                            <option value="40">40</option>
                            <option value="80">80</option>
                            <option value="-1">ทั้งหมด</option>
                        </select>
                        <span>รายการ</span>
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="data_table_filter">
                    <label class="d-flex align-items-center justify-content-end">
                        <span class="me-2">ค้นหา :</span>
                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="data_table"
                            style="width: auto;">
                    </label>
                </div>
            </div>
        </div>

        {{-- ตารางข้อมูล --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable no-footer" id="data_table"
                    aria-describedby="data_table_info">
                    <thead class="text-center">
                        <tr>
                            <th>วันที่ส่ง</th>
                            <th>ชื่อผู้ส่งฟอร์ม</th>
                            <th>ผู้กดรับฟอร์ม</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr class="odd">
                            <td class="date-column">10/06/2568</td>
                            <td>ทดสอบ</td>
                            <td></td>
                            <td><span style="font-size: 20px; color:blue;"><i class="bi bi-check-circle"></i></span></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-filetype-pdf"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="bi bi-reply"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="even">
                            <td class="date-column">10/06/2568</td>
                            <td>ทดสอบ 2</td>
                            <td></td>
                            <td><span style="font-size: 20px; color:blue;"><i class="bi bi-check-circle"></i></span></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-filetype-pdf"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="bi bi-reply"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ส่วนท้าย --}}
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

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ปุ่ม PDF
            const pdfButtons = document.querySelectorAll(".btn.btn-danger.btn-sm");
            const baseUrl = "{{ asset('storage/waste_files') }}";
            const files = [
                '1749521349_istock-1347633262.jpg',
                '1749521295_istock-1347633262.jpg'
            ];

            pdfButtons.forEach((btn, index) => {
                btn.addEventListener("click", function() {
                    const tr = btn.closest("tr");
                    const sender = tr.children[1]?.textContent || '';
                    const fileUrl = `${baseUrl}/${files[index]}`;

                    const htmlContent = `
                <div style="text-align:left; font-size:16px; line-height:1.5;">
                    <div style="margin-bottom:10px;">
                        Preview
                        <button class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i></button>
                    </div>
                    <div style="margin-bottom:10px;">
                        ไฟล์แนบ: <a href="${fileUrl}" target="_blank">${files[index]}</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>รับฟอร์ม</span>
                        <button class="btn btn-success btn-sm" disabled>กดรับแบบฟอร์ม</button>
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
                });
            });

            // ปุ่ม Reply
            const replyButtons = document.querySelectorAll(".btn.btn-success.btn-sm");
            replyButtons.forEach(btn => {
                btn.addEventListener("click", function() {
                    const tr = btn.closest("tr");
                    const sender = tr.children[1]?.textContent || '';

                    const replies = []; // ใส่ข้อมูลจริงจาก DB ถ้ามี
                    let tableRows = '';
                    if (replies.length === 0) {
                        tableRows = `<tr><td colspan="3" class="text-center">ไม่มีข้อมูล</td></tr>`;
                    } else {
                        replies.forEach(reply => {
                            tableRows += `
                    <tr>
                        <td>${reply.responder}</td>
                        <td>${reply.date}</td>
                        <td>${reply.message}</td>
                    </tr>
                `;
                        });
                    }

                    const htmlContent = `
            <div style="text-align:left; font-size:16px; line-height:1.5;">
                <div style="margin-bottom:10px;">
                    ชื่อผู้ส่งฟอร์ม: <strong>${sender}</strong>
                </div>
                <div style="margin-bottom:10px;">
                    ข้อความตอบกลับก่อนหน้า                    
                </div>
                <div style="margin-bottom:10px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ผู้ตอบกลับ</th>
                                <th class="text-center">วันที่ตอบกลับ</th>
                                <th class="text-center">ข้อความที่ตอบกลับ</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tableRows}
                        </tbody>
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

                    // ปุ่มปิดเอง
                    document.getElementById('closeReply').addEventListener('click', () => {
                        Swal.close();
                    });

                    // ปุ่มส่งตอบกลับ
                    document.getElementById('sendReply').addEventListener('click', () => {
                        const message = document.getElementById('reply').value;
                        if (message.trim() === '') {
                            Swal.showValidationMessage('กรุณาพิมพ์ข้อความก่อนส่ง');
                            return;
                        }
                        // ส่งข้อมูลไป backend ผ่าน AJAX หรือ fetch
                        console.log('ส่งข้อความ:', message);
                        Swal.close();
                        Swal.fire('สำเร็จ!', 'ส่งข้อความตอบกลับเรียบร้อยแล้ว', 'success');
                    });
                });
            });

        });
    </script>
@endsection
