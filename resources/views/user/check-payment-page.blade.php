@extends('layout.layout-user')
@section('title', 'Garbage page')
@section('body-class', 'body-garbage-bg')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-5">
                <div>
                    <a href="/user/waste_payment">
                        <img src="../../img/ToxicTrash/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                    </a>
                </div>

                <div class="mb-2 d-flex justify-content-center align-items-end">
                    <img src="../../img/Payment/Banner.png" alt="banner" class="trash-toxic-img">
                </div>
            </div>

            <div class="col-md-7 bg-body-secondary payment-bg text-black">
                <!-- ข้อมูลผู้ใช้ -->
                <div class="row mb-2">
                    <div class="col-5 bg-white p-2 shadow-sm rounded-pill me-4">
                        นายเอบีซี ดีอีเอฟจี
                    </div>
                    <div class="col-2 bg-white p-2 shadow-sm rounded-pill ms-3 me-2">
                        สถานะ: ปกติ
                    </div>
                    <div class="col-4 bg-white p-2 shadow-sm rounded-pill ms-1">
                        ประเภท: ปกติ
                    </div>
                </div>

                <!-- ที่อยู่ -->
                <div class="row mb-3">
                    <div class="col bg-white p-3 shadow-sm rounded">
                        ที่อยู่: 123 หมู่ 4 ต.ท่าข้าม อ.ท่าข้าม จ.ฉะเชิงเทรา
                    </div>
                </div>

                <!-- ประวัติการชำระเงิน -->
                <div class="row mb-3">
                    <div class="col bg-white p-3 shadow-sm rounded">
                        <h5>ประวัติการชำระเงิน</h5>
                        <table class="table table-bordered table-striped mt-2">
                            <thead class="table-light">
                                <tr>
                                    <th>เดือน</th>
                                    <th>รายการ</th>
                                    <th>สถานะ</th>
                                    <th>ใบเสร็จ</th>
                                    <th>ชำระ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ม.ค. 2568</td>
                                    <td>ค่าน้ำ</td>
                                    <td>ชำระแล้ว</td>
                                    <td><a href="#">ดาวน์โหลด</a></td>
                                    <td>100 บาท</td>
                                </tr>
                                <tr>
                                    <td>ก.พ. 2568</td>
                                    <td>ค่าไฟ</td>
                                    <td>ค้างชำระ</td>
                                    <td>-</td>
                                    <td>0 บาท</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
