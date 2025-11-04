@extends('layout.layout-admin-request')
@section('title', 'ต่ออายุใบอนุญาต')

@section('content')
    @switch($type)
        @case('trash-request')
            @php $formTitle = 'คำร้องขออนุญาตลงถังขยะ'; @endphp
        @break

        @case('market-establishment-license')
            @php $formTitle = 'ใบอนุญาตจัดตั้งตลาด'; @endphp
        @break

        @case('food-sales-license')
            @php $formTitle = 'ใบอนุญาตจัดตั้งสถานที่จำหน่ายอาหาร หรือสะสมอาหาร'; @endphp
        @break

        @case('health-hazard-license')
            @php $formTitle = 'ใบอนุญาตประกอบกิจการที่เป็นอันตรายต่อสุขภาพ'; @endphp
        @break

        @case('waste-disposal-business-license')
            @php $formTitle = 'ใบอนุญาตประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลหรือมูลฝอย'; @endphp
        @break

        @default
            @php $formTitle = 'ไม่พบข้อมูลประเภทใบอนุญาต'; @endphp
    @endswitch
    <div class="container py-3">
        <h3 class="text-center px-2">คำร้องต่อใบอนุญาต{{ $formTitle }}</h3>
        <h4 class="text-center px-2">ตารางแสดงคำร้องต้องการต่อใบอนุญาต</h4>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อผู้ยื่น</th>
                        <th>วันที่หมดอายุ</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trashRequests as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->fullname ?? '-' }}</td>
                            <td>{{ $item->license_expire_at ?? '-' }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                {{-- <a href="{{ route('admin_request.public_health.detail', $item->id) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> ดูรายละเอียด
                                </a> --}}
                                <a href="{{ url('/license/' . $item->type . '/pdf/' . $item->id) }}" target="_blank"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-file-earmark-pdf"></i> ดูใบอนุญาต
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">ไม่พบข้อมูลที่ต้องต่ออายุภายใน 1 เดือน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
