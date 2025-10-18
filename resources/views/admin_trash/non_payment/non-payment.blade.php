@extends('layout.layout-admin-trash')

@section('title', 'บิลที่รอการชำระเงิน')
@section('content')
    <h3 class="text-center px-2">บิลที่รอการชำระเงิน</h3>

    <div id="data_table_wrapper">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12">
                <label class="d-flex align-items-center">
                    <select name="month_filter" class="form-select form-select-sm me-2" style="width:auto;">
                        <option value="" selected>---เลือกเดือน---</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}">
                                {{ \Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}</option>
                        @endfor
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
            <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                <label class="d-flex align-items-center">
                    <span class="me-2">ค้นหา :</span>
                    <input type="search" class="form-control form-control-sm" style="width:auto;">
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable no-footer" id="data_table">
                    <thead class="text-center">
                        <tr>
                            <th>ที่อยู่</th>
                            <th>เบอร์โทร</th>
                            <th>จำนวนเงิน</th>
                            <th>สถานะ</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($locations as $location)
                            @php
                                $unpaidCount = $location->bills->count();
                                $totalAmount = $location->bills->sum('amount');
                            @endphp
                            <tr>
                                <td>{{ $location->address }}</td>
                                <td>{{ $location->tel ?? '-' }}</td>
                                <td>{{ number_format($totalAmount, 2) }} บาท</td>
                                <td>
                                    @if ($unpaidCount > 0)
                                        <span class="text-danger">ยังไม่ชำระ {{ $unpaidCount }} รายการ</span>
                                    @else
                                        <span class="text-success">ชำระแล้ว</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('non_payment.detail', $location->id) }}"
                                        class="btn btn-primary btn-sm">
                                        ดูบิล
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
