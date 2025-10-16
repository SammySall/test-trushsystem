@extends('layout.layout-user')
@section('title', 'Emergency Page')
@section('body-class', 'body-garbage-bg')

@section('content')
    <div class="container py-4">
        <form class="row">

            <div>
                <a href="/homepage">
                    <img src="../../img/ToxicTrash/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                </a>
            </div>

            <div class="d-flex align-items-center mb-3">
                <label for="salutation" class="form-label me-2 mb-0 label-emergency">เลือกเหตุที่ต้องการแจ้ง</label>
                <select class="form-select" id="salutation" name="salutation" required style="width: 200px;">
                    <option value="อุบัติเหตุ" selected>อุบัติเหตุ</option>
                    <option value="นาย">นาย</option>
                    <option value="นาง">นาง</option>
                    <option value="นางสาว">นางสาว</option>
                </select>
            </div>
            <!-- คอลัมน์ซ้าย -->
            <div class="col-md-5 bg-body-secondary emergency-form-bg text-black p-3">
                <div class="mb-2">
                    <label for="picture-emergency" class="form-label">ตัวอย่างภาพสถานที่เกิดเหตุ</label>
                    <input type="file" name="สถานที่เกิดเหตุ" id="picture-emergency" class="form-control">
                </div>

                <div class="mb-2">
                    <label for="name" class="form-label">ชื่อผู้แจ้งเหตุ</label>
                    <input type="name" class="form-control" id="name">
                </div>

                <div class="mb-2">
                    <label for="tel" class="form-label">เบอร์โทรที่ติดต่อได้</label>
                    <input type="tel" class="form-control" id="tel">
                </div>

                <div class="mb-2">
                    <label for="description" class="form-label">รายละเอียด</label>
                    <textarea class="form-control" id="description" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger rounded-pill px-4">คลิกเพื่อแจ้งเหตุ</button>
                </div>
            </div>



            <!-- คอลัมน์ขวา: แผนที่ -->
            <div class="col-md-7">
                <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
                <div class="d-flex justify-content-end mt-2">
                    <img src="../../img/Emergency/Banner.png" alt="ตำแหน่งของคุณ" class="emergency-banner">
                </div>
            </div>
        </form>
    </div>


    {{-- โหลด Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([13.6840, 100.5500], 13);

            // พื้นหลังแผนที่
            var baseMaps = {
                "แผนที่": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }),
                "ดาวเทียม": L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                })
            };
            baseMaps["แผนที่"].addTo(map);
            L.control.layers(baseMaps).addTo(map);

            var userIcon = L.icon({
                iconUrl: '../../img/ToxicTrash/Icon-2.png',
                iconSize: [20, 32],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            var userMarker = null; // เก็บ Marker ที่เลือก

            // แสดงตำแหน่งปัจจุบัน
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    userMarker = L.marker([lat, lng], {
                            icon: userIcon
                        })
                        .addTo(map)
                        .bindPopup("คุณอยู่ที่นี่")
                        .openPopup();

                    // คลิกที่ Marker ปัจจุบันเพื่อลบ
                    userMarker.on('click', function() {
                        map.removeLayer(userMarker);
                        userMarker = null;
                    });

                    map.setView([lat, lng], 15);
                });
            }

            // คลิกเลือกตำแหน่งใหม่บนแผนที่
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // ลบ Marker เก่า
                if (userMarker) map.removeLayer(userMarker);

                // สร้าง Marker ใหม่
                userMarker = L.marker([lat, lng], {
                        icon: userIcon
                    })
                    .addTo(map)
                    .bindPopup("ตำแหน่งที่คุณเลือก")
                    .openPopup();

                // คลิก Marker เพื่อลบ
                userMarker.on('click', function() {
                    map.removeLayer(userMarker);
                    userMarker = null;
                });

                console.log("เลือกพิกัด:", lat, lng);
            });
        });
    </script>

@endsection
