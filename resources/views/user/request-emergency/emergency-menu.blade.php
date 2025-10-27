@extends('layout.layout-user')
@section('title', 'Trash Page')
@section('body-class', 'body-garbage-bg')
@section('content')
    <div class="container">
        <div class="row">
            <a href="/homepage" class="mt-4">
                <img src="../img/Emergency-menu/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn">
            </a>
            <div class="row g-3 text-center">
                <div class="col-6 col-md-4">
                    <a href="/user/emergency/accident">
                        <img src="../img/Emergency-menu/1.png" alt="แจ้งเหตุฉุกเฉิน" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="/user/emergency/fire">
                        <img src="../img/Emergency-menu/2.png" alt="แจ้งไฟไหม้" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="/user/emergency/tree-fall">
                        <img src="../img/Emergency-menu/3.png" alt="แจ้งต้นไม้ล้ม" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-2">

                </div>
                <div class="col-6 col-md-4">
                    <a href="/user/emergency/elec-broken">
                        <img src="../img/Emergency-menu/5.png" alt="ไฟเสีย" class="img-fluid link-garbage-btn">
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="/user/emergency/broken-road">
                        <img src="../img/Emergency-menu/4.png" alt="ถนนเสีย" class="img-fluid link-garbage-btn">
                    </a>
                </div>

            </div>
        </div>
    </div>

@endsection
