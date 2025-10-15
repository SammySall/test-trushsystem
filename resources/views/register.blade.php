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
</head>

<body class="body-bg">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="header-text">
            <img src="../img/register/1.png" alt="รูปคน">
            ลงทะเบียน
        </div>
        <div class="p-3 container">
            <form class="row g-3 mx-3 d-flex flex-column justify-content-center align-items-center">
                <div class="form-bg col-md-10">
                    <!-- แถวแรก -->
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label">อีเมล</label>
                            <input type="text" name="email" id="email" class="form-control">
                        </div>
                        <div class="col-12 col-md-6"></div>
                    </div>


                    <!-- แถวสอง -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-6">
                            <label for="password" class="form-label">รหัสผ่าน (ต้องไม่ต่ำกว่า 9 ตัว)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="confirm" class="form-label">ยืนยันรหัสผ่าน</label>
                            <input type="password" name="confirm" id="confirm" class="form-control">
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
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                    </div>


                    <!-- แถวสี่ -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-6">
                            <label for="age" class="form-label">อายุ</label>
                            <input type="number" name="age" id="age" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="tel" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="tel" name="tel" id="tel" class="form-control">
                        </div>
                    </div>

                    <!-- แถวห้า -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-12">
                            <label for="address" class="form-label">ที่อยู่</label>
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="กรอกที่อยู่"></textarea>
                        </div>
                    </div>

                    <!-- แถวหก -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-4">
                            <label for="salutation" class="form-label">จังหวัด</label>
                            <select class="form-select" id="salutation" name="salutation" required>
                                <option value="" selected disabled>เลือกคำนำหน้า</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="salutation" class="form-label">ตำบล</label>
                            <select class="form-select" id="salutation" name="salutation" required>
                                <option value="" selected disabled>เลือกคำนำหน้า</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="salutation" class="form-label">อำเภอ</label>
                            <select class="form-select" id="salutation" name="salutation" required>
                                <option value="" selected disabled>เลือกคำนำหน้า</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        </div>
                    </div>

                    <!-- ปุ่ม -->
                    <div class="row mt-2">
                        <div class="col-12 col-md-12">
                            <button>
                                <img src="../img/register/Button.png" alt="button" class="img-fluid w-100">
                            </button>
                        </div>
                        <div class="d-flex justify-content-center">
                            มีบัญชีแล้วหรอ? <a href="homepage" class="text-danger text-decoration-none">เข้าสู่ระบบ</a>
                        </div>
                    </div>


                </div>
            </form>



        </div>

    </div>
</body>

</html>
