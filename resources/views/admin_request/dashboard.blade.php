@extends('layout.layout-admin-request')
@section('title', 'Dashboard')

@section('content')
    <h3 class="text-center mb-4">Dashboard เหตุฉุกเฉิน</h3>
    <div class="row">
        @php
            $types = [
                'accident' => 'เหตูฉุกเฉิน',
                'fire' => 'เหตุไฟไหม้',
                'tree-fall' => 'เหตุต้นไม้ล้ม',
                'broken-road' => 'เหตุถนนเสีย',
                'elec-broken' => 'เหตุต้นไฟเสีย',
            ];
        @endphp

        @foreach ($types as $typeKey => $typeName)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $typeName }}</h5>
                        <p class="display-6">{{ $summary[$typeKey] ?? 0 }} เหตุ</p>
                        <a href="{{ url('/admin/emergency/' . $typeKey) }}" class="btn btn-light btn-sm">ดูรายละเอียด</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
