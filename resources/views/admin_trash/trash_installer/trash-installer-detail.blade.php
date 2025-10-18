@extends('layout.layout-admin-trash')
@section('title', 'Dashboard')

@section('content')
    <h3 class="text-center px-2 mb-4">รายละเอียดข้อมูลการติดตั้งถังขยะ</h3>

    <div class="mb-3"><strong>ชื่อ :</strong> {{ $location->name ?? '-' }}</div>
    <div class="mb-3"><strong>ที่อยู่ :</strong> {{ $location->address ?? '-' }}</div>
    <div class="mb-3"><strong>เบอร์โทรศัพท์ :</strong> {{ $location->tel ?? '-' }}</div>

    <div class="mb-3">
        <strong>สถานะ :</strong>
        @if ($location->status == 'เสร็จสิ้น')
            <span class="badge bg-success">ติดตั้งถังขยะแล้ว</span>
        @else
            <span class="badge bg-warning">รอติดตั้ง</span>
        @endif
    </div>

    <div class="mb-3"><strong>แผนที่ตำแหน่งติดตั้ง:</strong></div>
    <div id="map" style="height: 400px; border-radius: 15px; overflow: hidden;"></div>

    {{-- ตารางบิล --}}
    <div id="data_table_wrapper" class="mt-4">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-6">
                <div id="data_table_length">
                    <label class="d-flex align-items-center">
                        <span class="me-1">แสดง</span>
                        <select name="data_table_length" aria-controls="data_table" class="form-select form-select-sm me-1"
                            style="width:auto;">
                            <option value="10">10</option>
                            <option value="40">40</option>
                            <option value="80">80</option>
                            <option value="-1">ทั้งหมด</option>
                        </select>
                        <span>รายการ</span>
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="data_table_filter">
                    <label class="d-flex align-items-center justify-content-end">
                        <span class="me-2">ค้นหา :</span>
                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="data_table"
                            style="width:auto;">
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable no-footer" id="data_table"
                    aria-describedby="data_table_info">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>จำนวนเงิน</th>
                            <th>สถานะการชำระ</th>
                            <th>วันครบกำหนด</th>
                            <th>วันที่ชำระ</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if ($location->bills->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                        @else
                            @foreach ($location->bills as $index => $bill)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ number_format($bill->amount, 2) }} บาท</td>
                                    <td>
                                        @if ($bill->status == 'ชำระแล้ว')
                                            <span class="badge bg-success">{{ $bill->status }}</span>
                                        @elseif ($bill->status == 'รอการตรวจสอบ')
                                            <span class="badge bg-warning text-dark">{{ $bill->status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $bill->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $bill->paid_date ? \Carbon\Carbon::parse($bill->paid_date)->format('d/m/Y') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ส่วนท้าย --}}
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div>แสดง 1 ถึง {{ $location->bills->count() }} จาก {{ $location->bills->count() }} รายการ</div>
            </div>
            <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                <ul class="pagination">
                    <li class="paginate_button page-item previous disabled"><a class="page-link">ก่อนหน้า</a></li>
                    <li class="paginate_button page-item active"><a href="#" class="page-link">1</a></li>
                    <li class="paginate_button page-item next disabled"><a class="page-link">ถัดไป</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lat = {{ $location->lat ?? 13.736717 }};
            const lng = {{ $location->lng ?? 100.523186 }};

            const map = L.map("map").setView([lat, lng], 15);

            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            const marker = L.marker([lat, lng]).addTo(map)
                .bindPopup("{{ $location->name ?? 'ตำแหน่งติดตั้งถังขยะ' }}")
                .openPopup();

            map.on('click', function(e) {
                if (confirm("ต้องการเปลี่ยนตำแหน่งหมุดหรือไม่?")) {
                    marker.setLatLng(e.latlng).bindPopup("ตำแหน่งใหม่").openPopup();
                }
            });
        });
    </script>
@endsection
