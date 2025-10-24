@extends('layout.layout-request')
@section('title', 'คำขอต่ออายุใบอนุญาต')
@section('request-header-img', 'health-hazard-license')
@section('request-header', 'คำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ')

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
                <input type="text" class="form-control" name="type" value="health-hazard-license" required>
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
            </div>

            <div class="row g-3 mt-3">
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
                        ขอยื่นเรื่องต่อเจ้าพนักงานท้องถิ่น เพื่อขอรับ/ ขอต่อใบอนุญาตประกอบกิจการที่เป็นอันตรายต่อสุขภาพ
                        <span class="text-danger">*</span>
                    </label>
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="addon[personal]" id="option1"
                                value="individual">
                            <label class="form-check-label" for="option1">ห้องเช่า</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="addon[personal]" id="option2"
                                value="corporation">
                            <label class="form-check-label" for="option2">โรงงาน</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Individual fields --}}
            <div id="individual-fields" class="row g-3 mt-2" style="display: none;">
                <div class="col-md-3">
                    <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                    <input type="text" name="addon[individual][type]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">จำนวนห้องเช่า(ห้อง)<span class="text-danger">*</span></label>
                    <input type="text" name="addon[individual][room_count]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">บ้านเช่า(หลัง) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="addon[individual][home_rent]">
                </div>
            </div>

            {{-- Corporation fields --}}
            <div id="corporation-fields" class="row g-3 mt-2" style="display: none;">
                <div class="col-md-3">
                    <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                    <input type="text" name="addon[corporation][type]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">จำนวนคนงาน(คน)<span class="text-danger">*</span></label>
                    <input type="text" name="addon[corporation][worker_count]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">ใช้เครื่องจักรขนาด(แรงม้า) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="addon[corporation][machine_power]">
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
                    <label class="form-check-label" for="fileCheck1">สำเนาบัตรประจำตัว</label>
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
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck4">
                    <label class="form-check-label" for="fileCheck4">หลักฐานการขออนุญาตตามกฎหมายอื่น ที่เกี่ยวเนื่อง
                        ดังนี้</label>
                    <input type="file" name="files4[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
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
                        และเงื่อนไขที่ผู้ขอออนุญาตจะต้องดำเนินการก่อนการพิจารณาออกใบอนุญาต ตามประกาศกระทรวงสาธารณสุข เรื่อง
                        กำหนดประเภทหรือขนาดของกิจการและหลักเกณฑ์ วิธีการ และเงื่อนไขที่
                        ผู้ขออนุญาตจะต้องดำเนินการก่อนการพิจารณาออกใบอนุญาต พ.ศ. 2561 </label>
                    <input type="file" name="files6[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck7">
                    <label class="form-check-label" for="fileCheck7">แบบสรุปผลการรับฟังความคิดเห็นของประชาชนที่เกี่ยวข้อง
                        ตามประกาศกระทรวงสาธารณสุข เรื่องหลักเกณฑ์ในการรับฟังความคิดเห็นของประชาชนที่เกี่ยวข้อง
                        พ.ศ.2561</label>
                    <input type="file" name="files7[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck8">
                    <label class="form-check-label" for="fileCheck8">แผนที่ตั้งสถานประกอบกิจการ</label>
                    <input type="file" name="files8[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">บันทึก</button>
            </div>
        </form>
    </div>

    {{-- SweetAlert2 --}}
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const individualRadio = document.getElementById("option1");
            const corpRadio = document.getElementById("option2");
            const individualFields = document.getElementById("individual-fields");
            const corporationFields = document.getElementById("corporation-fields");

            function toggleFields() {
                if (individualRadio.checked) {
                    individualFields.style.display = "flex";
                    corporationFields.style.display = "none";
                } else if (corpRadio.checked) {
                    individualFields.style.display = "none";
                    corporationFields.style.display = "flex";
                } else {
                    individualFields.style.display = "none";
                    corporationFields.style.display = "none";
                }
            }

            toggleFields();
            individualRadio.addEventListener("change", toggleFields);
            corpRadio.addEventListener("change", toggleFields);

            // Checkbox ไฟล์แนบ
            const checkboxes = document.querySelectorAll(".file-checkbox");
            checkboxes.forEach(cb => {
                cb.addEventListener("change", function() {
                    const fileInput = this.nextElementSibling.nextElementSibling;
                    if (this.checked) {
                        fileInput.style.display = "block";
                    } else {
                        fileInput.style.display = "none";
                        fileInput.value = "";
                    }
                });
            });
        });
    </script>
@endsection
