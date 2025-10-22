@extends('layout.layout-request')
@section('title', 'ใบอนุญาตสถานที่จำหน่ายอาหาร')

@section('request-content')
    <h4 class="header-form-name my-2 mx-4">
        รายละเอียดคำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ
    </h4>

    <div class="list-group text-start">

        {{-- วันที่ --}}
        <div class="mb-3">
            <label class="form-label">วันที่</label>
            <input type="text" class="form-control" value="{{ $trashRequest->created_at->format('d/m/Y') ?? '-' }}"
                readonly>
        </div>

        {{-- ข้อมูลทั่วไป --}}
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">คำนำหน้า</label>
                <input type="text" class="form-control" value="{{ $trashRequest->prefix ?? '-' }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">ชื่อ - นามสกุล</label>
                <input type="text" class="form-control" value="{{ $trashRequest->fullname ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">อายุ</label>
                <input type="number" class="form-control" value="{{ $trashRequest->age ?? '-' }}" readonly>
            </div>
        </div>

        {{-- ที่อยู่ --}}
        <div class="row g-3 align-items-end mt-3">
            <div class="col-md-3">
                <label class="form-label">สัญชาติ</label>
                <input type="text" class="form-control" value="{{ $trashRequest->nationality ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เลขบัตรประชาชน</label>
                <input type="text" class="form-control" value="{{ $trashRequest->id_card ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">บ้านเลขที่</label>
                <input type="text" class="form-control" value="{{ $trashRequest->house_no ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">ตรอก/ซอย</label>
                <input type="text" class="form-control" value="{{ $trashRequest->alley ?? '-' }}" readonly>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-3">
                <label class="form-label">ถนน</label>
                <input type="text" class="form-control" value="{{ $trashRequest->road ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">หมู่ที่</label>
                <input type="text" class="form-control" value="{{ $trashRequest->village_no ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">แขวง/ตำบล</label>
                <input type="text" class="form-control" value="{{ $trashRequest->subdistrict ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เขต/อำเภอ</label>
                <input type="text" class="form-control" value="{{ $trashRequest->district ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">จังหวัด</label>
                <input type="text" class="form-control" value="{{ $trashRequest->province ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เบอร์โทร</label>
                <input type="text" class="form-control" value="{{ $trashRequest->tel ?? '-' }}" readonly>
            </div>
        </div>

        <div class="row g-3 align-items-end mt-3">
            <label class="form-label">
                สถานที่จัดงาน
            </label>
            <div class="col-md-3">
                <label for="tel" class="form-label"> ประจำปีพ.ศ</label>
                <input type="tel" class="form-control" value="{{ $addon['year'] ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="tel" class="form-label"> ใช้ชื่อสถานที่ว่า</label>
                <input type="tel" class="form-control" value="{{ $addon['name'] ?? '-' }}" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">บ้านเลขที่</label>
                <input type="text" class="form-control" value="{{ $addon['home_no'] ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="alley" class="form-label">ตรอก/ซอย</label>
                <input type="text" class="form-control" value="{{ $addon['alley'] ?? '-' }}" id="alley" readonly>
            </div>
            <div class="col-md-3">
                <label for="road" class="form-label">ถนน</label>
                <input type="text" class="form-control" value="{{ $addon['road'] ?? '-' }}" id="road" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">หมู่ที่</label>
                <input type="text" class="form-control" value="{{ $addon['subdistrict'] ?? '-' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">แขวง/ตำบล</label>
                <input type="text" class="form-control" value="{{ $addon['district']['type'] ?? '-' }}"
                    value="ท่าข้าม" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">เขต/อำเภอ</label>
                <input type="text" class="form-control" value="{{ $addon['individual'] ?? '-' }}" value="บางปะกง"
                    readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">จังหวัด</label>
                <input type="text" class="form-control" value="{{ $addon['province'] ?? '-' }}" value="ฉะเชิงเทรา"
                    readonly>
            </div>
            <div class="col-md-3">
                <label for="tel" class="form-label">เบอร์โทร</label>
                <input type="tel" class="form-control" value="{{ $addon['tel'] ?? '-' }}" readonly>
            </div>
        </div>

        {{-- Personal / Corporation --}}
        <div class="row g-3 mt-3">
            {{-- <div class="d-flex flex-wrap align-items-center"> --}}
            <label class="form-label">
                ขอยื่นคำขอรับใบอนุญาตประกอบกิจการตามเทศบัญญัติ สถานที่จำหน่ายอาหารหรือสะสมอาหาร พ.ศ. 2543
            </label>
            <div class="col-md-8">
                <label class="form-label">
                    ประเภทใบอนุญาตหรือหนังสือรับรอง
                </label>
                <select name="option" id="option" class="form-select" readonly>
                    <option {{ ($addon['option'] ?? '') == '1' ? 'checked' : '' }}>ใบอนุญาตจัดตั้งสถานที่จำหน่ายอาหาร
                        (สอ.4)</option>
                    <option {{ ($addon['option'] ?? '') == '2' ? 'checked' : '' }}>ใบอนุญาตจัดตั้งสถานที่สะสมอาหาร (สอ.5)
                    </option>
                    <option {{ ($addon['option'] ?? '') == '3' ? 'checked' : '' }}>
                        หนังสือรับรองการแจ้งตั้งสถานที่จำหน่ายอาหาร (สอ.6)</option>
                    <option {{ ($addon['option'] ?? '') == '4' ? 'checked' : '' }}>หนังสือรับรองการแจ้งตั้งสถานที่สะสมอาหาร
                        (สอ.7)</option>
                    </option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">พื้นที่ประกอบการ(ตารางเมตร)</label>
                <input type="text" class="form-control" value="{{ $addon['area'] ?? '-' }}" readonly>
            </div>
        </div>

        {{-- ไฟล์แนบ (หลาย checkbox) --}}
        <div class="mb-3 mt-3">
            <label class="form-label">
                แนบเอกสารประกอบ <br>
                <span class="text-danger">ประเภทไฟล์: jpg,jpeg,png,pdf (ไม่เกิน 2 MB)</span>
            </label>

            @php
                // ดึงไฟล์แต่ละ field ออกมา
                $file1 = $trashRequest->files->where('field_name', 'files1')->first();
                $file2 = $trashRequest->files->where('field_name', 'files2')->first();
                $file3 = $trashRequest->files->where('field_name', 'files3')->first();
                $file4 = $trashRequest->files->where('field_name', 'files4')->first();
                $file5 = $trashRequest->files->where('field_name', 'files5')->first();
                $file6 = $trashRequest->files->where('field_name', 'files6')->first();
                $file7 = $trashRequest->files->where('field_name', 'files7')->first();
                $file8 = $trashRequest->files->where('field_name', 'files8')->first();
                $file4_1 = $trashRequest->files->where('field_name', 'files4_1')->first();
                $file4_2 = $trashRequest->files->where('field_name', 'files4_2')->first();
                $file4_3 = $trashRequest->files->where('field_name', 'files4_3')->first();
                $file4_4 = $trashRequest->files->where('field_name', 'files4_4')->first();
            @endphp

            <div class="form-check mb-2">
                <label class="form-check-label"
                    for="fileCheck1">สำเนาบัตรประจำตัวประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ</label>
                @if ($file1)
                    <a href="{{ asset('storage/' . $file1->file_path) }}" target="_blank">{{ $file1->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck2">สำเนาทะเบียนบ้าน</label>
                @if ($file2)
                    <a href="{{ asset('storage/' . $file2->file_path) }}" target="_blank">{{ $file2->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck3">ใบรับรองแพทย์ ไม่เกิน 6 เดือน</label>
                @if ($file3)
                    <a href="{{ asset('storage/' . $file3->file_path) }}" target="_blank">{{ $file3->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck4_main">
                    หลักฐานการขออนุญาตตามกฎหมายอื่น ที่เกี่ยวเนื่อง
                </label>

                <div class="subfiles" style="margin-left: 20px; margin-top: 10px;">
                    <div class="form-check mb-2">
                        <label class="form-check-label">สำเนาใบอนุญาตประกอบกิจการโรงงานอุตสาหกรรม (รง.4)</label>
                        @if ($file4_1)
                            <a href="{{ asset('storage/' . $file4_1->file_path) }}"
                                target="_blank">{{ $file4_1->file_name }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div class="form-check mb-2">
                        <label class="form-check-label">สำเนาหนังสือรับรองการจดทะเบียนของบริษัทจำกัด
                            หรือห้างหุ้นส่วน</label>
                        @if ($file4_2)
                            <a href="{{ asset('storage/' . $file4_2->file_path) }}"
                                target="_blank">{{ $file4_2->file_name }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div class="form-check mb-2">
                        <label class="form-check-label">หนังสือมอบอำนาจพร้อมติดอากรแสตมป์ 10 บาท
                            (กรณีผู้มีอำนาจลงนามไม่ได้ลงนามเอง)</label>
                        @if ($file4_3)
                            <a href="{{ asset('storage/' . $file4_3->file_path) }}"
                                target="_blank">{{ $file4_3->file_name }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div class="form-check mb-2">
                        <label class="form-check-label">สำเนาบัตรประชาชน และสำเนาทะเบียนบ้านของผู้มีอำนาจลงนาม /
                            ผู้ได้รับมอบอำนาจ</label>
                        @if ($file4_4)
                            <a href="{{ asset('storage/' . $file4_4->file_path) }}"
                                target="_blank">{{ $file4_4->file_name }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck5">ใบอนุญาตฉบับเก่าที่กำลังจะหมดอายุ หรือที่หมดอายุแล้ว
                </label>
                @if ($file5)
                    <a href="{{ asset('storage/' . $file5->file_path) }}" target="_blank">{{ $file5->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck6">แบบรายการตรวจสอบตามหลักเกณฑ์
                    และเงื่อนไขที่ผู้ข0ออนุญาตจะต้องดำเนินการก่อนการพิจารณาออกใบอนุญาต ตามประกาศกระทรวงสาธารณสุข เรื่อง
                    กำหนดประเภทหรือขนาดของกิจการและหลักเกณฑ์ วิธีการ และเงื่อนไขที่
                    ผู้ขออนุญาตจะต้องดำเนินการก่อนการพิจารณาออกใบอนุญาต พ.ศ. 2561
                </label>
                @if ($file6)
                    <a href="{{ asset('storage/' . $file6->file_path) }}" target="_blank">{{ $file6->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck7">แบบสรุปผลการรับฟังความคิดเห็นของประชาชนที่เกี่ยวข้อง
                    ตามประกาศกระทรวงสาธารณสุข เรื่องหลักเกณฑ์ในการรับฟังความคิดเห็นของประชาชนที่เกี่ยวข้อง พ.ศ.2561
                </label>
                @if ($file7)
                    <a href="{{ asset('storage/' . $file7->file_path) }}" target="_blank">{{ $file7->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
            <div class="form-check mb-2">
                <label class="form-check-label" for="fileCheck8">แผนที่ตั้งสถานประกอบกิจการ
                </label>
                @if ($file8)
                    <a href="{{ asset('storage/' . $file8->file_path) }}" target="_blank">{{ $file8->file_name }}</a>
                @else
                    <span>-</span>
                @endif
            </div>
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
