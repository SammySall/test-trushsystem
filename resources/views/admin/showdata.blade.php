@extends('layout.layout-admin')
@section('title','Dashboard')
@section('content')
    <h3 class="text-center px-2">แบบคำขอรับการประเมินค่าธรรมเนียมการกำจัดสิ่งปฏิกูลและมูลฝอย และ
        แบบขอรับถังขยะมูลฝอยทั่วไป</h3>
    <h4 class="text-center px-2">ตารางแสดงข้อมูลฟอร์มที่ส่งเข้ามา</h4>
    {{-- ฟิวเตอร์ --}}
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
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="data_table" rowspan="1"
                                colspan="1" aria-sort="ascending"
                                aria-label="วันที่ส่ง: activate to sort column descending" style="width: 165.547px;">
                                วันที่ส่ง</th>
                            <th class="sorting" tabindex="0" aria-controls="data_table" rowspan="1" colspan="1"
                                aria-label="ชื่อผู้ส่งฟอร์ม: activate to sort column ascending" style="width: 172.375px;">
                                ชื่อผู้ส่งฟอร์ม</th>
                            <th class="sorting" tabindex="0" aria-controls="data_table" rowspan="1" colspan="1"
                                aria-label="ผู้กดรับฟอร์ม: activate to sort column ascending" style="width: 172.562px;">
                                ผู้กดรับฟอร์ม</th>
                            <th class="sorting" tabindex="0" aria-controls="data_table" rowspan="1" colspan="1"
                                aria-label="สถานะ: activate to sort column ascending" style="width: 105.109px;">สถานะ</th>
                            <th class="sorting" tabindex="0" aria-controls="data_table" rowspan="1" colspan="1"
                                aria-label="จัดการ: activate to sort column ascending" style="width: 154.406px;">จัดการ</th>
                        </tr>
                    </thead>
                    {{-- ข้อมูลในตาราง --}}
                    <tbody class="text-center">


                        <tr class="odd">
                            <td class="date-column sorting_1">10/06/2568</td>
                            <td>ทดสอบ</td>
                            <td></td>
                            <td>
                                <span style="font-size: 20px; color:blue;"><i class="bi bi-check-circle"></i></span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-filetype-pdf"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="bi bi-reply"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="even">
                            <td class="date-column sorting_1">10/06/2568</td>
                            <td>ทดสอบ</td>
                            <td></td>
                            <td>
                                <span style="font-size: 20px; color:blue;"><i class="bi bi-check-circle"></i></span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-filetype-pdf"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="bi bi-reply"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- ส่วนท้ายของตาราง --}}
        <div class="row ">
            <div class="col-sm-12 col-md-5">
                <div>แสดง 1
                    ถึง 2 จาก 2 รายการ</div>
            </div>
            <div class="col-sm-12 col-md-7 d-flex justify-content-end">
                <div>
                    <ul class="pagination">
                        <li class="paginate_button page-item previous disabled">
                            <a aria-controls="data_table" aria-disabled="true" role="link" data-dt-idx="previous"
                                tabindex="-1" class="page-link">
                                ก่อนหน้า
                            </a>
                        </li>
                        <li class="paginate_button page-item active"><a href="#" aria-controls="data_table"
                                role="link" aria-current="page" data-dt-idx="0" tabindex="0" class="page-link">
                                1
                            </a>
                        </li>
                        <li class="paginate_button page-item next disabled" id="data_table_next"><a
                                aria-controls="data_table" aria-disabled="true" role="link" data-dt-idx="next"
                                tabindex="-1" class="page-link">
                                ถัดไป
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
