@extends('layout.layout-admin-emergency')
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
                'elec-broken' => 'เหตุไฟเสีย',
            ];
        @endphp

        @foreach ($types as $typeKey => $typeName)
            @php
                $cardClass = in_array($typeKey, ['accident', 'elec-broken']) ? 'card-emer-red' : 'card-emer-green';
                $url = url('/admin/emergency/' . $typeKey);
                // ใช้รูปตามลำดับ เช่น 1.png, 2.png, 3.png ...
                $iconPath = url('../img/admin-emergency/' . ($loop->index + 1) . '.png');
            @endphp

            <div class="col-md-4 mb-3">
                <a href="{{ $url }}" class="text-decoration-none text-white">
                    <div class="{{ $cardClass }} text-white shadow-sm card-hover rounded-3">
                        <div class="p-4 text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                <img src="{{ $iconPath }}" alt="Icon" class="img-fluid logo-img" >
                                <h5 class="fw-bold mb-0">{{ $typeName }}</h5>
                            </div>
                            <p class="display-6 mb-0">{{ $summary[$typeKey] ?? 0 }} เหตุ</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
