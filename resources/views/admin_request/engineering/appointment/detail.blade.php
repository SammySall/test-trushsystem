@extends('layout.layout-admin-request')
@section('title', 'นัดหมายคำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ')

@section('content')
    <h4 class="text-center my-2 mx-4">
        นัดหมายคำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ
    </h4>

    <div class="list-group text-start">

        {{-- ข้อมูลทั่วไป --}}
        <div class="col g-3 align-items-end">
            <div class="mb-3 col-md-6">
                <label class="form-label">หัวข้อ :</label>
                <input type="text" class="form-control" id="appointment_title">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">รายละเอียด :</label>
                <textarea class="form-control" rows="3" id="appointment_detail"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">นัดหมาย :</label>
                <input type="datetime-local" class="form-control" id="appointment_datetime">
            </div>
        </div>
        <div class="mt-3">
            <button id="sendReply" class="btn btn-primary">บันทึกข้อมูล</button>
        </div>
    </div>

    {{-- ใส่ใต้เนื้อหา view ของคุณ --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const requestId = {{ $trashRequest->id }};
        const userId = {{ auth()->user()->id ?? 'null' }};

        document.getElementById('sendReply').addEventListener('click', () => {
            const title = document.getElementById('appointment_title').value;
            const detail = document.getElementById('appointment_detail').value;
            const appointment = document.getElementById('appointment_datetime').value;

            if (!appointment) {
                Swal.fire('แจ้งเตือน', 'กรุณาเลือกวันและเวลานัดหมาย', 'warning');
                return;
            }

            fetch(`/admin/request/public-health/appointment/${requestId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        title: title,
                        detail: detail,
                        appointment_datetime: appointment
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('สำเร็จ!', 'นัดหมายถูกบันทึกเรียบร้อยแล้ว', 'success')
                            .then(() => {
                                const type = "{{ $trashRequest->type }}";
                                window.location.href = `/admin/request/engineering/appointment/${type}`;
                            });
                    } else {
                        Swal.fire('ผิดพลาด!', data.message || 'ไม่สามารถบันทึกได้', 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาด กรุณาลองใหม่', 'error');
                    console.error(err);
                });
        });
    </script>

@endsection
