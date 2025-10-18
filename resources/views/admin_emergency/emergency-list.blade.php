@extends('layout.layout-admin-emergency')
@section('title', 'รายการเหตุการณ์ฉุกเฉิน')

@section('content')
    <h3 class="text-center mb-4">เหตุ{{ $title }}</h3>

    {{-- ฟิลเตอร์ --}}
    <div id="data_table_wrapper">
        <div class="row mb-2">
            {{-- จำนวนข้อมูลที่แสดง --}}
            <div class="col-sm-12 col-md-6">
                <div id="data_table_length">
                    <label class="d-flex align-items-center">
                        <span class="me-1">แสดง</span>
                        <select name="data_table_length" aria-controls="data_table" class="form-select form-select-sm me-1"
                            style="width: auto;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="-1">ทั้งหมด</option>
                        </select>
                        <span>รายการ</span>
                    </label>
                </div>
            </div>

            {{-- ช่องค้นหา --}}
            <div class="col-sm-12 col-md-6">
                <div id="data_table_filter">
                    <label class="d-flex align-items-center justify-content-end">
                        <span class="me-2">ค้นหา :</span>
                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="data_table"
                            style="width: auto;">
                    </label>
                </div>
            </div>
        </div>

        {{-- ตาราง --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable" id="data_table"
                    aria-describedby="data_table_info">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>ชื่อผู้แจ้ง</th>
                            <th>เบอร์โทร</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($emergencies as $index => $emergency)
                            <tr>
                                <td>{{ ($emergencies->currentPage() - 1) * $emergencies->perPage() + $index + 1 }}</td>
                                <td>{{ $emergency->name }}</td>
                                <td>{{ $emergency->tel }}</td>
                                <td>
                                    <a href="{{ route('admin.emergency.detail', ['id' => $emergency->id]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">ไม่มีรายการเหตุการณ์</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="row mt-2">
            <div class="col-sm-12 col-md-5">
                <div>แสดง {{ $emergencies->firstItem() ?? 0 }} ถึง {{ $emergencies->lastItem() ?? 0 }} จาก
                    {{ $emergencies->total() ?? 0 }} รายการ</div>
            </div>
            <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                {{ $emergencies->links() }}
            </div>
        </div>
    </div>
@endsection
