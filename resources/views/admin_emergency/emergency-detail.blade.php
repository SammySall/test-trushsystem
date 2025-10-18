@extends('layout.layout-admin-emergency')
@section('title', 'รายละเอียดเหตุฉุกเฉิน')

@section('content')
    <h3 class="text-center px-2 mb-4">รายละเอียดเหตุฉุกเฉิน</h3>

    <div class="mb-3"><strong>ชื่อ :</strong> {{ $location->name ?? '-' }}</div>
    <div class="mb-3"><strong>เบอร์โทรศัพท์ :</strong> {{ $location->tel ?? '-' }}</div>
    <div class="mb-3"><strong>รายละเอียด :</strong> {{ $location->address ?? '-' }}</div>

    {{-- ลิงก์ไปยังรูปเหตุฉุกเฉิน --}}
    <div class="mb-3">
        <strong>รูปเหตุฉุกเฉิน:</strong>
        @if ($location->picture)
            <a href="{{ asset('storage/' . $location->picture) }}" target="_blank">
                ดูรูปเหตุฉุกเฉิน
            </a>
        @else
            <span>ไม่มีรูปเหตุฉุกเฉิน</span>
        @endif
    </div>

    {{-- <div class="mb-3">
        <strong>สถานะ :</strong>
        @if ($location->status == 'เสร็จสิ้น')
            <span class="badge bg-success">ติดตั้งถังขยะแล้ว</span>
        @else
            <span class="badge bg-warning">รอติดตั้ง</span>
        @endif
    </div> --}}

    <div class="mb-3"><strong>แผนที่ตำแหน่งติดตั้ง:</strong></div>
    <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>

    {{-- โหลด Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // รับพิกัดจากฐานข้อมูล (หรือใช้ค่า default ถ้าไม่มี)
            const lat = {{ $location->lat ?? 13.736717 }};
            const lng = {{ $location->lng ?? 100.523186 }};

            // สร้างแผนที่
            const map = L.map("map").setView([lat, lng], 15);

            // ใช้ tile แบบ Google Maps
            const googleMap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            // ปักหมุด
            const marker = L.marker([lat, lng]).addTo(map)
                .bindPopup("{{ $location->name ?? 'ตำแหน่งติดตั้งถังขยะ' }}")
                .openPopup();

            // รองรับการคลิกเพิ่มหมุด (ถ้าอยากให้เลือกตำแหน่งใหม่)
            map.on('click', function(e) {
                if (confirm("ต้องการเปลี่ยนตำแหน่งหมุดหรือไม่?")) {
                    marker.setLatLng(e.latlng)
                        .bindPopup("ตำแหน่งใหม่")
                        .openPopup();
                }
            });
        });
    </script>
@endsection
