@extends('layout.layout-admin')
@section('title', 'Dashboard')

@section('content')
    <h3 class="text-center mb-4">Dashboard</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title text-white">บิลที่ชำระเงินแล้ว</h5>
                    <p class="display-6">1066 บิล</p>
                    <a href="/admin/verify_payment" class="btn btn-light btn-sm">ดูรายละเอียด</a>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title text-white">บิลที่ขาดการชำระเงิน</h5>
                    <p class="display-6">1031 บิล</p>
                    <a href="/admin/non_payment" class="btn btn-light btn-sm">ดูรายละเอียด</a>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <div class="card text-white bg-warning mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title text-white">รอตรวจสอบการชำระ</h5>
                    <p class="display-6">0 บิล</p>
                    <a href="/admin/verify_payment" class="btn btn-light btn-sm">ดูรายละเอียด</a>
                </div>
            </div>

        </div>
    </div>
@endsection
