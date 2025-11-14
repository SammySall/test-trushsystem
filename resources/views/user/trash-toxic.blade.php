@extends('layout.layout-user')
@section('title', 'Trash Toxic Page')
@section('body-class', 'body-garbage-bg')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-5">
                <a href="/user/waste_payment">
                    <img src="../../img/ToxicTrash/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                </a>

                <div class="mb-2 d-flex justify-content-center align-items-end">
                    <img src="../../img/ToxicTrash/Banner-1.png" alt="จุดทิ้งขยะมีพิษ" class="trash-toxic-img">
                </div>

                <div class="row">
                    <div class="col-9 d-flex flex-column align-items-center">
                        <div class="mb-1 w-100 d-flex justify-content-end">
                            <img src="../../img/ToxicTrash/Banner-2.png" alt="ถังขยะ" class="trash-toxic-banner">
                        </div>
                        <div class="w-100 d-flex justify-content-end">
                            <img src="../../img/ToxicTrash/Banner-3.png" alt="ตำแหน่งของคุณ" class="trash-toxic-banner">
                        </div>
                    </div>

                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img src="../../img/GarbageCarStatus/Arrow.png" alt="ลูกศร" class="trash-arrow">
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>
            </div>
        </div>
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var map = L.map('map').setView([13.487003, 100.99601], 13);

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

            // icon ถังขยะมีพิษ
            var toxicIcon = L.icon({
                iconUrl: '../../img/ToxicTrash/Icon-1.png',
                iconSize: [22, 30],
                iconAnchor: [11, 30],
                popupAnchor: [0, -30]
            });

            // icon ผู้ใช้
            var userIcon = L.icon({
                iconUrl: '../../img/ToxicTrash/Icon-2.png',
                iconSize: [20, 32],
                iconAnchor: [10, 30],
                popupAnchor: [0, -30]
            });

            // ดึงข้อมูลจากฐานข้อมูล
            var points = @json($locations);

            points.forEach(p => {
                L.marker([p.lat, p.lng], { icon: toxicIcon })
                .addTo(map)
                .bindPopup(`<b>${p.name}</b>`);
            });

            // แสดงตำแหน่งผู้ใช้
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    L.marker([userLat, userLng], { icon: userIcon })
                        .addTo(map)
                        .bindPopup("คุณอยู่ที่นี่")
                        .openPopup();

                    map.setView([userLat, userLng], 15);
                });
            }

        });
    </script>

@endsection
