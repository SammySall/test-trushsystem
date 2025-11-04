@extends('layout.layout-admin-request')
@section('title', ' รายละเอียดใบอนุญาตประกอบกิจการรับทำการเก็บ')

@section('content')
    <h4 class="text-center my-2 mx-4">
        รายละเอียดใบอนุญาตประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลหรือมูลฝอย
    </h4>

    <div class="list-group text-start">

        {{-- วันที่ --}}
        <div class="mb-3">
            <label class="form-label">วันที่</label>
            <input type="text" name="field_date" class="form-control" value="{{ date('d/m/Y') }}" readonly>
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
        <div class="row g-3 align-items-end mt-3">
            <div class="col-md-3">
                <label class="form-label">สัญชาติ</label>
                <input type="text" class="form-control" value="{{ $trashRequest->nationality ?? '-' }}" readonly>
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
        <div class="row g-3 mt-3">
            <label class="form-label">
                ขอยื่นคำขอรับใบอนุญาตประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลมูลฝอยโดยทำเป็น
                ธุรกิจประเภท
            </label>
            <div class="col-md-8">
                <label class="form-label">ประเภท </label>
                <select name="option" id="option" class="form-select" disabled>
                    <option {{ ($addon['option'] ?? '') == '1' ? 'checked' : '' }}>เก็บขนสิ่งปฏิกูล</option>
                    <option {{ ($addon['option'] ?? '') == '2' ? 'checked' : '' }}>เก็บขนและกำจัดสิ่งปฏิกูล</option>
                    <option {{ ($addon['option'] ?? '') == '3' ? 'checked' : '' }}>เก็บขนมูลฝอย</option>
                    <option {{ ($addon['option'] ?? '') == '4' ? 'checked' : '' }}>เก็บขนและกำจัดมูลฝอย</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">กำจัดอยู่ที่</label>
                <input type="text" class="form-control" value="{{ $addon['at'] ?? '-' }}" disabled>
            </div>
        </div>

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
                @if ($file2)
                    <a href="{{ asset('storage/' . $file2->file_path) }}" target="_blank">{{ $file2->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck3">
                    สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทน นิติบุคคล
                </label>
                @if ($file3)
                    <a href="{{ asset('storage/' . $file3->file_path) }}" target="_blank">{{ $file3->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck5">หนังสือรับรองอำนาจ
                    (กรณีเจ้าของกิจการไม่มายื่นด้วยตนเอง)</label>
                @if ($file4)
                    <a href="{{ asset('storage/' . $file4->file_path) }}" target="_blank">{{ $file4->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="form-check mb-3">
                <label class="form-check-label" for="fileCheck6">เอกสารหลักฐานอื่น ๆ </label>
                @if ($file5)
                    <a href="{{ asset('storage/' . $file5->file_path) }}" target="_blank">{{ $file5->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            {{-- แผนที่เลือกตำแหน่ง --}}
            <div class="mt-4">
                <label class="form-label">ตำแหน่งที่ตั้งสถานประกอบกิจการโดย</label>
                <div id="map" style="width: 100%; height: 400px; border-radius: 10px;"></div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

            </div>
            {{-- แสดงเฉพาะถ้า status = รอรับรอง --}}
            @if ($trashRequest->status === 'รอรับเรื่อง')
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
        </div>

    </div>


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

    {{-- Leaflet Maps สำหรับแสดงตำแหน่งจากฐานข้อมูลเท่านั้น --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ดึงค่าจาก hidden input หรือจาก DB
            const lat = parseFloat("{{ $trashRequest->latitude ?? 13.7563 }}");
            const lng = parseFloat("{{ $trashRequest->longitude ?? 100.5018 }}");
            const map = L.map('map', {
                dragging: false,
                zoomControl: false,
                scrollWheelZoom: false,
                doubleClickZoom: false,
                boxZoom: false,
                keyboard: false
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // วาง marker ที่ตำแหน่ง
            if (!isNaN(lat) && !isNaN(lng)) {
                L.marker([lat, lng]).addTo(map);
            }
        });
    </script>

@endsection
    