<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="body-bg">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="header-text">
            <img src="../img/register/1.png" alt="รูปคน">
            ลงทะเบียน
        </div>
        <div class="p-3 container">
            <form method="POST" action="{{ route('register.store') }}"
                class="row g-3 mx-3 d-flex flex-column justify-content-center align-items-center">
                @csrf
                <div class="form-bg col-md-10">

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- แถวแรก -->
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label d-block">ชื่อผู้ใช้</label>
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="login_type" id="radio_email"
                                        value="email" checked>
                                    <label class="form-check-label" for="radio_email">ใช้อีเมล</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="login_type" id="radio_phone"
                                        value="phone">
                                    <label class="form-check-label" for="radio_phone">ใช้เบอร์โทรศัพท์</label>
                                </div>
                            </div>

                            <!-- ช่องกรอกอีเมล -->
                            <small id="email_hint" class="text-danger d-none">example@example.com</small>
                            <input type="email" name="email" id="input_email" class="form-control mt-1"
                                placeholder="กรอกอีเมลของคุณ">

                            <!-- ช่องกรอกเบอร์โทร (ซ่อนเริ่มต้น) -->
                            <input type="tel" id="input_phone" class="form-control mt-2 d-none" pattern="[0-9]{10}"
                                maxlength="10" placeholder="กรอกเบอร์โทรศัพท์ 10 หลัก">
                            <small class="text-muted">เลือกวิธีเข้าสู่ระบบที่คุณต้องการใช้</small>
                        </div>
                        <div class="col-12 col-md-6"></div>
                    </div>

                    <!-- แถวสอง -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-6">
                            <label for="password" class="form-label">รหัสผ่าน (ต้องไม่ต่ำกว่า 9 ตัว)</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="confirm" class="form-label">ยืนยันรหัสผ่าน</label>
                            <input type="password" name="password_confirmation" id="confirm" class="form-control"
                                required>
                        </div>
                    </div>

                    <!-- แถวสาม -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-6">
                            <label for="salutation" class="form-label">คำนำหน้า</label>
                            <select class="form-select" id="salutation" name="salutation" required>
                                <option value="" selected disabled>เลือกคำนำหน้า</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>

                    <!-- แถวสี่ -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-6">
                            <label for="age" class="form-label">อายุ</label>
                            <input type="number" name="age" id="age" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="tel" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="tel" name="tel" id="tel" class="form-control"
                                pattern="[0-9]{10}" maxlength="10" required>
                        </div>
                    </div>

                    <!-- แถวห้า -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-12">
                            <label for="address" class="form-label">ที่อยู่</label>
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="กรอกที่อยู่" required></textarea>
                        </div>
                    </div>

                    <!-- แถวหก -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-4">
                            <label for="province" class="form-label">จังหวัด</label>
                            <input type="text" class="form-control" id="province" name="province"
                                placeholder="กรอกจังหวัด" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="district" class="form-label">อำเภอ</label>
                            <input type="text" class="form-control" id="district" name="district"
                                placeholder="กรอกอำเภอ" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="subdistrict" class="form-label">ตำบล</label>
                            <input type="text" class="form-control" id="subdistrict" name="subdistrict"
                                placeholder="กรอกตำบล" required>
                        </div>
                    </div>

                    <!-- ปุ่ม -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-12 justify-content-center align-items-center my-2x">
                            <button type="submit" class="btn w-100 p-2">
                                <img src="../img/register/Button.png" alt="button" class="img-fluid w-100">
                            </button>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            มีบัญชีแล้ว? <a href="/login" class="text-danger text-decoration-none">เข้าสู่ระบบ</a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Script เปลี่ยนช่องตาม radio -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radioEmail = document.getElementById('radio_email');
            const radioPhone = document.getElementById('radio_phone');
            const inputEmail = document.getElementById('input_email');
            const inputPhone = document.getElementById('input_phone');
            const emailHint = document.getElementById('email_hint'); // เพิ่มบรรทัดนี้

            function toggleInput() {
                if (radioEmail.checked) {
                    inputEmail.classList.remove('d-none');
                    inputEmail.setAttribute('name', 'email');
                    inputEmail.required = true;
                    emailHint.classList.remove('d-none'); // แสดงตัวอย่างเมล

                    inputPhone.classList.add('d-none');
                    inputPhone.removeAttribute('name');
                    inputPhone.required = false;
                } else {
                    inputPhone.classList.remove('d-none');
                    inputPhone.setAttribute('name', 'email');
                    inputPhone.required = true;

                    inputEmail.classList.add('d-none');
                    inputEmail.removeAttribute('name');
                    inputEmail.required = false;
                    emailHint.classList.add('d-none'); // ซ่อนตัวอย่างเมล
                }
            }

            radioEmail.addEventListener('change', toggleInput);
            radioPhone.addEventListener('change', toggleInput);
            toggleInput();
        });
    </script>

    <!-- SweetAlert2 Success -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สมัครสมาชิกสำเร็จ!',
                text: '{{ session('success') }}',
                confirmButtonText: 'เข้าสู่ระบบ',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.location.href = '/login';
            });
        </script>
    @endif
