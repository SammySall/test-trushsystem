@extends('layout.layout-request')
@section('title', 'คำขอต่ออายุใบอนุญาต')
@section('request-header-img', 'market-establishment-license')
@section('request-header', 'คำขอรับใบอนุญาตจัดตั้งตลาด')

@section('request-content')
    <div class="list-group">
        <form action="{{ route('trash-request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- วันที่ --}}
            <div class="mb-3">
                <label class="form-label">วันที่</label>
                <input type="text" name="field_date" class="form-control" value="{{ date('d/m/Y') }}" readonly>
            </div>

            {{-- ข้อมูลทั่วไป --}}
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="prefix" class="form-label">คำนำหน้า<span class="text-danger">*</span></label>
                    <select id="prefix" name="field_1" class="form-control" required>
                        <option value="">-- โปรดเลือก --</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">ชื่อ - นามสกุล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_2" id="name" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">อายุ<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="field_5" required>
                </div>
            </div>


            {{-- ข้อมูลที่อยู่ --}}
            <div class="col-md-3 " style="display: none">
                <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="type" value="market-establishment-license" required>
            </div>
            <div class="row g-3 align-items-end mt-3">
                <div class="col-md-3">
                    <label for="name" class="form-label">เลขบัตรประชาชน<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_16" id="name" pattern="[0-9]{13}"
                        minlength="13" maxlength="13" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">บ้านเลขที่<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_7" required>
                </div>
                <div class="col-md-3">
                    <label for="alley" class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" name="field_14" id="alley">
                </div>
                <div class="col-md-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" class="form-control" name="field_15" id="road">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่</label>
                    <input type="text" class="form-control" name="field_8">
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_9" value="ท่าข้าม" readonly required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_10" value="บางปะกง" readonly required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_11" value="ฉะเชิงเทรา" readonly required>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="field_3" id="tel" pattern="[0-9]{10}"
                        maxlength="10" required>
                </div>
            </div>

            {{-- Personal / Corporation --}}
            <div class="col-md-12 mt-3">
                <div class="d-flex flex-wrap align-items-center">
                    <label class="form-label">
                        ขอยื่นคำขอรับใบอนุญาตประกอบกิจการ
                        <span class="text-danger">*</span>
                    </label>
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="addon[option]" id="option1"
                                value="individual">
                            <label class="form-check-label" for="option1">ตลาดที่มีโครงสร้างอาคาร</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="addon[option]" id="option2"
                                value="corporation">
                            <label class="form-check-label" for="option2">ตลาดที่ไม่มีโครงสร้างอาคาร</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <label class="form-label">พื้นที่ประกอบการ(ตารางเมตร)</label>
                    <input type="text" class="form-control" name="addon[area]">
                </div>
                <div class="col-md-2">
                    <label class="form-label">บ้านเลขที่</label>
                    <input type="text" class="form-control" name="addon[home_no]">
                </div>
                <div class="col-md-3">
                    <label for="alley" class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" name="addon[alley]" id="alley">
                </div>
                <div class="col-md-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" class="form-control" name="addon[road]" id="road">
                </div>
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่</label>
                    <input type="text" class="form-control" name="addon[village_no]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล</label>
                    <input type="text" class="form-control" name="addon[subdistrict]" value="ท่าข้าม" readonly
                        required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ</label>
                    <input type="text" class="form-control" name="addon[district]" value="บางปะกง" readonly required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด</label>
                    <input type="text" class="form-control" name="addon[province]" value="ฉะเชิงเทรา" readonly
                        required>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร</label>
                    <input type="tel" class="form-control" name="addon[tel]" id="tel" pattern="[0-9]{10}"
                        maxlength="10">
                </div>
            </div>

            {{-- ไฟล์แนบ (หลาย checkbox) --}}
            <div class="mb-3 mt-3">
                <label class="form-label">
                    แนบเอกสารประกอบ <br>
                    <span class="text-danger">ประเภทไฟล์: jpg,jpeg,png,pdf (ไม่เกิน 2 MB)</span>
                </label>


                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck1">
                    <label class="form-check-label"
                        for="fileCheck1">สำเนาบัตรประจำตัวประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ</label>
                    <input type="file" name="files1[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck2">
                    <label class="form-check-label" for="fileCheck2">สำเนาทะเบียนบ้าน</label>
                    <input type="file" name="files2[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck3">
                    <label class="form-check-label" for="fileCheck3">สำเนาใบอนุญาตตามกฎหมายที่เกี่ยวข้อง</label>
                    <input type="file" name="files3[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck4">
                    <label class="form-check-label" for="fileCheck4">สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล
                        พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทนนิติ
                        บุคคล (ในกรณีที่ผู้ขออนุญาตเป็นนิติบุคคล)</label>
                    <input type="file" name="files4[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck5">
                    <label class="form-check-label"
                        for="fileCheck5">หนังสือมอบอำนาจในกรณีที่เจ้าของกิจการไม่มายื่นขอรับใบอนุญาตด้วยตนเอง
                    </label>
                    <input type="file" name="files5[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck6">
                    <label class="form-check-label" for="fileCheck6">อื่น ๆ ตามที่องค์การบริหารส่วนตำบลท่าข้ามกำหนด
                    </label>
                    <input type="file" name="files6[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">บันทึก</button>
            </div>
        </form>
    </div>

    {{-- ✅ SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ!',
                text: 'ทำการร้องขอเสร็จสิ้นเรียบร้อยแล้ว',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.location.href = "{{ url('/') }}";
            });
        </script>
    @endif

    {{-- ✅ Checkbox toggle + smooth animation --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const individualRadio = document.getElementById("option1");
            const corpRadio = document.getElementById("option2");

            // ถ้ามีฟังก์ชัน toggleFields() อยู่แล้ว ก็สามารถคงไว้ตรงนี้
            function toggleFields() {}

            // === ฟังก์ชันจัดการ checkbox ไฟล์แนบ ===
            const checkboxes = document.querySelectorAll(".file-checkbox");
            checkboxes.forEach(cb => {
                cb.addEventListener("change", function() {
                    const parent = this.closest(".form-check");
                    const fileInput = parent.querySelector(".file-input");

                    if (this.checked) {
                        fileInput.style.display = "block";
                        fileInput.style.opacity = 0;
                        fileInput.style.transition = "opacity 0.3s ease";
                        requestAnimationFrame(() => fileInput.style.opacity = 1);
                    } else {
                        fileInput.style.opacity = 0;
                        fileInput.addEventListener("transitionend", function hide() {
                            fileInput.style.display = "none";
                            fileInput.value = "";
                            fileInput.removeEventListener("transitionend", hide);
                        });
                    }
                });
            });
        });
    </script>

@endsection
