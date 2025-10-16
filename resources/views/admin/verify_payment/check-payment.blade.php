@extends('layout.layout-admin')

@section('title', 'Dashboard')
@section('content')
    <h3 class="text-center px-2">ตรวจสอบการชำระเงิน</h3>

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
                            <option value="40">40</option>
                            <option value="80">80</option>
                            <option value="-1">ทั้งหมด</option>
                        </select>
                        <span>รายการ</span>
                    </label>
                </div>
            </div>

            {{-- ช่องสำหรับค้นหา --}}
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

        {{-- ส่วนของตาราง --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable no-footer" id="data_table"
                    aria-describedby="data_table_info">
                    {{-- กำหนดหัวตาราง --}}
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>วันที่ชำระ</th>
                            <th>ชื่อผู้จ่าย</th>
                            <th>ที่อยู่</th>
                            <th>ยอดชำระ (บาท)</th>
                            <th>สลิปชำระเงิน</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    {{-- ข้อมูลในตาราง --}}
                    <tbody class="text-center">
                        {{-- ตัวอย่างข้อมูล --}}
                        <tr>
                            <td>1</td>
                            <td>10/06/2568</td>
                            <td>ทดสอบ</td>
                            <td>123/45 ถนนทดสอบ เขตตัวอย่าง</td>
                            <td>500</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm">
                                    <i class="bi bi-file-earmark-image"></i>
                                </button>
                            </td>
                            <td>
                                <span class="text-success">ชำระแล้ว</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="bi bi-search"></i>
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>11/06/2568</td>
                            <td>ทดสอบ2</td>
                            <td>456/78 ถนนทดสอบ เขตตัวอย่าง</td>
                            <td>300</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm">
                                    <i class="bi bi-file-earmark-image"></i>
                                </button>
                            </td>
                            <td>
                                <span class="text-danger">ยังไม่ชำระ</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="bi bi-search"></i>
                                </button>
                            </td>
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
