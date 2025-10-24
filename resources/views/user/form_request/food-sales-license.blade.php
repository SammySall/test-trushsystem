@extends('layout.layout-request')
@section('title', 'ใบอนุญาตสถานที่จำหน่ายอาหาร')
@section('request-header-img', 'food-sales-license')
@section('request-header', 'ใบอนุญาตสถานที่จำหน่ายอาหาร')

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
                <input type="text" class="form-control" name="type" value="food-sales-license" required>
            </div>

            <div class="row g-3 align-items-end mt-3">
                <div class="col-md-3">
                    <label class="form-label">สัญชาติ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_6" required>
                </div>
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
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่</label>
                    <input type="text" class="form-control" name="field_8">
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_9" value="" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_10" value="" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_11" value="" required>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="field_3" id="tel" pattern="[0-9]{10}"
                        maxlength="10" required>
                </div>
            </div>

            <div class="row g-3 align-items-end mt-3">
                <label class="form-label">
                    สถานที่จัดงาน
                </label>
                <div class="col-md-3">
                    <label for="tel" class="form-label"> ประจำปีพ.ศ</label>
                    <input type="number" class="form-control" name="addon[year]" placeholder="YYYY">
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label"> ใช้ชื่อสถานที่ว่า</label>
                    <input type="text" class="form-control" name="addon[name]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">บ้านเลขที่</label>
                    <input type="text" class="form-control" name="addon[house_no]">
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
                        >
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ</label>
                    <input type="text" class="form-control" name="addon[district]" value="บางปะกง" readonly >
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด</label>
                    <input type="text" class="form-control" name="addon[province]" value="ฉะเชิงเทรา" readonly>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร</label>
                    <input type="tel" class="form-control" name="addon[tel]" id="tel" pattern="[0-9]{10}"
                        maxlength="10">
                </div>
            </div>

            {{-- Personal / Corporation --}}
            <div class="row g-3 mt-3">
                {{-- <div class="d-flex flex-wrap align-items-center"> --}}
                <label class="form-label">
                    ขอยื่นคำขอรับใบอนุญาตประกอบกิจการตามเทศบัญญัติ สถานที่จำหน่ายอาหารหรือสะสมอาหาร พ.ศ. 2543
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-8">
                    <label class="form-label">
                        ประเภทใบอนุญาตหรือหนังสือรับรอง
                        <span class="text-danger">*</span>
                    </label>
                    <select name="addon[option]" id="option" class="form-select">
                        <option value="">-- โปรดเลือกประเภท --</option>
                        <option value="1">ใบอนุญาตจัดตั้งสถานที่จำหน่ายอาหาร (สอ.4)</option>
                        <option value="2">ใบอนุญาตจัดตั้งสถานที่สะสมอาหาร (สอ.5)</option>
                        <option value="3">หนังสือรับรองการแจ้งตั้งสถานที่จำหน่ายอาหาร (สอ.6)</option>
                        <option value="4">หนังสือรับรองการแจ้งตั้งสถานที่สะสมอาหาร (สอ.7)</option>
                        </option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">พื้นที่ประกอบการ(ตารางเมตร)</label>
                    <input type="text" class="form-control" name="addon[area]">
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
                    <label class="form-check-label" for="fileCheck3">ใบรับรองแพทย์ ไม่เกิน 6 เดือน</label>
                    <input type="file" name="files3[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <!-- เปลี่ยน class เป็น "toggle-subfiles" -->
                    <input class="form-check-input toggle-subfiles" type="checkbox" id="fileCheck4_main">
                    <label class="form-check-label" for="fileCheck4_main">
                        หลักฐานการขออนุญาตตามกฎหมายอื่น ที่เกี่ยวเนื่อง
                    </label>

                    <div class="subfiles" style="display:none; margin-left: 30px; margin-top: 10px;">
                        <div class="form-check mb-2">
                            <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck4_1">
                            <label class="form-check-label" for="fileCheck4_1">
                                สำเนาใบอนุญาตประกอบกิจการโรงงานอุตสาหกรรม (รง.4)
                            </label>
                            <input type="file" name="files4_1[]" class="form-control file-input" multiple
                                accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck4_2">
                            <label class="form-check-label" for="fileCheck4_2">
                                สำเนาหนังสือรับรองการจดทะเบียนของบริษัทจำกัด หรือห้างหุ้นส่วน
                            </label>
                            <input type="file" name="files4_2[]" class="form-control file-input" multiple
                                accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck4_3">
                            <label class="form-check-label" for="fileCheck4_3">
                                หนังสือมอบอำนาจพร้อมติดอากรแสตมป์ 10 บาท (กรณีผู้มีอำนาจลงนามไม่ได้ลงนามเอง)
                            </label>
                            <input type="file" name="files4_3[]" class="form-control file-input" multiple
                                accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck4_4">
                            <label class="form-check-label" for="fileCheck4_4">
                                สำเนาบัตรประชาชน และสำเนาทะเบียนบ้านของผู้มีอำนาจลงนาม / ผู้ได้รับมอบอำนาจ
                            </label>
                            <input type="file" name="files4_4[]" class="form-control file-input" multiple
                                accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-check mb-2">
                <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck5">
                <label class="form-check-label" for="fileCheck5">ใบอนุญาตฉบับเก่าที่กำลังจะหมดอายุ หรือที่หมดอายุแล้ว
                </label>
                <input type="file" name="files5[]" class="form-control file-input" multiple
                    accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck6">
                <label class="form-check-label" for="fileCheck6">แบบรายการตรวจสอบตามหลักเกณฑ์
                    และเงื่อนไขที่ผู้ข0ออนุญาตจะต้องดำเนินการก่อนการพิจารณาออกใบอนุญาต ตามประกาศกระทรวงสาธารณสุข เรื่อง
                    กำหนดประเภทหรือขนาดของกิจการและหลักเกณฑ์ วิธีการ และเงื่อนไขที่
                    ผู้ขออนุญาตจะต้องดำเนินการก่อนการพิจารณาออกใบอนุญาต พ.ศ. 2561
                </label>
                <input type="file" name="files6[]" class="form-control file-input" multiple
                    accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck7">
                <label class="form-check-label" for="fileCheck7">แบบสรุปผลการรับฟังความคิดเห็นของประชาชนที่เกี่ยวข้อง
                    ตามประกาศกระทรวงสาธารณสุข เรื่องหลักเกณฑ์ในการรับฟังความคิดเห็นของประชาชนที่เกี่ยวข้อง พ.ศ.2561
                </label>
                <input type="file" name="files7[]" class="form-control file-input" multiple
                    accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck8">
                <label class="form-check-label" for="fileCheck8">แผนที่ตั้งสถานประกอบกิจการ
                </label>
                <input type="file" name="files8[]" class="form-control file-input" multiple
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- จัดการ toggle ช่องแนบไฟล์ (.file-checkbox) ---
            const checkboxes = document.querySelectorAll(".file-checkbox");
            checkboxes.forEach(cb => {
                cb.addEventListener("change", function() {
                    const parent = this.closest(".form-check");
                    const fileInput = parent.querySelector(".file-input");
                    if (fileInput) {
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
                    }
                });
            });

            // --- toggle div ย่อยของ "หลักฐานการขออนุญาตตามกฎหมายอื่นฯ" ---
            const mainToggle = document.querySelector(".toggle-subfiles");
            const subSection = document.querySelector(".subfiles");

            if (mainToggle && subSection) {
                mainToggle.addEventListener("change", function() {
                    if (this.checked) {
                        subSection.style.display = "block";
                        subSection.style.opacity = 0;
                        subSection.style.transition = "opacity 0.3s ease";
                        requestAnimationFrame(() => subSection.style.opacity = 1);
                    } else {
                        subSection.style.opacity = 0;
                        subSection.addEventListener("transitionend", function hide() {
                            subSection.style.display = "none";
                            subSection.removeEventListener("transitionend", hide);
                            // reset ย่อยทั้งหมด
                            subSection.querySelectorAll("input[type='checkbox']").forEach(cb => cb
                                .checked = false);
                            subSection.querySelectorAll("input[type='file']").forEach(f => {
                                f.value = "";
                                f.style.display = "none";
                            });
                        });
                    }
                });
            }
        });
    </script>

@endsection
