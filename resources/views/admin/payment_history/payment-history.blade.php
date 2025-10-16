@extends('layout.layout-admin')

@section('title', 'Dashboard')
@section('content')
    <h3 class="text-center px-2">ประวัติการชำระเงิน</h3>

    {{-- ฟิลเตอร์ --}}
    <div id="data_table_wrapper">
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12">
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

        {{-- ตารางข้อมูล --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable no-footer" id="data_table"
                    aria-describedby="data_table_info">
                    <thead class="text-center">
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
                    <tbody class="text-center">
                        {{-- ตัวอย่างข้อมูล --}}
                        <tr>
                            <td>1</td>
                            <td>10/06/2568</td>
                            <td>123/45</td>
                            <td>500</td>
                            <td>2</td>
                            <td><span class="text-success">ชำระแล้วทั้งหมด</span></td>
                            <td><a href="/admin/payment_history/detail" class="btn btn-primary btn-sm">ดูบิล</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>11/06/2568</td>
                            <td>456/78</td>
                            <td>300</td>
                            <td>1</td>
                            <td><span class="text-warning">มีบางรายการยังไม่แนบบิล</span></td>
                            <td><a href="/admin/payment_history/detail" class="btn btn-primary btn-sm">ดูบิล</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ส่วนท้ายของตาราง --}}
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
@endsection
