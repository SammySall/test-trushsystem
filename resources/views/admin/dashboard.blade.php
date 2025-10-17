@extends('layout.layout-admin')
@section('title', 'Dashboard Waste Payment')

@section('content')
    <h3 class="text-center mb-4">Dashboard การชำระเงินขยะ</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title text-white">บิลที่ชำระแล้ว</h5>
                    <p class="display-6">{{ number_format($paidCount) }} บิล</p>
                    <a href="{{ route('admin.payment_history') }}" class="btn btn-light btn-sm">ดูรายละเอียด</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title text-white">บิลที่ขาดการชำระเงิน</h5>
                    <p class="display-6">{{ number_format($unpaidCount) }} บิล</p>
                    <a href="{{ route('admin.non_payment') }}" class="btn btn-light btn-sm">ดูรายละเอียด</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title text-white">รอตรวจสอบการชำระ</h5>
                    <p class="display-6">{{ number_format($pendingCount) }} บิล</p>
                    <a href="{{ route('admin.verify_payment') }}" class="btn btn-light btn-sm">ดูรายละเอียด</a>
                </div>
            </div>
        </div>
    </div>
@endsection
