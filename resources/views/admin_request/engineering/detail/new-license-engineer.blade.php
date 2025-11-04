@extends('layout.layout-admin-request')
@section('title', 'คำขอใบอนุญาตก่อสร้าง')

@section('content')
    <div class="text-center">
        <h4 class="header-form-name my-2 mx-4">
            คำขอใบอนุญาตก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร
        </h4>
    </div>


    @php
        $personalType = $addon['personal'] ?? '';
        $individualCardId = $addon['individual']['card_id'] ?? '';
        $corporationData = $addon['corporation'] ?? [];
    @endphp

    <div class="list-group text-start">
        <div class="mb-3">
            <label class="form-label">วันที่</label>
            <input type="text" name="field_date" class="form-control" value="{{ date('d/m/Y') }}" readonly>
        </div>

        <div class="col-md-12 my-3">
            <div class="d-flex flex-wrap align-items-center">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio"
                        {{ ($addon['personal'] ?? '') == 'individual' ? 'checked' : '' }} readonly>
                    <label class="form-check-label" for="option1">เป็นบุคคลธรรมดา</label>
                </div>
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio"
                        {{ ($addon['personal'] ?? '') == 'corporation' ? 'checked' : '' }} readonly>
                    <label class="form-check-label" for="option2">เป็นนิติบุคคล</label>
                </div>
            </div>
        </div>

        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">คำนำหน้า</label>
                <input type="text" class="form-control" value="{{ $trashRequest->prefix ?? '-' }}" readonly>
            </div>
            <div class="col-md-5">
                <label class="form-label">ชื่อ - นามสกุล</label>
                <input type="text" class="form-control" value="{{ $trashRequest->fullname ?? '-' }}" readonly>
            </div>

            @if ($personalType == 'individual')
                <div class="col-md-4">
                    <div>
                        <label class="form-label">เลขประจำตัวประชาชน<span class="text-danger">*</span></label>
                        <input type="text" value="{{ $individualCardId ?: '-' }}" class="form-control" readonly>
                    </div>
                </div>
            @endif

            @if ($personalType == 'corporation')
                {{-- ✅ ถ้าเลือก "นิติบุคคล" --}}
                <div class="col-md-4" id="corporation-fields1">
                    <div>
                        <label class="form-label">ประเภท<span class="text-danger">*</span></label>
                        <input type="text" name="addon[corporation][type]" required class="form-control">
                    </div>
                </div>
                <div id="corporation-fields2" class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div>
                            <label class="form-label">จดทะเบียนเมื่อ</label>
                            <input type="date" value="{{ $addon['corporation']['corp_registered_at'] ?? '-' }}" readonly
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">สำนักงานตั้งอยู่เลขที่ </label>
                        <input type="text" class="form-control"
                            value="{{ $addon['corporation']['corp_home_no'] ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="alley" class="form-label">ตรอก/ซอย</label>
                        <input type="text" class="form-control" value="{{ $addon['corporation']['alley'] ?? '-' }}"
                            readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="road" class="form-label">ถนน</label>
                        <input type="text" class="form-control" name="field_15"
                            value="{{ $addon['corporation']['road'] ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">หมู่ที่<span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            value="{{ $addon['corporation']['corp_village_no'] ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">แขวง/ตำบล<span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            value="{{ $addon['corporation']['subdistrict'] ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">เขต/อำเภอ<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $addon['corporation']['district'] ?? '-' }}"
                            readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">จังหวัด<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $addon['corporation']['province'] ?? '-' }}"
                            readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="tel" class="form-label">เบอร์โทร<span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" value="{{ $addon['corporation']['tel'] ?? '-' }}"
                            readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="fax" class="form-label">โทรสาร</label>
                        <input type="tel" class="form-control" value="{{ $addon['corporation']['fax'] ?? '-' }}"
                            readonly>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">ชื่อตัวแทนนิติบุคคลผู้ขออนุญาต<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $addon['corporation']['name'] ?? '-' }}"
                            readonly>
                    </div>
                </div>
            @endif

            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <label class="form-label">บ้านเลขที่</label>
                    <input type="text" class="form-control" value="{{ $trashRequest->house_no ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" value="{{ $trashRequest->alley ?? '-' }}" readonly>
                </div>
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
                <div class="col-md-3">
                    <label class="form-label">โทรสาร</label>
                    <input type="text" class="form-control" value="{{ $trashRequest->fax ?? '-' }}" readonly>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">
                            โปรดเลือกประเภทของคำขอต่ออายุใบอนุญาตของท่าน
                        </label>
                        <select id="option" class="form-select" disabled>
                            <option {{ ($addon['option'] ?? '') == '1' ? 'selected' : '' }} disabled>ก่อสร้างอาคาร</option>
                            <option {{ ($addon['option'] ?? '') == '2' ? 'selected' : '' }} disabled>ดัดแปลงอาคาร</option>
                            <option {{ ($addon['option'] ?? '') == '3' ? 'selected' : '' }} disabled>รื้อถอนอาคาร</option>
                            <option {{ ($addon['option'] ?? '') == '4' ? 'selected' : '' }} disabled>
                                เคลื่อนย้ายอาคารในท้องที่ที่อยู่ในเขตอำนาจของเจ้าพนักงานท้องถิ่นที่อาคารจะทำการเคลื่อนย้ายตั้งอยู่
                            </option>
                            <option {{ ($addon['option'] ?? '') == '5' ? 'selected' : '' }} disabled>
                                เคลื่อนย้ายอาคารไปยังท้องที่ที่อยู่ในเขตอำนาจของเจ้าพนักงานท้องถิ่นอื่น
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <label class="form-label"> ข้อ ๑ อาคารที่ขอต่ออายุใบอนุญาตได้รับใบอนุญาตตาม</label>
                <div class="col-md-3">
                    <label class="form-label"> ใบอนุญาตเลขที่</label>
                    <input type="text" class="form-control" value="{{ $addon['license_no1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label"> ลงวันที่</label>
                    <input type="date" value="{{ $addon['at1'] ?? '-' }}" readonly class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label"> บ้านเลขที่</label>
                    <input type="text" class="form-control" value="{{ $addon['home_no1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label for="alley" class="form-label">ตรอก/ซอย</label>
                    <input type="text" class="form-control" value="{{ $addon['alley1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" class="form-control" value="{{ $addon['road1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">หมู่ที่</label>
                    <input type="text" class="form-control" value="{{ $addon['village_no1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">แขวง/ตำบล</label>
                    <input type="text" class="form-control" value="{{ $addon['subdistrict1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">เขต/อำเภอ</label>
                    <input type="text" class="form-control" value="{{ $addon['district1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">จังหวัด</label>
                    <input type="text" class="form-control" value="{{ $addon['province1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">ชื่อเจ้าของอาคาร</label>
                    <input type="text" class="form-control" value="{{ $addon['name1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label for="option3" class="form-label" disabled>ในที่ดิน</label>
                    <select name="addon[option3]" id="option3" class="form-select" disabled>
                        <option {{ ($addon['option3'] ?? '') == '1' ? 'selected' : '' }} disabled>โฉนดที่ดิน</option>
                        <option {{ ($addon['option3'] ?? '') == '2' ? 'selected' : '' }} disabled>น.ส. ๓</option>
                        <option {{ ($addon['option3'] ?? '') == '3' ? 'selected' : '' }} disabled>น.ส. ๓ ก</option>
                        <option {{ ($addon['option3'] ?? '') == '4' ? 'selected' : '' }} disabled>ส.ค.๑</option>
                        <option {{ ($addon['option3'] ?? '') == '5' ? 'selected' : '' }} disabled>อื่น ๆ</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">เลขที่</label>
                    <input type="text" class="form-control" value="{{ $addon['no1'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label"> เป็นที่ดินของ</label>
                    <input type="text" value="{{ $addon['name2'] ?? '-' }}" readonly class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label"> วันสิ้นสุดใบอนุญาต</label>
                    <input type="date" value="{{ $addon['endat'] ?? '-' }}" readonly class="form-control">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <label class="form-label">ข้อ ๒ รูปแบบอาคาร</label>
                <div class="col-md-3">
                    <label class="form-label"> ชนิด</label>
                    <input type="text" class="form-control" value="{{ $addon['type2'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label"> จำนวน</label>
                    <input type="text" class="form-control" value="{{ $addon['num'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label"> เพือใช้เป็น</label>
                    <input type="text" value="{{ $addon['use'] ?? '-' }}" readonly class="form-control">
                </div>
                <label class="form-label"> โดยมีที่จอดรถ ที่กลับรถ และทางเข้าออกของรถ </label>
                <div class="col-md-3">
                    <label class="form-label"> จำนวน (คัน) </label>
                    <input type="text" class="form-control" value="{{ $addon['num1'] ?? '-' }}" readonly>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <label class="form-label">ข้อ ๓ เหตุที่ทำการไม่เสร็จตามที่ได้รับอนุญาต</label>
                <div class="col-md-6">
                    <label class="form-label">เนื่องจาก</label>
                    <textarea class="form-control" rows="3" readonly>{{ $addon['with'] ?? '-' }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ขณะนี้ได้ดำเนินการไปแล้วถึง</label>
                    <textarea rows="3" class="form-control" readonly>{{ $addon['to'] ?? '-' }}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label"> จึงขอต่ออายุอีก (วัน)</label>
                    <input type="text" value="{{ $addon['ExtraTime'] ?? '-' }}" readonly class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label"> ชื่อผู้ควบคุม </label>
                    <input type="text" class="form-control" value="{{ $addon['nameCon'] ?? '-' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label"> เลขบัตรประชาชนผู้ควบคุม </label>
                    <input type="text" class="form-control" value="{{ $addon['cardIdCon'] ?? '-' }}" readonly>
                </div>
            </div>

            {{-- ไฟล์แนบ (หลาย checkbox) --}}
            <div class="mb-3 mt-3">
                <label class="form-label">
                    ข้อ ๔ แนบเอกสารประกอบ <br>
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
                @endphp

                <div class="form-check mb-2">
                    <label class="form-check-label" for="fileCheck1">สำเนาเอกสารแสดงการเป็นเจ้าของอาคาร</label>
                    @if ($file1)
                        <a href="{{ asset('storage/' . $file1->file_path) }}"
                            target="_blank">{{ $file1->file_name }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>

                <div class="form-check mb-2">
                    <label class="form-check-label" for="fileCheck2">หนังสือแสดงความเป็นตัวแทนของเจ้าของอาคาร
                        (กรณีที่ตัวแทนเจ้าของอาคารเป็นผู้ขออนุญาต)</label>
                    @if ($file2)
                        <a href="{{ asset('storage/' . $file2->file_path) }}"
                            target="_blank">{{ $file2->file_name }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>

                <div class="form-check mb-2">
                    <label class="form-check-label" for="fileCheck3"> สำเนาเอกสารแสดงการเป็นผู้ครอบครองอาคาร</label>
                    @if ($file3)
                        <a href="{{ asset('storage/' . $file3->file_path) }}"
                            target="_blank">{{ $file3->file_name }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>
                <div class="form-check mb-2">
                    <span>
                        หนังสือแสดงว่าเป็นผู้จัดการหรือผู้แทนซึ่งเป็นผู้ดำเนินกิจการของนิติบุคคล
                        (กรณีที่นิติบุคคลเป็นผู้ขออนุญาต)
                        @if ($file4)
                            <a href="{{ asset('storage/' . $file4->file_path) }}" target="_blank" class="ms-2">
                                {{ $file4->file_name }}
                            </a>
                        @else
                            <span class="ms-2">-</span>
                        @endif
                    </span>
                </div>

                <div class="form-check mb-2">
                    <label class="form-check-label" for="fileCheck5"> ใบอนุญาตตามข้อ ๑
                    </label>
                    @if ($file5)
                        <a href="{{ asset('storage/' . $file5->file_path) }}"
                            target="_blank">{{ $file5->file_name }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>
                <div class="form-check mb-2">
                    <label class="form-check-label" for="fileCheck6"> หนังสือแสดงความยินยอมของผู้ควบคุมงาน </label>

                    {{-- ✅ ถ้ามีข้อมูล --}}
                    @if (!empty($addon['supervisor']['name']) || !empty($addon['supervisor']['card_id']) || $file6)
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label my-2">ชื่อผู้ควบคุมงาน</label>
                                <input type="text" class="form-control"
                                    value="{{ $addon['supervisor']['name'] ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label my-2">เลขประจำตัวประชาชน</label>
                                <input type="text" class="form-control"
                                    value="{{ $addon['supervisor']['card_id'] ?? '-' }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-12 my-2">
                            <label class="form-label mb-2">
                                สำเนาใบอนุญาตเป็นผู้ประกอบวิชาชีพสถาปัตยกรรมควบคุม
                                หรือวิชาวิศวกรรมควบคุม
                            </label>
                            @if ($file6)
                                <a href="{{ asset('storage/' . $file6->file_path) }}" target="_blank">
                                    {{ $file6->file_name }}
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    @else
                        <span>-</span>
                    @endif

                </div>

                <div class="form-check mb-2">
                    <span class="form-check-label">
                        หนังสือรับรองการได้รับอนุญาตให้เป็นผู้ประกอบวิชาชีพสถาปัตยกรรมควบคุม
                        หรือผู้ประกอบวิชาชีพวิศวกรรมควบคุม ที่ออกโดยสภาสถาปนิกหรือสภาวิศวกร
                        @if ($file7)
                            <a href="{{ asset('storage/' . $file7->file_path) }}"
                                target="_blank">{{ $file7->file_name }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </span>
                </div>

                <div class="form-check mb-2">
                    <label class="form-check-label" for="fileCheck8">เอกสารอื่น ๆ </label>
                    @if ($file8)
                        <a href="{{ asset('storage/' . $file8->file_path) }}"
                            target="_blank">{{ $file8->file_name }}</a>
                    @else
                        <span>-</span>
                    @endif
                </div>
            </div>
            {{-- แสดงเฉพาะถ้า status = รอรับรอง --}}
            @if ($trashRequest->status === 'รอรับเรื่อง')
                <div class="mb-3">
                    <label class="form-label d-block">ผลการตรวจสอบ</label>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inspection_result" id="pass"
                            value="pass">
                        <label class="form-check-label" for="pass">ผ่าน</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inspection_result" id="not-pass"
                            value="not-pass">
                        <label class="form-check-label" for="not-pass">ไม่ผ่าน</label>
                    </div>

                    <div class="mt-3">
                        <label for="note" class="form-label">หมายเหตุ / ข้อเสนอแนะ</label>
                        <textarea name="note" id="note" rows="3" class="form-control" placeholder="กรอกหมายเหตุที่นี่..."></textarea>
                    </div>

                    <div class="mt-3">
                        <button id="sendReply" class="btn btn-primary">บันทึกข้อมูล</button>
                    </div>
                </div>
            @endif
        </div>

    </div>


    {{-- ใส่ใต้เนื้อหา view ของคุณ --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const requestId = {{ $trashRequest->id }};
        const userId = {{ auth()->user()->id ?? 'null' }};

        document.getElementById('sendReply').addEventListener('click', () => {
            const note = document.getElementById('note').value;
            const result = document.querySelector('input[name="inspection_result"]:checked');

            if (!result) {
                Swal.fire('แจ้งเตือน', 'กรุณาเลือกผลการตรวจสอบ', 'warning');
                return;
            }

            if (result.value === 'not-pass' && note.trim() === '') {
                Swal.fire('แจ้งเตือน', 'กรุณากรอกหมายเหตุสำหรับสถานะไม่ผ่าน', 'warning');
                return;
            }

            fetch(`{{ route('admin_trash.accept') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        request_id: requestId,
                        user_id: userId,
                        inspection_result: result.value,
                        note: note
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('สำเร็จ!', 'บันทึกข้อมูลเรียบร้อยแล้ว', 'success')
                            .then(() => {
                                const type = "{{ $trashRequest->type }}"; // เอา type จาก request ปัจจุบัน
                                window.location.href = `/admin/request/engineering/showdata/${type}`;
                            });
                    } else {
                        Swal.fire('ผิดพลาด!', data.message || 'ไม่สามารถบันทึกได้', 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาด กรุณาลองใหม่', 'error');
                    console.error(err);
                });
        });
    </script>

    {{-- Leaflet Maps สำหรับแสดงตำแหน่งจากฐานข้อมูลเท่านั้น --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ดึงค่าจาก hidden input หรือจาก DB
            const lat = parseFloat("{{ $trashRequest->latitude ?? 13.7563 }}");
            const lng = parseFloat("{{ $trashRequest->longitude ?? 100.5018 }}");
            const map = L.map('map', {
                dragging: false,
                zoomControl: false,
                scrollWheelZoom: false,
                doubleClickZoom: false,
                boxZoom: false,
                keyboard: false
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // วาง marker ที่ตำแหน่ง
            if (!isNaN(lat) && !isNaN(lng)) {
                L.marker([lat, lng]).addTo(map);
            }
        });
    </script>

@endsection
