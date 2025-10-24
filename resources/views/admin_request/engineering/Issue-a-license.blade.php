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

                                @if ($item->status !== 'เสร็จสิ้น' && $item->status !== 'ออกใบอนุญาตแล้ว')
                                    <!-- ปุ่มออกใบอนุญาต (ถ้าไม่เสร็จสิ้น) -->
                                    <button class="btn btn-primary btn-sm"
                                        onclick="uploadLicense({{ $item->id }}, '{{ $item->fullname }}', '{{ $item->addon['payment']['slip_path'] ?? '' }}')">
                                        <i class="bi bi-upload"></i>
                                    </button>
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
        function uploadLicense(requestId, fullname, slipPath = null) {
            Swal.fire({
                title: `อัปโหลดใบอนุญาต: ${fullname}`,
                html: `
            ${slipPath ? `<div style="margin-bottom:10px;">
                            <label>รูปใบเสร็จที่แนบไว้:</label><br>
                            <img src="/storage/${slipPath}" style="max-width:100%; max-height:200px; border:1px solid #ccc; border-radius:5px;">
                        </div>` : ''}
            <input type="file" id="license_file" class="swal2-file" accept=".pdf,.jpg,.jpeg,.png">
        `,
                showCancelButton: true,
                confirmButtonText: 'อัปโหลด',
                preConfirm: () => {
                    const file = document.getElementById('license_file').files[0];
                    if (!file) {
                        Swal.showValidationMessage('กรุณาเลือกไฟล์ใบอนุญาต');
                    }
                    return file;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('license_file', result.value);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: `/admin/request/public-health/upload-license/${requestId}`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
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
                            Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถอัปโหลดใบอนุญาตได้', 'error');
                        }
                    });
                }
            });
        }
    </script>

@endsection
