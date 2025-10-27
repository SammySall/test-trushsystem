@extends('layout.layout-admin-request')
@section('title', 'ออกใบอนุญาต')

@section('content')
    <h3 class="text-center px-2">คำร้องรอออกใบอนุญาต</h3>
    <h4 class="text-center px-2">ตารางแสดงคำร้องที่พร้อมออกใบอนุญาต</h4>

    <div id="data_table_wrapper" class="mt-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle" id="data_table">
                <thead>
                    <tr>
                        <th>วันที่ขอ</th>
                        <th>ผู้ขอใบอนุญาต</th>
                        <th>วันที่อัปเดตล่าสุด</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashRequests as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->fullname ?? '-' }}</td>
                            <td>{{ $item->latest_update }}</td>
                            <td>
                                <span class="badge rounded-pill text-bg-success">{{ $item->status }}</span>
                            </td>
                            <td>

                                @if ($item->status !== 'เสร็จสิ้น' && $item->status !== 'ออกใบอนุญาตเสร็จสิ้น')
                                    <!-- ปุ่มออกใบอนุญาต (ถ้าไม่เสร็จสิ้น) -->
                                    <button class="btn btn-primary btn-sm"
                                        onclick="uploadLicense({{ $item->id }}, '{{ $item->fullname }}', '{{ $item->addon['payment']['slip_path'] ?? '' }}', '{{ $item->type }}')">
                                        <i class="bi bi-upload"></i>
                                    </button>
                                @endif

                                @if ($item->status == 'เสร็จสิ้น' || $item->status == 'ออกใบอนุญาตเสร็จสิ้น')
                                    <!-- ปุ่มดูใบอนุญาต PDF -->
                                    <a href="{{ url('/license/' . $item->type . '/pdf/' . $item->id) }}" target="_blank"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i> ดูใบอนุญาต
                                    </a>
                                @endif

                                <a href="{{ route('admin_trash.show_pdf', $item->id) }}" target="_blank"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>
                                <a href="{{ route('admin_request.detail', ['type' => $item->type, 'id' => $item->id]) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="bi bi-search"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">ไม่มีคำร้องรอออกใบอนุญาต</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function uploadLicense(requestId, fullname, slipPath = null, type = 'garbage') {
            const pdfUrl = `/license/${type}/pdf/${requestId}`;

            Swal.fire({
                title: `ออกใบอนุญาต: ${fullname}`,
                html: `<div style="margin-bottom:10px;">
            <label>ใบอนุญาต:</label><br>
            <a href="${pdfUrl}" target="_blank" style="display:inline-block; padding:5px 10px; background:#4caf50; color:#fff; border-radius:5px; text-decoration:none;">
                เปิดไฟล์ PDF ใบอนุญาต
            </a>
            ${slipPath ? `
                                <div style="margin-top:10px;">
                                    <label>ใบเสร็จแนบ:</label><br>
                                    <a href="/storage/${slipPath}" target="_blank" style="display:inline-block; padding:5px 10px; background:#2196f3; color:#fff; border-radius:5px; text-decoration:none;">
                                        เปิดไฟล์ PDF / รูปภาพใบเสร็จ
                                    </a>
                                    <div style="margin-top:5px;">
                                        <img src="/storage/${slipPath}" style="max-width:100%; max-height:200px; border:1px solid #ccc; border-radius:5px;">
                                    </div>
                                </div>
                            ` : ''}
        </div>`,
                showCancelButton: true,
                confirmButtonText: 'บันทึก',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/request/public-health/save-license/${requestId}`,
                        method: 'POST',
                        data: {
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
                        error: function() {
                            Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกใบอนุญาตได้', 'error');
                        }
                    });
                }
            });
        }
    </script>

@endsection
