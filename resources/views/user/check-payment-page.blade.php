@extends('layout.layoutuser')
@section('title', 'Garbage page')
@section('body-class', 'body-garbage-bg')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-5">
                <a href="/user/waste_payment">
                    <img src="../../img/ToxicTrash/Back-Button.png" alt="ปุ่มกลับ" class="back-garbage-btn mb-4">
                </a>
                <div class="mb-2 d-flex justify-content-center align-items-end">
                    <img src="../../img/Payment/Banner.png" alt="banner" class="trash-toxic-img">
                </div>
            </div>

            <div class="col-md-7 bg-body-secondary payment-bg">
                <div class="row">
                    <div class="col">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
