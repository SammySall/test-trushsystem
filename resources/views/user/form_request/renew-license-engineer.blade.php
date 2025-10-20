@extends('layout.layout-request')
@section('title', 'คำขอต่อฮายุใบอนุญาตก')
@section('request-header-img', 'general')
@section('request-header', 'คำขอต่อฮายุใบอนุญาตก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร')

@section('request-content')
    <div class="list-group">
        <form action="{{ route('trash-request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">วันที่</label>
                <input type="text" name="field_date" class="form-control" value="{{ date('d/m/Y') }}" readonly>
            </div>

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
            </div>

            <div class="col-md-12 mt-3">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="personal" id="option1" value="individual">
                        <label class="form-check-label" for="option1">เป็นบุคคลธรรมดา</label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="personal" id="option2" value="corporation">
                        <label class="form-check-label" for="option2">เป็นนิติบุคคล</label>
                    </div>
                </div>
            </div>

            {{-- ✅ ถ้าเลือก "บุคคลธรรมดา" --}}
            <div id="individual-fields" class="row g-3 mt-2" style="display: none;">
                <div class="col-md-3">
                    <label class="form-label">เลขประจำตัวประชาชน<span class="text-danger">*</span></label>
                    <input type="text" name="citizen_id" class="form-control" maxlength="13" pattern="[0-9]{13}">
                </div>
            </div>

            {{-- ✅ ถ้าเลือก "นิติบุคคล" --}}
            <div id="corporation-fields" class="row g-3 mt-2" style="display: none;">
                <div class="col-md-3">
                    <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                    <input type="text" name="corp_type" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">จดทะเบียนเมื่อ<span class="text-danger">*</span></label>
                    <input type="date" name="corp_registered_at" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">มีสำนักงานตั้งอยู่เลขที่ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="corp_home_no" required>
                </div>
                <div class="col-md-3">
                    <label for="alley" class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" name="field_14" id="corp_alley">
                </div>
                <div class="col-md-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" class="form-control" name="field_15" id="corp_road" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="corp_village_no" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_9" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_10" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_11" required>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="field_3" id="tel" pattern="[0-9]{10}"
                        maxlength="10" required>
                </div>
                <div class="col-md-3">
                    <label for="fax" class="form-label">โทรสาร</label>
                    <input type="tel" class="form-control" name="field_4" id="fax" pattern="[0-9]{10}"
                        maxlength="10">
                </div>
            </div>

            <div class="row g-3 mt-3">
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
                    <input type="text" class="form-control" name="field_15" id="road" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_8" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_9" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_10" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_11" required>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="field_3" id="tel" pattern="[0-9]{10}"
                        maxlength="10" required>
                </div>
                <div class="col-md-3">
                    <label for="fax" class="form-label">โทรสาร</label>
                    <input type="tel" class="form-control" name="field_4" id="fax" pattern="[0-9]{10}"
                        maxlength="10">
                </div>
            </div>

            <div class="mb-3 mt-3">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">
                            โปรดเลือกประเภทของคำขอต่ออายุใบอนุญาตของท่าน
                            <span class="text-danger">*</span>
                        </label>
                        <select name="optione" id="optione" class="form-select" required>
                            <option value="">-- โปรดเลือกประเภทคำขอ --</option>
                            <option value="1">ก่อสร้างอาคาร</option>
                            <option value="2">ดัดแปลงอาคาร</option>
                            <option value="3">รื้อถอนอาคาร</option>
                            <option value="4">
                                เคลื่อนย้ายอาคารในท้องที่ที่อยู่ในเขตอำนาจของเจ้าพนักงานท้องถิ่นที่อาคารจะทำการเคลื่อนย้ายตั้งอยู่
                            </option>
                            <option value="5">เคลื่อนย้ายอาคารไปยังท้องที่ที่อยู่ในเขตอำนาจของเจ้าพนักงานท้องถิ่นอื่น
                            </option>
                        </select>
                    </div>

                </div>
            </div>
    </div>

    <div class="mb-3">
        <label class="form-label">ไฟล์แนบ</label>
        <input type="file" id="files" name="files[]" class="form-control"
            accept=".doc,.docx,.pdf,.xls,.xlsx,.png,.jpeg,.jpg" multiple>
        <small class="text-muted">รองรับเฉพาะ .doc, .docx, .pdf, .xls, .xlsx, .png, .jpeg สูงสุด 5 ไฟล์</small>
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
                window.location.href = "{{ url('/') }}"; // กลับหน้า homepage
            });
        </script>
    @endif

    {{-- ✅ ย้าย script toggleFields ออกมานอก if --}}
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

            // เรียกตอนเริ่มโหลดหน้า
            toggleFields();

            // เมื่อเลือก radio
            individualRadio.addEventListener("change", toggleFields);
            corpRadio.addEventListener("change", toggleFields);
        });
    </script>
@endsection
