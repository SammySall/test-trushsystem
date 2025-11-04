@extends('layout.layout-admin-request')
@section('title', 'สำรวจคำร้อง')

@section('content')

    <h3 class="text-center px-2">คำร้องรอออกสำรวจ</h3>
    <h4 class="text-center px-2">ตารางแสดงข้อมูลฟอร์มที่ส่งเข้ามา</h4>

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
                    <input type="search" id="data_table_search" class="form-control form-control-sm" style="width:auto;">
                </label>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle" id="data_table">
                <thead>
                    <tr>
                        <th>วันที่ขอ</th>
                        <th>ผู้ขอใบอนุญาต</th>
                        <th>วันนัดหมาย</th>
                        <th>วันที่สะดวก</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashRequests as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->fullname ?? '-' }}</td>
                            <td>{{ $item->appointment_date ?? '-' }}</td>
                            <td>{{ $item->convenient_date ?? '-' }}</td>
                            <td>
                                <img src="{{ url('../img/icon/' . $item->status . '.png') }}" class="img-fluid logo-img"
                                    alt="{{ $item->status }}">
                                {{-- <span class="badge rounded-pill text-bg-success">{{ $item->status }}</span> --}}
                            </td>
                            <td>
                                <a href="{{ route('admin_trash.show_pdf', $item->id) }}" target="_blank"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>
                                <a href="{{ route('admin_request.detail', ['type' => $item->type, 'id' => $item->id]) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="bi bi-search"></i>
                                </a>
                                <button class="btn btn-primary btn-sm"
                                    onclick="openInspection({{ $item->id }}, '{{ $item->fullname }}')">
                                    <i class="bi bi-clipboard-check"></i> สำรวจ
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">ไม่มีข้อมูลคำร้องรอออกสำรวจ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function openInspection(requestId, fullname) {
            Swal.fire({
                title: `ผลสำรวจ: ${fullname}`,
                html: `
        <div style="text-align:left; display:flex; flex-direction:column; gap:10px;">
            <div style="display:flex; flex-direction:column;">
                <label>ผลการตรวจสอบ</label>
                <div>
                    <input type="radio" name="inspection_result" value="ผ่าน"> ผ่าน
                    <input type="radio" name="inspection_result" value="ไม่ผ่าน"> ไม่ผ่าน
                </div>
            </div>

            <div id="inspection_note_div" style="display:none; flex-direction:column;">
                <label>หมายเหตุ / สาเหตุไม่ผ่าน</label>
                <textarea id="inspection_note" class="swal2-textarea" placeholder="ระบุรายละเอียด"></textarea>
            </div>

            <div style="display:flex; flex-direction:column;">
                <label>วันที่ตรวจสอบ</label>
                <input type="datetime-local" id="inspection_date" class="swal2-input">
            </div>
        </div>
        `,
                showCancelButton: true,
                confirmButtonText: 'บันทึกผลสำรวจ',
                preConfirm: () => {
                    const result = document.querySelector('input[name="inspection_result"]:checked')?.value;
                    const note = document.getElementById('inspection_note').value;
                    const date = document.getElementById('inspection_date').value;

                    if (!result) {
                        Swal.showValidationMessage('กรุณาเลือกผลการตรวจสอบ');
                    }
                    if (result === 'ไม่ผ่าน' && !note.trim()) {
                        Swal.showValidationMessage('กรุณาระบุสาเหตุที่ไม่ผ่าน');
                    }
                    if (!date) {
                        Swal.showValidationMessage('กรุณาเลือกวันที่ตรวจสอบ');
                    }

                    return {
                        inspection_result: result,
                        inspection_note: note,
                        inspection_date: date
                    };
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: `/admin/request/explore/${requestId}`,
                        method: 'POST',
                        data: {
                            inspection_result: res.value.inspection_result,
                            inspection_note: res.value.inspection_note,
                            inspection_date: res.value.inspection_date,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('สำเร็จ!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('เกิดข้อผิดพลาด', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกผลสำรวจได้', 'error');
                        }
                    });
                }
            });

            document.querySelectorAll('input[name="inspection_result"]').forEach(el => {
                el.addEventListener('change', function() {
                    document.getElementById('inspection_note_div').style.display = this.value ===
                        'ไม่ผ่าน' ? 'flex' : 'none';
                });
            });
        }
    </script>

@endsection
