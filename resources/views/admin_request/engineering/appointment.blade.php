@extends('layout.layout-admin-request')
@section('title', 'กองสาธารณสุขฯ')

@section('content')

    @switch($type)
        @case('trash-request')
            @php $formTitle = 'คำร้องขออนุญาตลงถังขยะ'; @endphp
        @break

        @case('market-establishment-license')
            @php $formTitle = 'คำขอรับใบอนุญาตจัดตั้งตลาด'; @endphp
        @break

        @case('food-sales-license')
            @php $formTitle = 'คำขอรับใบอนุญาตจัดตั้งสถานที่จำหน่ายอาหาร หรือสะสมอาหาร'; @endphp
        @break

        @case('health-hazard-license')
            @php $formTitle = 'คำขอรับใบอนุญาตประกอบกิจการที่เป็นอันตรายต่อสุขภาพ'; @endphp
        @break

        @case('waste-disposal-business-license')
            @php $formTitle = 'คำขอรับใบอนุญาตประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลหรือมูลฝอย'; @endphp
        @break

        @default
            @php $formTitle = 'ไม่พบข้อมูลประเภทใบอนุญาต'; @endphp
    @endswitch

    <h3 class="text-center px-2">{{ $formTitle }}</h3>
    <h4 class="text-center px-2">ตารางแสดงข้อมูลฟอร์มที่ส่งเข้ามา</h4>

    {{-- ฟิลเตอร์ --}}
    <div id="data_table_wrapper" class="mt-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-6">
                <label class="d-flex align-items-center">
                    <span class="me-1">แสดง</span>
                    <select id="data_table_length" class="form-select form-select-sm me-1" style="width:auto;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="-1">ทั้งหมด</option>
                    </select>
                    <span>รายการ</span>
                </label>
            </div>
            <div class="col-sm-12 col-md-6">
                <label class="d-flex align-items-center justify-content-end">
                    <span class="me-2">ค้นหา :</span>
                    <input type="search" id="data_table_search" class="form-control form-control-sm" style="width:auto;">
                </label>
            </div>
        </div>

        {{-- ตารางข้อมูล --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle" id="data_table">
                <thead>
                    <tr>
                        <th>วันที่ขอ</th>
                        <th>ผู้ขอใบอนุญาต</th>
                        <th>วันนัดหมาย</th>
                        <th>วันที่สะดวก</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashRequests as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->fullname ?? '-' }}</td>
                            <td>{{ $item->appointment_date ?? '-' }}</td>
                            <td>{{ $item->convenient_date ?? '-' }}</td>
                            <td>
                                <span class="badge rounded-pill text-bg-primary">{{ $item->status }}</span>
                            </td>
                            <td>
                                @if ($item->status !== 'รอยืนยันนัดหมาย')
                                    <a href="{{ route('admin.engineer.appointment.detail', [
                                        'type' => $item->type,
                                        'id' => $item->id,
                                    ]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-calendar-check"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin_trash.show_pdf', $item->id) }}" target="_blank"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>
                                {{-- ปุ่มค้นหา (ไม่ต้องใช้ SweetAlert) --}}
                                <a href="{{ route('admin_request.detail', [
                                    'type' => $item->type,
                                    'id' => $item->id,
                                ]) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="bi bi-search"></i>
                                </a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">ไม่มีข้อมูลฟอร์ม</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- pagination --}}
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div>แสดง 1 ถึง 2 จาก 2 รายการ</div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        $userId = null;
        if (session('token')) {
            $payload = json_decode(Crypt::decryptString(session('token')), true);
            $userId = $payload['userId'] ?? null;
        }
    @endphp
@endsection
