@extends('layout.layout-admin-request')
@section('title', 'ตรวจสอบการชำระเงิน')

@section('content')

    <h3 class="text-center">ตรวจสอบการชำระเงิน</h3>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>วันที่ชำระ</th>
                    <th>ผู้ขอใบอนุญาต</th>
                    <th>จำนวนเงิน</th>
                    <th>หลักฐาน</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trashRequests as $item)
                    @php
                        $payment = $item->addon ? json_decode($item->addon, true)['payment'] ?? null : null;
                    @endphp
                    <tr>
                        <td>{{ $payment['submitted_at'] ?? '-' }}</td>
                        <td>{{ $item->fullname }}</td>
                        <td>{{ $payment['amount'] ?? '-' }}</td>
                        <td>
                            @if (isset($payment['slip_path']))
                                <a href="{{ asset('storage/' . $payment['slip_path']) }}" target="_blank"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-earmark-text"></i> ดูหลักฐาน
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge rounded-pill text-bg-warning">{{ $payment['status'] ?? '-' }}</span>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm"
                                onclick="openConfirmPayment({{ $item->id }}, '{{ $item->fullname }}')">
                                <i class="bi bi-check2-circle"></i> ตรวจสอบ
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">ไม่มีคำร้องรอการชำระเงิน</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function openConfirmPayment(requestId, fullname) {
            Swal.fire({
                title: `ตรวจสอบการชำระเงิน: ${fullname}`,
                html: `
        <div style="text-align:left; display:flex; flex-direction:column; gap:10px;">
            <div style="display:flex; flex-direction:column;">
                <label>สถานะ</label>
                <div>
                    <input type="radio" name="payment_action" value="approve"> อนุมัติ
                    <input type="radio" name="payment_action" value="reject"> ไม่อนุมัติ
                </div>
            </div>
            <div id="note_div" style="display:none; flex-direction:column;">
                <label>หมายเหตุ</label>
                <textarea id="admin_note" class="swal2-textarea" placeholder="ระบุเหตุผล..."></textarea>
            </div>
        </div>
        `,
                showCancelButton: true,
                confirmButtonText: 'บันทึก',
                preConfirm: () => {
                    const action = document.querySelector('input[name="payment_action"]:checked')?.value;
                    const note = document.getElementById('admin_note').value;

                    if (!action) {
                        Swal.showValidationMessage('กรุณาเลือกสถานะ');
                    }
                    if (action === 'reject' && !note.trim()) {
                        Swal.showValidationMessage('กรุณาระบุหมายเหตุ');
                    }

                    return {
                        action,
                        note
                    };
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: `/admin/request/public-health/confirm_payment/${requestId}`,
                        method: 'POST',
                        data: {
                            action: res.value.action,
                            note: res.value.note,
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
                            Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกได้', 'error');
                        }
                    });
                }
            });

            document.querySelectorAll('input[name="payment_action"]').forEach(el => {
                el.addEventListener('change', function() {
                    document.getElementById('note_div').style.display = this.value === 'reject' ? 'flex' :
                        'none';
                });
            });
        }
    </script>

@endsection
