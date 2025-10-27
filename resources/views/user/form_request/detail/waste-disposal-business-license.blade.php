@extends('layout.layout-request')
@section('title', 'ใบอนุญาตประกอบกิจการรับทำการเก็บ')

@section('request-content')
    <div class="text-center">
        <h4 class="header-form-name my-2 mx-4">
            รายละเอียดใบอนุญาตประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลหรือมูลฝอย
        </h4>
    </div>


    <div class="list-group text-start">
        <form action="{{ route('trash-request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                        <a href="{{ asset('storage/' . $file3->file_path) }}"
                            target="_blank">{{ $file3->file_name }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>

                <div class="form-check mb-2">
                    <label class="form-check-label" for="fileCheck5">หนังสือรับรองอำนาจ
                        (กรณีเจ้าของกิจการไม่มายื่นด้วยตนเอง)</label>
                    @if ($file4)
                        <a href="{{ asset('storage/' . $file4->file_path) }}"
                            target="_blank">{{ $file4->file_name }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>

                <div class="form-check mb-3">
                    <label class="form-check-label" for="fileCheck6">เอกสารหลักฐานอื่น ๆ </label>
                    @if ($file5)
                        <a href="{{ asset('storage/' . $file5->file_path) }}"
                            target="_blank">{{ $file5->file_name }}</a>
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
            </div>

    </div>

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
