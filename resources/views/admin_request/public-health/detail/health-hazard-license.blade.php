@extends('layout.layout-admin-request')
@section('title', 'รายละเอียดคำขอต่ออายุใบอนุญาต')

@section('content')
    <h4 class="text-center my-2 mx-4">
        รายละเอียดคำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ
    </h4>

    <div class="list-group text-start">

        {{-- วันที่ --}}
        <div class="mb-3">
            <label class="form-label">วันที่</label>
            <input type="text" class="form-control" value="{{ $trashRequest->created_at->format('d/m/Y') ?? '-' }}"
                readonly>
        </div>

        {{-- ข้อมูลทั่วไป --}}
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">คำนำหน้า</label>
                <input type="text" class="form-control" value="{{ $trashRequest->prefix ?? '-' }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">ชื่อ - นามสกุล</label>
                <input type="text" class="form-control" value="{{ $trashRequest->fullname ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">อายุ</label>
                <input type="number" class="form-control" value="{{ $trashRequest->age ?? '-' }}" readonly>
            </div>
        </div>

        {{-- ที่อยู่ --}}
        <div class="row g-3 align-items-end mt-3">
            <div class="col-md-3">
                <label class="form-label">สัญชาติ</label>
                <input type="text" class="form-control" value="{{ $trashRequest->nationality ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เลขบัตรประชาชน</label>
                <input type="text" class="form-control" value="{{ $trashRequest->id_card ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">บ้านเลขที่</label>
                <input type="text" class="form-control" value="{{ $trashRequest->house_no ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">ตรอก/ซอย</label>
                <input type="text" class="form-control" value="{{ $trashRequest->alley ?? '-' }}" readonly>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-3">
                <label class="form-label">ถนน</label>
                <input type="text" class="form-control" value="{{ $trashRequest->road ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">หมู่ที่</label>
                <input type="text" class="form-control" value="{{ $trashRequest->village_no ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">แขวง/ตำบล</label>
                <input type="text" class="form-control" value="{{ $trashRequest->subdistrict ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เขต/อำเภอ</label>
                <input type="text" class="form-control" value="{{ $trashRequest->district ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">จังหวัด</label>
                <input type="text" class="form-control" value="{{ $trashRequest->province ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เบอร์โทร</label>
                <input type="text" class="form-control" value="{{ $trashRequest->tel ?? '-' }}" readonly>
            </div>
        </div>

        {{-- Personal / Corporation --}}
        <div class="col-md-12 mt-3">
            <label class="form-label">ประเภทกิจการ</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio"
                    {{ ($addon['personal'] ?? '') == 'individual' ? 'checked' : '' }} disabled>
                <label class="form-check-label">ห้องเช่า</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio"
                    {{ ($addon['personal'] ?? '') == 'corporation' ? 'checked' : '' }} disabled>
                <label class="form-check-label">โรงงาน</label>
            </div>
        </div>

        {{-- Individual / Corporation --}}
        @if (($addon['personal'] ?? '') == 'individual')
            <div class="row g-3 mt-2">
                <div class="col-md-3">
                    <label class="form-label">ประเภท</label>
                    <input type="text" class="form-control" value="{{ $addon['individual']['type'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จำนวนห้องเช่า(ห้อง)</label>
                    <input type="text" class="form-control" value="{{ $addon['individual']['room_count'] ?? '-' }}"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">บ้านเช่า(หลัง)</label>
                    <input type="text" class="form-control" value="{{ $addon['individual']['home_rent'] ?? '-' }}"
                        readonly>
                </div>
            </div>
        @elseif(($addon['personal'] ?? '') == 'corporation')
            <div class="row g-3 mt-2">
                <div class="col-md-3">
                    <label class="form-label">ประเภท</label>
                    <input type="text" class="form-control" value="{{ $addon['corporation']['type'] ?? '-' }}"
                        readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จำนวนคนงาน(คน)</label>
                    <input type="text" class="form-control"
                        value="{{ $addon['corporation']['worker_count'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">ใช้เครื่องจักรขนาด(แรงม้า)</label>
                    <input type="text" class="form-control"
                        value="{{ $addon['corporation']['machine_power'] ?? '-' }}" readonly>
                </div>
            </div>
        @endif

        {{-- ไฟล์แนบ --}}
        <div class="mb-3 mt-3">
            <label class="form-label">
                แนบเอกสารประกอบ <br>
            </label>

            @php
                // ดึงไฟล์แต่ละ field ออกมา
                $file1 = $trashRequest->files->where('field_name', 'files1')->first();
                $file2 = $trashRequest->files->where('field_name', 'files2')->first();
                $file3 = $trashRequest->files->where('field_name', 'files3')->first();
                $file4 = $trashRequest->files->where('field_name', 'files4')->first();
                $file5 = $trashRequest->files->where('field_name', 'files5')->first();
                $file6 = $trashRequest->files->where('field_name', 'files6')->first();
                $file7 = $trashRequest->files->where('field_name', 'files7')->first();
                $file8 = $trashRequest->files->where('field_name', 'files8')->first();
            @endphp

            <div class="mb-3">
                <label class="form-label">สำเนาบัตรประจำตัว</label>
                @if ($file1)
                    <a href="{{ asset('storage/' . $file1->file_path) }}" target="_blank">{{ $file1->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">สำเนาทะเบียนบ้าน</label>
                @if ($file2)
                    <a href="{{ asset('storage/' . $file2->file_path) }}" target="_blank">{{ $file2->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">ใบรับรองแพทย์</label>
                @if ($file3)
                    <a href="{{ asset('storage/' . $file3->file_path) }}" target="_blank">{{ $file3->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">หลักฐานการขออนุญาตตามกฎหมายอื่น</label>
                @if ($file4)
                    <a href="{{ asset('storage/' . $file4->file_path) }}" target="_blank">{{ $file4->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">ใบอนุญาตฉบับเก่า</label>
                @if ($file5)
                    <a href="{{ asset('storage/' . $file5->file_path) }}" target="_blank">{{ $file5->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">แบบรายการตรวจสอบ</label>
                @if ($file6)
                    <a href="{{ asset('storage/' . $file6->file_path) }}" target="_blank">{{ $file6->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">แบบสรุปผลการรับฟังความคิดเห็น</label>
                @if ($file7)
                    <a href="{{ asset('storage/' . $file7->file_path) }}" target="_blank">{{ $file7->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">แผนที่ตั้งสถานประกอบกิจการ</label>
                @if ($file8)
                    <a href="{{ asset('storage/' . $file8->file_path) }}" target="_blank">{{ $file8->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

        </div>

        {{-- แสดงเฉพาะถ้า status = รอรับรอง --}}
        @if ($trashRequest->status === 'รอรับรอง')
            <div class="mb-3">
                <label class="form-label d-block">ผลการตรวจสอบ</label>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inspection_result" id="pass"
                        value="pass">
                    <label class="form-check-label" for="pass">ผ่าน</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inspection_result" id="not-pass"
                        value="not-pass">
                    <label class="form-check-label" for="not-pass">ไม่ผ่าน</label>
                </div>

                <div class="mt-3">
                    <label for="note" class="form-label">หมายเหตุ / ข้อเสนอแนะ</label>
                    <textarea name="note" id="note" rows="3" class="form-control" placeholder="กรอกหมายเหตุที่นี่..."></textarea>
                </div>

                <div class="mt-3">
                    <button id="sendReply" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </div>
        @endif



        {{-- ใส่ใต้เนื้อหา view ของคุณ --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            const requestId = {{ $trashRequest->id }};
            const userId = {{ auth()->user()->id ?? 'null' }};

            document.getElementById('sendReply').addEventListener('click', () => {
                const note = document.getElementById('note').value;
                const result = document.querySelector('input[name="inspection_result"]:checked');

                if (!result) {
                    Swal.fire('แจ้งเตือน', 'กรุณาเลือกผลการตรวจสอบ', 'warning');
                    return;
                }

                if (result.value === 'not-pass' && note.trim() === '') {
                    Swal.fire('แจ้งเตือน', 'กรุณากรอกหมายเหตุสำหรับสถานะไม่ผ่าน', 'warning');
                    return;
                }

                fetch(`{{ route('admin_trash.accept') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            request_id: requestId,
                            user_id: userId,
                            inspection_result: result.value,
                            note: note
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('สำเร็จ!', 'บันทึกข้อมูลเรียบร้อยแล้ว', 'success')
                                .then(() => {
                                    const type = "{{ $trashRequest->type }}"; // เอา type จาก request ปัจจุบัน
                                    window.location.href = `/admin/request/public-health/showdata/${type}`;
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
