@extends('layout.layout-admin')

@section('title', 'ประวัติการชำระเงิน')
@section('content')
    <h3 class="text-center px-2">ประวัติการชำระเงิน</h3>

    {{-- ฟิลเตอร์ --}}
    <form method="GET" action="{{ route('admin.payment_history') }}">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 d-flex align-items-center">
                <div class="row mb-2">
                    <div class="col-sm-12 col-md-12 d-flex align-items-center">
                        <label class="d-flex align-items-center">
                            <select name="month_filter" class="form-select form-select-sm me-2" style="width:auto;">
                                <option value="" selected>---เลือกเดือน---</option>
                                <option value="1">มกราคม</option>
                                <option value="2">กุมภาพันธ์</option>
                                <option value="3">มีนาคม</option>
                                <option value="4">เมษายน</option>
                                <option value="5">พฤษภาคม</option>
                                <option value="6">มิถุนายน</option>
                                <option value="7">กรกฎาคม</option>
                                <option value="8">สิงหาคม</option>
                                <option value="9">กันยายน</option>
                                <option value="10">ตุลาคม</option>
                                <option value="11">พฤศจิกายน</option>
                                <option value="12">ธันวาคม</option>
                            </select>

                            <select name="year_filter" class="form-select form-select-sm" style="width:auto;">
                                <option value="" selected>---เลือกปี---</option>
                                @for ($y = 2568; $y > 2558; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </label>
                    </div>
                </div>
            </div>
            {{-- บรรทัดจำนวนรายการและช่องค้นหา --}}
            <div class="row mb-2">
                <div class="col-sm-12 col-md-6">
                    <label class="d-flex align-items-center">
                        <span class="me-1">แสดง</span>
                        <select name="data_table_length" aria-controls="data_table" class="form-select form-select-sm me-1"
                            style="width: auto;">
                            <option value="10">10</option>
                            <option value="40">40</option>
                            <option value="80">80</option>
                            <option value="-1">ทั้งหมด</option>
                        </select>
                        <span>รายการ</span>
                    </label>
                </div>

                <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                    <label class="d-flex align-items-center">
                        <span class="me-2">ค้นหา :</span>
                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="data_table"
                            style="width: auto;">
                    </label>
                </div>
            </div>

        </div>
    </form>

    {{-- ตารางข้อมูล --}}
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>วันที่ชำระ (ล่าสุด)</th>
                        <th>ที่อยู่</th>
                        <th>ยอดชำระทั้งหมด (บาท)</th>
                        <th>จำนวนรายการ</th>
                        <th>สถานะ</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($locations as $index => $location)
                        @php
                            $totalAmount = $location->bills->sum('amount');
                            $count = $location->bills->count();
                            $latestPaid = $location->bills->max('paid_date');
                            $hasMissingSlip = $location->bills->contains(function ($bill) {
                                return is_null($bill->slip_path);
                            });
                        @endphp
                        <tr>
                            <td>{{ ($locations->currentPage() - 1) * $locations->perPage() + $index + 1 }}</td>
                            <td>{{ $latestPaid ? \Carbon\Carbon::parse($latestPaid)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $location->name ?? '-' }}</td>
                            <td>{{ number_format($totalAmount, 2) }}</td>
                            <td>{{ $count }}</td>
                            <td>
                                @if ($hasMissingSlip)
                                    <span class="text-warning">มีบางรายการยังไม่แนบบิล</span>
                                @else
                                    <span class="text-success">ชำระแล้วทั้งหมด</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.payment_history.detail', $location->id) }}"
                                    class="btn btn-primary btn-sm">ดูบิล</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">ไม่มีข้อมูล</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="row mt-2">
                <div class="col-sm-12 col-md-5">
                    <div>แสดง 1 ถึง 2 จาก 2 รายการ</div>
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
    </div>
@endsection
