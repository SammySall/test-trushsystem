@extends('layout.layout-request')
@section('title', 'ประวัติคำร้อง')

@section('request-content')

@switch($type)
    @case('renew-license-engineer')
        @php $formTitle = 'คำขอต่ออายุใบอนุญาตก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร'; @endphp
    @break

    @case('trash-request')
        @php $formTitle = 'คำร้องขออนุญาตลงถังขยะ'; @endphp
    @break

    @case('market-establishment-license')
        @php $formTitle = 'คำขอรับใบอนุญาตจัดตั้งตลาด'; @endphp
    @break

    @case('food-sales-license')
        @php $formTitle = 'คำขอรับใบอนุญาตสถานที่จำหน่ายอาหาร'; @endphp
    @break

    @case('health-hazard-license')
        @php $formTitle = 'คำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ'; @endphp
    @break

    @case('waste-disposal-business-license')
        @php $formTitle = 'คำขอรับใบอนุญาตประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลหรือมูลฝอย'; @endphp
    @break

    @default
        @php $formTitle = 'ไม่พบข้อมูลประเภทใบอนุญาต'; @endphp
@endswitch

<div class="row mb-3">
    <div class="col bg-white p-3 shadow-sm rounded">
        <h5>{{ $formTitle }}</h5>

        <table class="table table-bordered table-striped mt-2 text-center align-middle w-100">
            <thead>
                <tr>
                    <th style="width: 15%;">วันที่ส่ง</th>
                    <th style="width: 20%;">ชื่อผู้ส่ง</th>
                    <th style="width: 15%;">วันที่นัดหมาย</th>
                    <th style="width: 15%;">วันที่สะดวก</th>
                    <th style="width: 15%;">สถานะ</th>
                    <th style="width: 20%;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($trashRequests as $request)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $request->prefix }} {{ $request->fullname }}</td>
                        <td>{{ $request->appointment_date ?? '-' }}</td>
                        <td>{{ $request->convenient_date ?? '-' }}</td>
                        <td>{{ $request->status }}</td>
                        <td>
                            {{-- ปุ่มรอยืนยันนัดหมาย --}}
                            @if ($request->status === 'รอยืนยันนัดหมาย')
                                @php
                                    $addon = is_array($request->addon)
                                        ? $request->addon
                                        : json_decode($request->addon, true);
                                    $dataTitle = $addon['appointment']['title'] ?? '';
                                    $appointment = $request->appointment_date
                                        ? \Carbon\Carbon::parse($request->appointment_date)->format('Y-m-d\TH:i')
                                        : '';
                                @endphp
                                <button class="btn btn-warning btn-sm confirm-appointment" data-id="{{ $request->id }}"
                                    data-title="{{ $dataTitle }}" data-appointment="{{ $appointment }}">
                                    <i class="bi bi-calendar-check"></i>
                                </button>
                            @endif

                            {{-- ปุ่มรอชำระเงิน (User ส่งสลิป) --}}
                            @if ($request->status === 'รอชำระเงิน')
                                <button class="btn btn-warning btn-sm confirm-payment" data-id="{{ $request->id }}">
                                    <i class="bi bi-wallet"></i>
                                </button>
                            @endif

                            {{-- ปุ่ม PDF --}}
                            <a href="{{ route('admin_trash.show_pdf', $request->id) }}"
                                class="btn btn-danger btn-sm me-1">
                                <i class="bi bi-filetype-pdf"></i>
                            </a>

                            {{-- ปุ่มดูรายละเอียด --}}
                            <a href="{{ route('user.history-request.detail', ['type' => $request->type, 'id' => $request->id]) }}"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-search"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">ไม่มีข้อมูล</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // รอยืนยันนัดหมาย
    document.querySelectorAll('.confirm-appointment').forEach(button => {
        button.addEventListener('click', () => {
            const requestId = button.dataset.id;
            const title = button.dataset.title;
            const appointmentDate = button.dataset.appointment;

            Swal.fire({
                title: `นัดหมาย: ${title}`,
                html: `
                    <p>วันนัดหมาย: ${appointmentDate}</p>
                    <label>เลือกวันที่สะดวก:</label>
                    <input type="datetime-local" id="convenient_date" class="swal2-input">
                `,
                showCancelButton: true,
                confirmButtonText: 'บันทึก',
                preConfirm: () => {
                    const convenientDate = Swal.getPopup().querySelector('#convenient_date').value;
                    if (!convenientDate) Swal.showValidationMessage('กรุณาเลือกวันเวลาที่สะดวก');
                    return convenientDate;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const convenientDate = result.value;
                    fetch(`/user/history-request/confirm-appointment/${requestId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ convenient_date: convenientDate })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) Swal.fire('สำเร็จ!', data.message, 'success').then(() => location.reload());
                        else Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
                    })
                    .catch(err => Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาด', 'error'));
                }
            });
        });
    });

    // รอชำระเงิน (User ส่งสลิป)
    document.querySelectorAll('.confirm-payment').forEach(button => {
        button.addEventListener('click', () => {
            const requestId = button.dataset.id;

            Swal.fire({
                title: 'ชำระเงิน',
                html: `
                    <label>จำนวนเงิน:</label>
                    <input type="number" id="amount" class="swal2-input" placeholder="กรอกจำนวนเงิน" min="0">
                    <label>อัปโหลดสลิป:</label>
                    <input type="file" id="payment_slip" class="swal2-file" accept="image/*,.pdf">
                `,
                showCancelButton: true,
                confirmButtonText: 'ส่งชำระเงิน',
                preConfirm: () => {
                    const amount = Swal.getPopup().querySelector('#amount').value;
                    const slip = Swal.getPopup().querySelector('#payment_slip').files[0];
                    if (!amount || amount <= 0) Swal.showValidationMessage('กรุณากรอกจำนวนเงินให้ถูกต้อง');
                    if (!slip) Swal.showValidationMessage('กรุณาแนบสลิปการชำระเงิน');
                    return { amount, slip };
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const { amount, slip } = result.value;
                    const formData = new FormData();
                    formData.append('amount', amount);
                    formData.append('slip', slip);
                    formData.append('_token', '{{ csrf_token() }}');

                    try {
                        const res = await fetch(`/user/history-request/upload-slip/${requestId}`, {
                            method: 'POST',
                            body: formData
                        });
                        const data = await res.json();
                        if (data.success) {
                            Swal.fire('สำเร็จ!', 'ส่งหลักฐานเรียบร้อย รอตรวจสอบ', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
                        }
                    } catch (err) {
                        console.error(err);
                        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาด', 'error');
                    }
                }
            });
        });
    });
</script>

@endsection
