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
            font-size: 16px;
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
        <div style="border: 1px solid #000; padding: 0.5rem; display: inline-block; width: 25%;">
            <span>เลขที่รับ</span>
            <span class="dotted-line" style="width: 60%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
            <br>
            <span>วันที่รับคำร้อง</span>
            <span class="dotted-line" style="width: 45%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
        </div>
    </div>
    <div class="title_doc">
        <div style="border: 1px solid #000; padding: 0.5rem; display: inline-block;">
            แบบคำขอรับใบอนุญาต
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
        <span>เลขบัตรประชาชน</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_5'] ?? '-' }}</span>
        <span>อยู่บ้านเลขที่</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_8'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_9'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_6'] ?? '-' }}</span>

        <span>ถนน</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_7'] ?? '-' }}</span>
        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_10'] ?? '-' }}</span>
        <span>.อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_11'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_12'] ?? '-' }}</span>

        <span>หมายเลขโทรศัพท์</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_13'] ?? '-' }}</span>
        <span>ประจำปีพ.ศ.</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_41'] ?? '-' }}</span>
        <span>ใช้ชื่อสถานที่ว่า</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_34'] ?? '-' }}</span>

        <span>อยู่บ้านเลขที่</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_36'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_39'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_37'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_38'] ?? '-' }}</span>

        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_42'] ?? '-' }}</span>
        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_43'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_44'] ?? '-' }}</span>
        <span>หมายเลขโทรศัพท์</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_40'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left: 5rem;">
        <span>ขอยื่นคำขอรับใบอนุญาตประกอบกิจการตามเทศบัญญัติ</span>
        <br>

        <span>({{ isset($fields['field_15']) && $fields['field_15'] == 'corporation' ? '/' : ' ' }})</span>
        <span>กิจการที่เป็นอันตรายต่อสุขภาพ พ.ศ. 2543 ประเภท</span>
        <span class="dotted-line"
            style="min-width: 20%;">{{ isset($fields['field_15']) && $fields['field_15'] == 'corporation' ? $fields['field_24'] : ' ' }}</span>
        <span>มีคนงาน</span>
        <span class="dotted-line"
            style="min-width: 20%;">{{ isset($fields['field_15']) && $fields['field_15'] == 'corporation' ? $fields['field_25'] : ' ' }}</span>
        <span>คน ใช้เครื่องจักรขนาด</span>
        <span class="dotted-line"
            style="min-width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] == 'corporation' ? $fields['field_26'] : ' ' }}</span>
        <span>แรงม๊า</span>
        <br>

        <span>({{ isset($fields['field_15']) && $fields['field_15'] == 'individual' ? '/' : ' ' }})</span>
        <span>กิจการที่เป็นอันตรายต่อสุขภาพ พ.ศ. 2543 ประเภท</span>
        <span class="dotted-line"
            style="min-width: 23%;">{{ isset($fields['field_15']) && $fields['field_15'] == 'individual' ? $fields['field_20'] : ' ' }}</span>
        <span>จำนวนห้องเช่า</span>
        <span class="dotted-line"
            style="min-width: 23%;">{{ isset($fields['field_15']) && $fields['field_15'] == 'individual' ? $fields['field_21'] : ' ' }}</span>
        <span>ห้อง บ้านเช่า</span>
        <span class="dotted-line"
            style="min-width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] == 'individual' ? $fields['field_22'] : ' ' }}</span>
        <span>หลัง</span>
    </div>


    <div class="box_text" style="text-align: left;">
        <span>ยื่นคำร้องต่อ นายกเทศมนตรีตำบลท่าข้าม พร้อมคำขอนี้ข้าพเจ้าได้แนบหลักฐานและเอกสารมาด้วย ดังนี้คือ</span>
    </div>

    <div class="box_text" style="text-align: left;">

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files1', $uploadedFiles ?? []) ? 'checked' : '' }}>
                1) สำเนาบัตรประจำตัว (ประชาชน/ข้าราชการ/พนักงานรัฐวิสาหกิจ/อื่น ๆ)
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files2', $uploadedFiles ?? []) ? 'checked' : '' }}>
                2) สำเนาทะเบียนบ้าน
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files3', $uploadedFiles ?? []) ? 'checked' : '' }}>
                3) ใบรับรองแพทย์ ไม่เกิน 6 เดือน
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox"
                    {{ array_intersect(['files4_1', 'files4_2', 'files4_3', 'files4_4'], $uploadedFiles ?? []) ? 'checked' : '' }}>
                4) หลักฐานการขออนุญาตตามกฎหมายอื่น ที่เกี่ยวเนื่อง ดังนี้
            </label>
            <br>
            <label style="margin-left:5rem;">
                <input type="checkbox" {{ in_array('files4_1', $uploadedFiles ?? []) ? 'checked' : '' }}>
                4.1 สำเนาใบอนุญาตประกอบกิจการโรงงานอุตสาหกรรม (รง.4) จำนวน 1 ฉบับ
            </label>
            <br>
            <label style="margin-left:5rem;">
                <input type="checkbox" {{ in_array('files4_2', $uploadedFiles ?? []) ? 'checked' : '' }}>
                4.2 สำเนาหนังสือรับรองการจดทะเบียนของบริษัทจำกัด หรือห้างหุ้นส่วน จำกัด จำนวน 1 ฉบับ
            </label>
            <br>
            <label style="margin-left:5rem;">
                <input type="checkbox" {{ in_array('files4_3', $uploadedFiles ?? []) ? 'checked' : '' }}>
                4.3 หนังสือมอบอำนาจพร้อมติดอากรแสตมป์ 10 บาท (กรณีผู้มีอำนาจลงนามไม่ได้ลงนามเอง)
                จำนวน 1 ฉบับ
            </label>
            <br>
            <label style="margin-left:5rem;">
                <input type="checkbox" {{ in_array('files4_4', $uploadedFiles ?? []) ? 'checked' : '' }}>
                4.4 สำเนาบัตรประจำตัวประชาชน และสำเนาทะเบียนบ้านของผู้มีอำนาจลงนาม / และผู้ที่ได้รับ
                มอบอำนาจ อย่างละ 1 ชุด
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files5', $uploadedFiles ?? []) ? 'checked' : '' }}>
                5) ใบอนุญาตฉบับเก่าที่กำลังจะหมดอายุ หรือที่หมดอายุแล้ว
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files6', $uploadedFiles ?? []) ? 'checked' : '' }}>
                6) แบบรายการตรวจสอบตามหลักเกณฑ์ และเงื่อนไขที่ผู้ขออนุญาตจะต้องดำเนินการก่อนการพิจารณาออกใบอนุญาต
                ตามประกาศกระทรวงสาธารณสุข เรื่อง กำหนดประเภทหรือขนาดของกิจการและหลักเกณฑ์ วิธีการ และเงื่อนไขที่
                ผู้ขออนุญาตจะต้องดำเนินการ<br>ก่อนการพิจารณาออกใบอนุญาต พ.ศ. 2561
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files7', $uploadedFiles ?? []) ? 'checked' : '' }}>
                7) แบบสรุปผลการรับฟังความคิดเห็นของประชาชนที่เกี่ยวข้อง ตามประกาศกระทรวงสาธารณสุข
                เรื่องหลักเกณฑ์ในการรับฟังความคิดเห็นของประชาชนที่เกี่ยวข้อง พ.ศ.2561
            </label>
        </div>

        <div style="margin-left:5rem;">
            <label>
                <input type="checkbox" {{ in_array('files8', $uploadedFiles ?? []) ? 'checked' : '' }}>
                8) แผนที่ตั้งสถานประกอบกิจการ
            </label>
        </div>

        <div style="text-align: right; margin-right:5rem;">
            <label>
                ข้าพเจ้าขอรับรองว่า ข้อความในแบบคำขอรับใบอนุญาตนี้เป็นความจริงทุกประการ
            </label>
        </div>

    </div>

    <div class="box_text" style="text-align: right; margin-top:0.5rem; margin-bottom:1.5rem;">
        <span>ลงชื่อ</span>
        <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_1'] ?? '-' }}</span>
        <span>ผู้ขออนุญาต</span>
        <div style="margin-right: 3rem;">
            <span>(</span>
            <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_2'] ?? '-' }}
                {{ $fields['field_1'] ?? '-' }}</span>
            <span>)</span>
        </div>
        <div style="margin-right: 3rem;">
            <span>วันที่</span>
            <span class="dotted-line" style="width: 35%; text-align: center;">
                {{ $day ?? '-' }} {{ $month ?? '-' }} {{ $year ?? '-' }}</span>
        </div>
    </div>

</body>

</html>
