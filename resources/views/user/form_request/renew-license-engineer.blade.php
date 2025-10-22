@extends('layout.layout-request')
@section('title', 'คำขอต่อฮายุใบอนุญาตก')
@section('request-header-img', 'renew-license-engineer')
@section('request-header', 'คำขอต่ออายุใบอนุญาตก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร')

@section('request-content')
    <div class="list-group">
        <form action="{{ route('trash-request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">วันที่</label>
                <input type="text" name="field_date" class="form-control" value="{{ date('d/m/Y') }}" readonly>
            </div>

            <div class="col-md-12 my-3">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="addon[personal]" id="option1"
                            value="individual">
                        <label class="form-check-label" for="option1">เป็นบุคคลธรรมดา</label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="addon[personal]" id="option2"
                            value="corporation">
                        <label class="form-check-label" for="option2">เป็นนิติบุคคล</label>
                    </div>
                </div>
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

                <div class="col-md-5">
                    <label for="name" class="form-label">ชื่อ - นามสกุล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="field_2" id="name" required>
                </div>

                {{-- ✅ ถ้าเลือก "บุคคลธรรมดา" --}}
                <div class="col-md-4" id="individual-fields" style="display: none;">
                    <div>
                        <label class="form-label">เลขประจำตัวประชาชน<span class="text-danger">*</span></label>
                        <input type="text" name="addon[individual][card_id]" class="form-control" maxlength="13"
                            pattern="[0-9]{13}">
                    </div>
                </div>

                <div class="col-md-4" id="corporation-fields1" style="display: none;">
                    <div>
                        <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                        <input type="text" name="addon[corporation][type]" required class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-md-3 " style="display: none">
                <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="type" value="market-establishment-license" required>
            </div>

            {{-- ✅ ถ้าเลือก "นิติบุคคล" --}}
            <div id="corporation-fields2" class="row g-3 mt-2" style="display: none;">
                <div class="col-md-3">
                    <label class="form-label">จดทะเบียนเมื่อ</label>
                    <input type="date" name="addon[corporation][corp_registered_at]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">สำนักงานตั้งอยู่เลขที่ </label>
                    <input type="text" class="form-control" name="addon[corporation][corp_home_no]">
                </div>
                <div class="col-md-3">
                    <label for="alley" class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" name="addon[corporation][alley]" id="corp_alley">
                </div>
                <div class="col-md-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" class="form-control" name="field_15" id="addon[corporation][road]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="addon[corporation][corp_village_no]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="addon[corporation][subdistrict]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="addon[corporation][district]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="addon[corporation][province]">
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="addon[corporation][tel]" id="tel"
                        pattern="[0-9]{10}" maxlength="10">
                </div>
                <div class="col-md-3">
                    <label for="fax" class="form-label">โทรสาร</label>
                    <input type="tel" class="form-control" name="addon[corporation][fax]" id="fax"
                        pattern="[0-9]{10}" maxlength="10">
                </div>
                <div class="col-md-5">
                    <label class="form-label">ชื่อตัวแทนนิติบุคคลผู้ขออนุญาต<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="addon[corporation][name]">
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
                    <input type="text" class="form-control" name="field_15" id="road">
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
                        <select name="addon[option]" id="option" class="form-select" required>
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
            <div class="row g-3 mt-3">
                <label class="form-label"> ข้อ ๑ อาคารที่ขอต่ออายุใบอนุญาตได้รับใบอนุญาตตาม</label>
                <div class="col-md-3">
                    <label class="form-label"> ใบอนุญาตเลขที่</label>
                    <input type="text" class="form-control" name="addon[license_no1]">
                </div>
                <div class="col-md-3">
                    <label class="form-label"> ลงวันที่</label>
                    <input type="date" name="addon[at1]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label"> บ้านเลขที่</label>
                    <input type="text" class="form-control" name="addon[home_no1]">
                </div>
                <div class="col-md-3">
                    <label for="alley" class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" name="addon[alley1]" id="alley">
                </div>
                <div class="col-md-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" class="form-control" name="addon[road1]" id="road">
                </div>
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่</label>
                    <input type="text" class="form-control" name="addon[village_no1]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล</label>
                    <input type="text" class="form-control" name="addon[subdistrict1]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ</label>
                    <input type="text" class="form-control" name="addon[district1]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด</label>
                    <input type="text" class="form-control" name="addon[province1]">
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">ชื่อเจ้าของอาคาร</label>
                    <input type="text" class="form-control" name="addon[name1]" id="tel">
                </div>
                <div class="col-md-3">
                    <label for="option3" class="form-label">ในที่ดิน</label>
                    <select name="addon[option3]" id="option3" class="form-select">
                        <option value="">-- โปรดเลือก --</option>
                        <option value="1">โฉนดที่ดิน</option>
                        <option value="2">น.ส. ๓</option>
                        <option value="3">น.ส. ๓ ก</option>
                        <option value="4">ส.ค.๑</option>
                        <option value="5">อื่น ๆ</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เลขที่</label>
                    <input type="text" class="form-control" name="addon[no1]" id="tel">
                </div>
                <div class="col-md-6">
                    <label class="form-label"> เป็นที่ดินของ</label>
                    <input type="text" name="addon[name2]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label"> วันสิ้นสุดใบอนุญาต</label>
                    <input type="date" name="addon[endat]" class="form-control">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <label class="form-label">ข้อ ๒ รูปแบบอาคาร</label>
                <div class="col-md-3">
                    <label class="form-label"> ชนิด</label>
                    <input type="text" class="form-control" name="addon[type2]">
                </div>
                <div class="col-md-3">
                    <label class="form-label"> จำนวน</label>
                    <input type="text" class="form-control" name="addon[num]">
                </div>
                <div class="col-md-3">
                    <label class="form-label"> เพือใช้เป็น</label>
                    <input type="text" name="addon[use]" class="form-control">
                </div>
                <label class="form-label"> โดยมีที่จอดรถ ที่กลับรถ และทางเข้าออกของรถ </label>
                <div class="col-md-3">
                    <label class="form-label"> จำนวน (คัน) </label>
                    <input type="text" class="form-control" name="addon[num1]">
                </div>
            </div>
            <div class="row g-3 mt-3">
                <label class="form-label">ข้อ ๓ เหตุที่ทำการไม่เสร็จตามที่ได้รับอนุญาต</label>
                <div class="col-md-6">
                    <label class="form-label"> เนื่องจาก</label>
                    <textarea class="form-control" rows="3" name="addon[with]"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label"> ขณะนี้ได้ดำเนินการไปแล้วถึง</label>
                    <textarea rows="3" class="form-control" name="addon[to]"></textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label"> จึงขอต่ออายุอีก (วัน)</label>
                    <input type="text" name="addon[ExtraTime]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label"> ชื่อผู้ควบคุม </label>
                    <input type="text" class="form-control" name="addon[nameCon]">
                </div>
                <div class="col-md-4">
                    <label class="form-label"> เลขบัตรประชาชนผู้ควบคุม </label>
                    <input type="text" class="form-control" name="addon[cardIdCon]">
                </div>
            </div>

            {{-- ไฟล์แนบ (หลาย checkbox) --}}
            <div class="mb-3 mt-3">
                <label class="form-label">
                    ข้อ ๔ แนบเอกสารประกอบ <br>
                    <span class="text-danger">ประเภทไฟล์: jpg,jpeg,png,pdf (ไม่เกิน 2 MB)</span>
                </label>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck1">
                    <label class="form-check-label" for="fileCheck1">สำเนาเอกสารแสดงการเป็นเจ้าของอาคาร</label>
                    <input type="file" name="files1[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck2">
                    <label class="form-check-label" for="fileCheck2">หนังสือแสดงความเป็นตัวแทนของเจ้าของอาคาร
                        (กรณีที่ตัวแทนเจ้าของอาคารเป็นผู้ขออนุญาต)</label>
                    <input type="file" name="files2[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck3">
                    <label class="form-check-label" for="fileCheck3"> สำเนาเอกสารแสดงการเป็นผู้ครอบครองอาคาร</label>
                    <input type="file" name="files3[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck4">
                    <label class="form-check-label" for="fileCheck4">
                        หนังสือแสดงว่าเป็นผู้จัดการหรือผู้แทนซึ่งเป็นผู้ดำเนินกิจการของนิติบุคคล <br>
                        (กรณีที่นิติบุคคลเป็นผู้ขออนุญาต)</label>
                    <input type="file" name="files4[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck5">
                    <label class="form-check-label" for="fileCheck5"> ใบอนุญาตตามข้อ ๑
                    </label>
                    <input type="file" name="files5[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck6">
                    <label class="form-check-label" for="fileCheck6"> หนังสือแสดงความยินยอมของผู้ควบคุมงาน </label>

                    <div class="file-section" style="display:none;">
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label my-2">ชื่อผู้ควบคุมงาน</label>
                                <input type="text" name="addon[supervisor][name]" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label my-2">เลขประจำตัวประชาชน</label>
                                <input type="text" name="addon[supervisor][card_id]" class="form-control"
                                    maxlength="13" pattern="[0-9]{13}">
                            </div>
                        </div>

                        <div class="col-md-12 my-2">
                            <label class="form-label mb-2">
                                สำเนาใบอนุญาตเป็นผู้ประกอบวิชาชีพสถาปัตยกรรมควบคุม หรือวิชาวิศวกรรมควบคุม
                            </label>
                            <input type="file" name="files6[]" class="form-control file-input" multiple
                                accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                    </div>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck7">
                    <label class="form-check-label" for="fileCheck7">
                        หนังสือรับรองการได้รับอนุญาตให้เป็นผู้ประกอบวิชาชีพสถาปัตยกรรมควบคุม
                        หรือผู้ประกอบวิชาชีพวิศวกรรมควบคุม ที่ออกโดยสภาสถาปนิกหรือสภาวิศวกร</label>
                    <input type="file" name="files7[]" class="form-control file-input" multiple
                        accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input file-checkbox" type="checkbox" id="fileCheck8">
                    <label class="form-check-label" for="fileCheck8">เอกสารอื่น ๆ </label>
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
            const corporationFields1 = document.getElementById("corporation-fields1");
            const corporationFields2 = document.getElementById("corporation-fields2");

            function toggleFields() {
                if (individualRadio.checked) {
                    individualFields.style.display = "flex";
                    corporationFields1.style.display = "none";
                    corporationFields2.style.display = "none";
                } else if (corpRadio.checked) {
                    individualFields.style.display = "none";
                    corporationFields1.style.display = "flex";
                    corporationFields2.style.display = "flex";
                } else {
                    individualFields.style.display = "none";
                    corporationFields1.style.display = "none";
                    corporationFields2.style.display = "none";
                }
            }

            // เรียกตอนเริ่มโหลดหน้า
            toggleFields();

            // เมื่อเลือก radio
            individualRadio.addEventListener("change", toggleFields);
            corpRadio.addEventListener("change", toggleFields);
        });

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
    </script>
@endsection
