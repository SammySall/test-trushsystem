@extends('layout.layout-request')
@section('title', 'ใบอนุญาตประกอบกิจการรับทำการเก็บ')
@section('request-header-img', 'waste-disposal-business-license')
@section('request-header',
    'ใบอนุญาต
    ประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลหรือมูลฝอย')

@section('request-content')
    <div class="list-group">
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
                    <label for="prefix" class="form-label">คำนำหน้า<span class="text-danger">*</span></label>
                    <select id="prefix" name="field_1" class="form-control" required>
                        <option value="">-- โปรดเลือก --</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">ชื่อ - นามสกุล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_2" id="name" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">อายุ<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="field_5" required>
                </div>
            </div>

            {{-- ข้อมูลที่อยู่ --}}
            <div class="col-md-3 " style="display: none">
                <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="type" value="waste-disposal-business-license" required>
            </div>

            <div class="row g-3 align-items-end mt-3">
                <div class="col-md-3">
                    <label class="form-label">สัญชาติ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_6" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">บ้านเลขที่<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_7" required>
                </div>
                <div class="col-md-3">
                    <label for="alley" class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" name="field_14" id="alley">
                </div>
                <div class="col-md-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" class="form-control" name="field_15" id="road">
                </div>
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่</label>
                    <input type="text" class="form-control" name="field_8">
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_9" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_10" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_11" required>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="field_3" id="tel" pattern="[0-9]{10}"
                        maxlength="10" required>
                </div>
            </div>

            {{-- Personal / Corporation --}}
            <div class="row g-3 mt-3">
                <label class="form-label">
                    ขอยื่นคำขอรับใบอนุญาตประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลมูลฝอยโดยทำเป็น
                    ธุรกิจประเภท <span class="text-danger">*</span>
                </label>
                <div class="col-md-8">
                    <label class="form-label">ประเภท <span class="text-danger">*</span></label>
                    <select name="addon[option]" id="option" class="form-select" required>
                        <option value="">-- โปรดเลือกประเภท --</option>
                        <option value="1">เก็บขนสิ่งปฏิกูล</option>
                        <option value="2">เก็บขนและกำจัดสิ่งปฏิกูล</option>
                        <option value="3">เก็บขนมูลฝอย</option>
                        <option value="4">เก็บขนและกำจัดมูลฝอย</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">กำจัดอยู่ที่</label>
                    <input type="text" class="form-control" name="addon[at]" required>
                </div>
            </div>

            {{-- ไฟล์แนบ --}}
            <div class="mb-3 mt-3">
                <label class="form-label">
                    แนบเอกสารประกอบ <br>
                    <span class="text-danger">ประเภทไฟล์: jpg,jpeg,png,pdf (ไม่เกิน 2 MB)</span>
                </label>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck1">
                    <label class="form-check-label"
                        for="fileCheck1">สำเนาบัตรประจำตัวประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ</label>
                    <input type="file" name="files1[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck2">
                    <label class="form-check-label" for="fileCheck2">สำเนาทะเบียนบ้าน</label>
                    <input type="file" name="files2[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck3">
                    <label class="form-check-label" for="fileCheck3">
                        สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทน นิติบุคคล
                    </label>
                    <input type="file" name="files3[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck5">
                    <label class="form-check-label" for="fileCheck5">หนังสือรับรองอำนาจ
                        (กรณีเจ้าของกิจการไม่มายื่นด้วยตนเอง)</label>
                    <input type="file" name="files4[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck6">
                    <label class="form-check-label" for="fileCheck6">เอกสารหลักฐานอื่น ๆ </label>
                    <input type="file" name="files5[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                {{-- แผนที่เลือกตำแหน่ง --}}
                <div class="mt-4">
                    <label class="form-label">ตำแหน่งที่ตั้งสถานประกอบกิจการ</label>
                    <p class="text-muted">
                        คลิกที่แผนที่เพื่อเลือกตำแหน่ง หรือกดปุ่ม
                        <span id="currentLocationBtn" class="text-primary"
                            style="cursor: pointer; text-decoration: underline;">
                            "ตำแหน่งของฉัน"
                        </span>
                    </p>
                    <div id="map" style="width: 100%; height: 400px; border-radius: 10px;"></div>

                    {{-- hidden input ส่งค่าไป Controller --}}
                    <input type="hidden" name="lat" id="latitude">
                    <input type="hidden" name="lng" id="longitude">
                </div>

            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">บันทึก</button>
            </div>
        </form>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ!',
                text: 'ทำการร้องขอเสร็จสิ้นเรียบร้อยแล้ว',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.location.href = "{{ url('/') }}";
            });
        </script>
    @endif

    {{-- ✅ Checkbox toggle + แสดง input file --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".file-checkbox");
            checkboxes.forEach(cb => {
                cb.addEventListener("change", function() {
                    const parent = this.closest(".form-check");
                    const fileInput = parent.querySelector(".file-input");
                    if (fileInput) {
                        if (this.checked) {
                            fileInput.style.display = "block";
                            fileInput.style.opacity = 0;
                            fileInput.style.transition = "opacity 0.3s ease";
                            requestAnimationFrame(() => fileInput.style.opacity = 1);
                        } else {
                            fileInput.style.opacity = 0;
                            fileInput.addEventListener("transitionend", function hide() {
                                fileInput.style.display = "none";
                                fileInput.value = "";
                                fileInput.removeEventListener("transitionend", hide);
                            });
                        }
                    }
                });
            });
        });
    </script>

    {{-- ✅ Leaflet Maps สำหรับเลือกตำแหน่ง --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const defaultPos = [13.7563, 100.5018]; // กรุงเทพเป็นค่าเริ่มต้น
            const map = L.map('map').setView(defaultPos, 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker;

            function placeMarker(latlng) {
                if (marker) {
                    marker.setLatLng(latlng);
                } else {
                    marker = L.marker(latlng).addTo(map);
                }

                // อัพเดตค่า hidden input
                document.getElementById('latitude').value = latlng.lat.toFixed(6);
                document.getElementById('longitude').value = latlng.lng.toFixed(6);
            }

            // คลิกบนแผนที่
            map.on('click', function(e) {
                placeMarker(e.latlng);
            });

            // ปุ่มตำแหน่งของฉัน
            document.getElementById('currentLocationBtn').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(pos) {
                        const myPos = {
                            lat: pos.coords.latitude,
                            lng: pos.coords.longitude
                        };
                        map.setView(myPos, 16);
                        placeMarker(myPos);
                    }, function() {
                        alert('ไม่สามารถเข้าถึงตำแหน่งของคุณได้');
                    });
                } else {
                    alert('เบราว์เซอร์ของคุณไม่รองรับ Geolocation');
                }
            });
        });
    </script>

@endsection
