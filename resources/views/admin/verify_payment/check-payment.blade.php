@extends('layout.layout-admin')

@section('title', 'ตรวจสอบการชำระเงิน')
@section('content')
    <h3 class="text-center px-2">ตรวจสอบการชำระเงิน</h3>

    {{-- ฟิลเตอร์ --}}
    <div id="data_table_wrapper">
        <div class="row mb-2">
            {{-- จำนวนข้อมูลที่แสดง --}}
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

            {{-- ช่องสำหรับค้นหา --}}
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
                            <th>#</th>
                            <th>วันที่ชำระ</th>
                            <th>ชื่อผู้จ่าย</th>
                            <th>ที่อยู่</th>
                            <th>ยอดชำระ (บาท)</th>
                            <th>สลิปชำระเงิน</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($locations as $index => $location)
                            @forelse ($location->bills as $billIndex => $bill)
                                <!-- แสดงข้อมูล -->
                            @empty
                                <tr>
                                    <td colspan="8">ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="8">ไม่มีข้อมูล</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="row mt-2">
            <div class="col-sm-12 col-md-5">
                <div>
                    แสดง {{ $locations->firstItem() ?? 0 }} ถึง {{ $locations->lastItem() ?? 0 }} จาก
                    {{ $locations->total() ?? 0 }} รายการ
                </div>
            </div>
            <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                {{ $locations->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const manageButtons = document.querySelectorAll('#data_table tbody tr td:last-child button');

            manageButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const cells = row.querySelectorAll('td');
                    const billId = this.dataset.id;
                    const slipLink = cells[5].querySelector('a') ? cells[5].querySelector('a')
                        .href : null;

                    const htmlContent = `
                <div style="text-align:left; font-size:16px;">
                    <p><b>วันที่ชำระ:</b> ${cells[1].innerText}</p>
                    <p><b>ชื่อผู้จ่าย:</b> ${cells[2].innerText}</p>
                    <p><b>ที่อยู่:</b> ${cells[3].innerText}</p>
                    <p><b>ยอดชำระ:</b> ${cells[4].innerText}</p>
                    ${slipLink ? `<p><b>สลิปชำระเงิน:</b></p>
                                <img src="${slipLink}" alt="Slip" style="width:100%; max-height:400px; border:1px solid #ccc; padding:5px;">` 
                        : `<p><b>สลิปชำระเงิน:</b> ไม่มี</p>`}
                    <div class="d-flex justify-content-end mt-3">
                        <button id="approveBtn" class="btn btn-primary me-2">อนุมัติ</button>
                        <button id="closeModel" class="btn btn-secondary">ปิด</button>
                    </div>
                </div>
            `;

                    Swal.fire({
                        title: 'รายละเอียดบิล',
                        html: htmlContent,
                        showConfirmButton: false,
                        customClass: {
                            title: 'text-start',
                            htmlContainer: 'text-start'
                        },
                        width: '600px',
                        didOpen: () => {
                            const closeBtn = Swal.getPopup().querySelector(
                                '#closeModel');
                            closeBtn.addEventListener('click', () => Swal.close());

                            const approveBtn = Swal.getPopup().querySelector(
                                '#approveBtn');
                            approveBtn.addEventListener('click', async () => {
                                try {
                                    const res = await fetch(
                                        "{{ route('admin.verify_payment.approveBill') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                bill_id: billId
                                            })
                                        });

                                    const data = await res.json();

                                    if (res.ok && data.success) {
                                        Swal.fire('สำเร็จ', data.message,
                                            'success');
                                        // เปลี่ยนข้อความ status ในตาราง
                                        cells[6].innerText = 'ชำระแล้ว';
                                        Swal.close();
                                    } else {
                                        Swal.fire('ผิดพลาด', data.message ||
                                            'เกิดข้อผิดพลาด', 'error');
                                    }
                                } catch (err) {
                                    Swal.fire('ผิดพลาด',
                                        'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                                        'error');
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>

@endsection
