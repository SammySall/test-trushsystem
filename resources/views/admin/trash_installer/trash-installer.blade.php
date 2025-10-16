@extends('layout.layout-admin')

@section('title', 'Dashboard')
@section('content')
    <h3 class="text-center px-2">ผู้ใช้บริการติดตั้งถังขยะ</h3>

    {{-- ฟิลเตอร์ --}}
    <div id="data_table_wrapper" class="mb-3">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-6">
                <label class="d-flex align-items-center">
                    <span class="me-1">แสดง</span>
                    <select name="data_table_length" class="form-select form-select-sm me-1" style="width:auto;">
                        <option value="10">10</option>
                        <option value="40">40</option>
                        <option value="80">80</option>
                        <option value="-1">ทั้งหมด</option>
                    </select>
                    <span>รายการ</span>
                </label>
            </div>
            <div class="col-sm-12 col-md-6">
                <label class="d-flex align-items-center justify-content-end">
                    <span class="me-2">ค้นหา :</span>
                    <input type="search" class="form-control form-control-sm" style="width:auto;">
                </label>
            </div>
        </div>

        {{-- ตารางข้อมูล --}}
        <table class="table table-bordered dataTable">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">ชื่อ</th>
                    <th class="text-center">ที่อยู่</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-center">ค้างชำระ</th>
                    <th class="text-center">รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($locations as $index => $location)
                    @php
                        $unpaidCount = $location->bills->where('status', 'ยังไม่ชำระ')->count();
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $location->name }}</td>
                        <td>{{ $location->address }}</td>
                        <td class="text-center text-success fw-bold">เสร็จสิ้น</td>
                        <td class="text-center fw-bold">{{ $unpaidCount }} บิล</td>
                        <td class="text-center">
                            <a href="/admin/trash_installer/detail/{{ $location->id }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-search"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">ไม่พบข้อมูลที่เสร็จสิ้น</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ส่วนท้ายของตาราง --}}
        <div class="row mt-2">
            <div class="col-sm-12 col-md-5">
                <div>แสดง 1 ถึง {{ $locations->count() }} จาก {{ $locations->count() }} รายการ</div>
            </div>
            <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                <ul class="pagination">
                    <li class="paginate_button page-item previous disabled">
                        <a class="page-link" href="#" aria-disabled="true">ก่อนหน้า</a>
                    </li>
                    <li class="paginate_button page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="paginate_button page-item next disabled">
                        <a class="page-link" href="#" aria-disabled="true">ถัดไป</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
