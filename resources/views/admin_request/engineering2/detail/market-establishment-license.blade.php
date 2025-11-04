@extends('layout.layout-admin-request')
@section('title', 'คำขอรับใบอนุญาตจัดตั้งตลาด')

@section('content')
    <h4 class="header-form-name my-2 mx-4 text-center">
        รายละเอียดคำขอรับใบอนุญาตจัดตั้งตลาด
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

        {{-- ข้อมูลที่อยู่ --}}
        <div class="col-md-3 " style="display: none">
            <label class="form-label">ประเภท<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="type" value="health-hazard-license" required>
        </div>

        <div class="row g-3 align-items-end mt-3">
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
            <div class="col-md-3">
                <label class="form-label">ถนน</label>
                <input type="text" class="form-control" value="{{ $trashRequest->road ?? '-' }}" readonly>
            </div>
        </div>

        <div class="row g-3 mt-3">
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
            <div class="d-flex flex-wrap align-items-center">
                <div>
                    <label class="form-label d-block">
                        ขอยื่นคำขอรับใบอนุญาตประกอบกิจการ <span class="text-danger">*</span>
                    </label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                {{ ($addon['option'] ?? '') == 'individual' ? 'checked' : '' }} disabled>
                            <label class="form-check-label">ตลาดที่มีโครงสร้างอาคาร</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                {{ ($addon['option'] ?? '') == 'corporation' ? 'checked' : '' }} disabled>
                            <label class="form-check-label">ตลาดที่ไม่มีโครงสร้างอาคาร</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <label class="form-label">พื้นที่ประกอบการ(ตารางเมตร)</label>
                <input type="text" class="form-control" value="{{ $addon['area'] ?? '-' }}" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">บ้านเลขที่</label>
                <input type="text" class="form-control" value="{{ $addon['home_no'] ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="alley" class="form-label">ตรอก/ซอย</label>
                <input type="text" class="form-control" value="{{ $addon['alley'] ?? '-' }}" id="alley"
                    readonly>
            </div>
            <div class="col-md-3">
                <label for="road" class="form-label">ถนน</label>
                <input type="text" class="form-control" value="{{ $addon['road'] ?? '-' }}" id="road" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">หมู่ที่</label>
                <input type="text" class="form-control" value="{{ $addon['subdistrict'] ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">แขวง/ตำบล</label>
                <input type="text" class="form-control" value="{{ $addon['district']['type'] ?? '-' }}"
                    value="ท่าข้าม" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เขต/อำเภอ</label>
                <input type="text" class="form-control" value="{{ $addon['individual'] ?? '-' }}" value="บางปะกง"
                    readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">จังหวัด</label>
                <input type="text" class="form-control" value="{{ $addon['province'] ?? '-' }}" value="ฉะเชิงเทรา"
                    readonly>
            </div>
            <div class="col-md-3">
                <label for="tel" class="form-label">เบอร์โทร</label>
                <input type="tel" class="form-control" value="{{ $addon['tel'] ?? '-' }}" readonly>
            </div>
        </div>

        {{-- ไฟล์แนบ (หลาย checkbox) --}}
        <div class="mb-3 mt-3">
            <label class="form-label">
                แนบเอกสารประกอบ <br>
                <span class="text-danger">ประเภทไฟล์: jpg,jpeg,png,pdf (ไม่เกิน 2 MB)</span>
            </label>

            @php
                // ดึงไฟล์แต่ละ field ออกมา
                $file1 = $trashRequest->files->where('field_name', 'files1')->first();
                $file2 = $trashRequest->files->where('field_name', 'files2')->first();
                $file3 = $trashRequest->files->where('field_name', 'files3')->first();
                $file4 = $trashRequest->files->where('field_name', 'files4')->first();
                $file5 = $trashRequest->files->where('field_name', 'files5')->first();
                $file6 = $trashRequest->files->where('field_name', 'files6')->first();
            @endphp

            <div class="form-check mb-2">
                <label class="form-check-label"
                    for="fileCheck1">สำเนาบัตรประจำตัวประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ</label>
                @if ($file1)
                    <a href="{{ asset('storage/' . $file1->file_path) }}" target="_blank">{{ $file1->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck2">สำเนาทะเบียนบ้าน</label>
                @if ($file3)
                    <a href="{{ asset('storage/' . $file2->file_path) }}" target="_blank">{{ $file2->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck3">สำเนาใบอนุญาตตามกฎหมายที่เกี่ยวข้อง</label>
                @if ($file3)
                    <a href="{{ asset('storage/' . $file3->file_path) }}" target="_blank">{{ $file3->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck4">สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล
                    พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทนนิติ
                    บุคคล (ในกรณีที่ผู้ขออนุญาตเป็นนิติบุคคล)</label>
                @if ($file4)
                    <a href="{{ asset('storage/' . $file4->file_path) }}" target="_blank">{{ $file4->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
            <div class="form-check mb-2">
                <label class="form-check-label"
                    for="fileCheck5">หนังสือมอบอำนาจในกรณีที่เจ้าของกิจการไม่มายื่นขอรับใบอนุญาตด้วยตนเอง
                </label>
                @if ($file5)
                    <a href="{{ asset('storage/' . $file5->file_path) }}" target="_blank">{{ $file5->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck6">อื่น ๆ ตามที่องค์การบริหารส่วนตำบลหนองโพธิ์กำหนด
                </label>
                @if ($file6)
                    <a href="{{ asset('storage/' . $file6->file_path) }}" target="_blank">{{ $file6->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
        </div>

    </div>
    {{-- แสดงเฉพาะถ้า status = รอรับรอง --}}
    @if ($trashRequest->status === 'รอรับเรื่อง')
        <div class="mb-3">
            <label class="form-label d-block">ผลการตรวจสอบ</label>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inspection_result" id="pass" value="pass">
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
