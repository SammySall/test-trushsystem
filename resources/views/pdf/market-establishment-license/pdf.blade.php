<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>PDF Report</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew-Bold.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 18px;
            line-height: 1.05;
        }

        .dotted-line {
            border-bottom: 2px dotted blue;
            display: inline-block;
        }

        .box_text {
            margin: 5px 0;
        }

        .title_doc {
            text-align: center;
            font-weight: bold;
            /* margin-bottom: 10px; */
        }
    </style>
</head>

<body>
    <div style="text-align: right; font-weight: bold;">
        <span>แบบ ตล.๑</span>
    </div>
    <div style="text-align: left; font-weight: bold;">
        <div style="border: 1px solid #000; padding: 0.5rem; display: inline-block; width: 20%;">
            <span>คำขอเลขที่</span>
            <span class="dotted-line" style="width: 23%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
            <span>/</span>
            <span class="dotted-line" style="width: 23%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>

        </div>
    </div>
    <div class="title_doc">
        <div style="padding: 0.5rem; ">
            แบบคำขอรับใบอนุญาตจัดตั้งตลาด
        </div>
    </div>

    <div class="box_text" style="text-align: right;">
        <span>เขียนที่
            <span class="dotted-line" style="width: 25%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
            {{-- เทศบาลตำบลท่าข้าม <br>112 หมู่ 3 ตำบลท่าข้าม <br>อำเภอบางปะกง จังหวัดฉะเชิงเทรา --}}
        </span>
        <div>
            <span>วันที่</span>
            <span class="dotted-line" style="width: 5%; text-align: center;">{{ $day ?: '-' }}</span>
            <span>เดือน</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">{{ $month ?: '-' }}</span>
            <span>พ.ศ.</span>
            <span class="dotted-line" style="width: 10%; text-align: center;">{{ $year ?: '-' }}</span>
        </div>
    </div>

    <div class="box_text" style="text-align: right;">
        <span>ข้าพเจ้า</span>
        <span class="dotted-line" style="width: 40%; text-align: left;">
            {{ $fields['field_2'] ?? '-' }} {{ $fields['field_1'] ?? '-' }}
        </span>
        <span>อายุ</span>
        <span class="dotted-line" style="width: 15%; text-align: left;">{{ $fields['field_5'] ?? '-' }}</span>
        <span>สัญชาติ</span>
        <span class="dotted-line" style="width: 17%; text-align: left;">{{ $fields['field_6'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span>อยู่บ้านเลขที่</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_8'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_9'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_6'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 22%;">{{ $fields['field_7'] ?? '-' }}</span>

        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_10'] ?? '-' }}</span>
        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_11'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_12'] ?? '-' }}</span>

        <span>หมายเลขโทรศัพท์</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_13'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left: 5rem;">
        <span>ขอยื่นคำขอรับใบอนุญาตประกอบกิจการ</span>
        <br>

        <span>({{ isset($fields['field_option']) && $fields['field_option'] == 'individual' ? '/' : ' ' }})</span>
        <span>ตลาดประเภทที่ ๑ (ตลาดที่มีโครงสร้างอาคาร) โดยมีพื้นที่ประกอบการ</span>
        <span class="dotted-line"
            style="min-width: 15%;">{{ isset($fields['field_option']) && $fields['field_option'] == 'individual' ? $fields['field_35'] : ' ' }}</span>
        <span>ตารางเมตร</span>
        <br>

        <span>({{ isset($fields['field_option']) && $fields['field_option'] == 'corporation' ? '/' : ' ' }})</span>
        <span>ตลาดประเภทที่ ๒ (ตลาดที่ไม่มีโครงสร้างอาคาร) โดยมีพื้นที่ประกอบการ</span>
        <span class="dotted-line"
            style="min-width: 15%;">{{ isset($fields['field_option']) && $fields['field_option'] == 'corporation' ? $fields['field_35'] : ' ' }}</span>
        <span>ตารางเมตร</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span style="margin-left: 5rem">ตั้งอยู่ ณ เลขที่</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_36'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 13%;">{{ $fields['field_39'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_37'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_38'] ?? '-' }}</span>

        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_42'] ?? '-' }}</span>
        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_43'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_44'] ?? '-' }}</span>

        <span>หมายเลขโทรศัพท์</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_40'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;">
        <span>พร้อมคำขอนี้ข้าพเจ้าได้แนบหลักฐานและเอกสารมาด้วย ดังนี้คือ</span>
    </div>

    <div class="box_text" style="text-align: left;">

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files1', $uploadedFiles ?? []) ? 'checked' : '' }}>
                1) สำเนาบัตรประจำตัวประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ จำนวน ๑ ชุด
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files2', $uploadedFiles ?? []) ? 'checked' : '' }}>
                2) สำเนาทะเบียนบ้าน จำนวน ๑ ชุด
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files3', $uploadedFiles ?? []) ? 'checked' : '' }}>
                3) สำเนาใบอนุญาตตามกฎหมายที่เกี่ยวข้อง จำนวน ๑ ชุด
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files4', $uploadedFiles ?? []) ? 'checked' : '' }}>
                4) สำเนาหนังสือรับรองการจดทะเบียนนิติบุคคล พร้อมสำเนาบัตรประจำตัวประชาชนของผู้แทนนิติ
                บุคคล (ในกรณีที่ผู้ขออนุญาตเป็นนิติบุคคล)

            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files5', $uploadedFiles ?? []) ? 'checked' : '' }}>
                5) หนังสือมอบอำนาจในกรณีที่เจ้าของกิจการไม่มายื่นขอรับใบอนุญาตด้วยตนเอง
            </label>
        </div>

        <div style="margin-left:5rem; margin-bottom: 16rem;">
            <label>
                <input type="checkbox" {{ in_array('files6', $uploadedFiles ?? []) ? 'checked' : '' }}>
                6) อื่น ๆ ตามที่องค์การบริหารส่วนตำบลท่าข้ามกำหนด
                <span class="dotted-line"
                    style="min-width: 50%;">{{ isset($fields['files6']) ? $fields['field_99'] : ' ' }}</span>
            </label>
        </div>

        <div style="text-align: right; margin-right:5rem;">
            <label>
                (ต่อด้านหลัง)
            </label>
        </div>
        <div style="text-align: right; margin-right:5rem;">
            <label>
                (ด้านหลัง)
            </label>
        </div>

        <div class="title_doc">
            <div style="padding: 0.5rem; ">
                แผนผังแสดงที่ตั้งสถานประกอบกิจการโดยสังเขป
            </div>
        </div>
        <div style="text-align: center;">
            <div style="border: 1px solid #000; padding: 0.5rem; width:80%; height:70%; margin: 0 auto;">
            </div>
        </div>


        <div style="text-align: right; margin-right:5rem; margin-top:2rem;">
            <label>
                ข้าพเจ้าขอรับรองว่า ข้อความในแบบคำขอใบอนุญาตนี้เป็นความจริงทุกประการ
            </label>
        </div>

    </div>

    <div class="box_text" style="text-align: right; margin-top:0.5rem; margin-bottom:10rem;">
        <span>ลงชื่อ</span>
        <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
        <span>ผู้ขออนุญาต</span>
        <div style="margin-right: 3rem;">
            <span>(</span>
            <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_99'] ?? '' }}
                {{ $fields['field_99'] ?? '' }}</span>
            <span>)</span>
        </div>
    </div>

    <div class="title_doc">
        <div style="padding: 0.5rem; text-decoration: underline;">
            ความเห็นของเจ้าพนักงานสาธารณสุข
        </div>
    </div>

    <div class="box_text" style="text-align: left;">

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files_approve_1', $uploadedFiles ?? []) ? 'checked' : '' }}>
                เห็นสมควรอนุญาต และควรกำหนดเงื่อนไข ดังนี้
                <span class="dotted-line"
                    style="min-width: 50%;">{{ isset($fields['files_approve_1']) ? $fields['field_99'] : ' ' }}</span>
                <br> <span class="dotted-line"
                    style="width: 100%; text-align: center;">{{ $fields['files_approve_1'] ?? '' }}</span>

            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files_approve_2', $uploadedFiles ?? []) ? 'checked' : '' }}>
                เห็นควรไม่อนุญาต เพราะ
                <span class="dotted-line"
                    style="min-width: 50%;">{{ isset($fields['files_approve_2']) ? $fields['field_99'] : ' ' }}</span>
                <br> <span class="dotted-line"
                    style="width: 100%; text-align: center;">{{ $fields['files_approve_2'] ?? '' }}</span>

            </label>
        </div>

    </div>

    <div class="box_text" style="text-align: right; margin-top:0.5rem; margin-bottom:1.25rem;">
        <span>ลงชื่อ</span>
        <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
        <span>เจ้าพนักงานสาธารณสุข</span>
        <div style="margin-right: 8rem;">
            <span>(</span>
            <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_99'] ?? '' }}
                {{ $fields['field_99'] ?? '' }}</span>
            <span>)</span>
        </div>
        <span>ตำแหน่ง</span>
        <span class="dotted-line"
            style="width: 35%; text-align: center; margin-right: 7rem">{{ $fields['field_99'] ?? '' }}</span>
        <div style="margin-right: 8rem;">
            <span>(</span>
            <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_99'] ?? '' }}
                {{ $fields['field_99'] ?? '' }}</span>
            <span>)</span>
        </div>
        <div style="margin-right: 8rem;">
            <span>วันที่</span>
            <span class="dotted-line" style="width: 35%; text-align: center;">
                {{ $fields['field_99'] ?? '' }} {{ $fields['field_99'] ?? '' }}
                {{ $fields['field_99'] ?? '' }}</span>
        </div>
    </div>

    <div style="text-align: center;">
        <div style="border: 1px solid #000; padding: 0.5rem; width:60%; margin: 0 auto;">
            <div class="title_doc">
                <div style="padding: 0.5rem; text-decoration: underline;">
                    ความเห็นของเจ้าพนักงานสาธารณสุข
                </div>
            </div>

            <div style="margin-left:3rem; text-align: left;">
                <label>
                    <input type="checkbox" {{ in_array('files_approve_3', $uploadedFiles ?? []) ? 'checked' : '' }}>
                    อนุญาตให้ประกอบกิจการได้
                </label>
            </div>
            <div style="margin-left:3rem;text-align: left;">
                <label>
                    <input type="checkbox" {{ in_array('files_approve_4', $uploadedFiles ?? []) ? 'checked' : '' }}>
                    ไม่อนุญาตให้ประกอบกิจการ เพราะ
                    <span class="dotted-line"
                        style="min-width: 40%;">{{ isset($fields['files_approve_4']) ? $fields['field_99'] : ' ' }}</span>
                </label>
            </div>

            <div class="box_text" style="text-align: right; margin-top:0.5rem; margin-bottom:1.25rem;">
                <span>(ลงชื่อ)</span>
                <span class="dotted-line"
                    style="width: 40%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
                <span>เจ้าพนักงานท้องถิ่น</span>
                <div style="margin-right: 6rem;">
                    <span>(</span>
                    <span class="dotted-line" style="width: 40%; text-align: center;">{{ $fields['field_99'] ?? '' }}
                        {{ $fields['field_99'] ?? '' }}</span>
                    <span>)</span>
                </div>
                <span>ตำแหน่ง</span>
                <span class="dotted-line"
                    style="width: 40%; text-align: center; margin-right: 6rem">{{ $fields['field_99'] ?? '' }}</span>
                <div style="margin-right: 6rem;">
                    <span>(</span>
                    <span class="dotted-line" style="width: 40%; text-align: center;">{{ $fields['field_99'] ?? '' }}
                        {{ $fields['field_99'] ?? '' }}</span>
                    <span>)</span>
                </div>
                <div style="margin-right: 6rem;">
                    <span>วันที่</span>
                    <span class="dotted-line" style="width: 40%; text-align: center;">
                        {{ $fields['field_99'] ?? '' }} {{ $fields['field_99'] ?? '' }}
                        {{ $fields['field_99'] ?? '' }}</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
