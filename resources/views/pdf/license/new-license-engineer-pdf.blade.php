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
            font-weight: bold;
            font-size: 20px;
            line-height: 1;
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
            font-size: 20px;
            margin-bottom: 25px;
        }

        .checkbox-item {
            display: block;
            position: relative;
            padding-left: 25px;
            margin-bottom: 5px;
        }

        .checkbox-item::before {
            content: " ";
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid black;
            position: absolute;
            left: 0;
            top: 0;
        }

        .checkbox-item.checked::before {
            content: "✓";
            font-weight: bold;
            text-align: center;
            line-height: 16px;
        }
    </style>
</head>

<body>
    <div style="margin-top: 2%">
        {{-- <img src="{{ public_path('img/icon/logo.png') }}" alt="LOGO" style="width:150px; margin-bottom:10px;"> --}}
        <div style="text-align: right">แบบ อ.1<br>
        </div>
    </div>
    <div style="text-align: center;">
        <img src="{{ public_path('img/icon/logo.png') }}" alt="LOGO" style="width:100px; ">
        <div class="title_doc">
            ใบอนุญาตก่อสร้างอาคาร ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร</div>
    </div>

    <div class="box_text" style="text-align: left;">
        <span>เลขที่
            <span class="dotted-line" style="width: 10%; text-align: center;">
                {{ $fields['field_99'] ?? '-' }}</span>
            / <span class="dotted-line" style="width: 10%; text-align: center;">
                {{ $fields['field_99'] ?? '-' }}</span></span>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;">
        <span>อนุญาตให้</span>
        <span class="dotted-line" style="width: 72%;">{{ $fields['field_2'] ?? '-' }}
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>เป็นเจ้าของอาคาร</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span>อยู่บ้านเลขที่</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_8'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_6'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_7'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 12%;">{{ $fields['field_9'] ?? '-' }}</span>

        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_10'] ?? '-' }}</span>
        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_11'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_12'] ?? '-' }}</span>

        <span>รหัสไปรษณีย์</span>
        <span class="dotted-line" style="width: 23%;">{{ $fields['field_12'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        @php
            $optionText = match ($fields['field_option'] ?? null) {
                "1" => 'ก่อสร้างอาคาร',
                "2" => 'ดัดแปลงอาคาร',
                "3" => 'รื้อถอนอาคาร',
                "4" => 'เคลื่อนย้ายอาคาร',
                default => '-',
            };
        @endphp
        <span style="margin-left:5rem;">ข้อ ๑ ทําการ</span>
        <span class="dotted-line" style="width: 75%;">{{ $optionText }}</span>

        <span>อยู่บ้านเลขที่</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_56'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_57'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_58'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 12%;">{{ $fields['field_59'] ?? '-' }}</span>

        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_60'] ?? '-' }}</span>
        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_61'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_62'] ?? '-' }}</span>
        <span>รหัสไปรษณีย์</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_54'] ?? '-' }}</span>

        <span>ในที่ดิน</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 1 ? 'checked' : '' }}>
        <span>โฉนดที่ดิน</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 2 ? 'checked' : '' }}>
        <span>น.ส. ๓</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 3 ? 'checked' : '' }}>
        <span>น.ส. ๓ ก</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 4 ? 'checked' : '' }}>
        <span>ส.ค.๑</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 5 ? 'checked' : '' }}>
        <span>อื่น ๆ เลขที่</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_81'] ?? '-' }}</span>
        <span>เป็นที่ดินของ</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_82'] ?? ' ' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span
            style="margin-left:5rem;">ทําการเคลื่อนย้ายอาคารในท้องที่ที่อยู่ในเขตอํานาจของเจ้าหน้าที่พนักงานท้องถิ่นที่อาคารจะทําการเคลื่อนย้ายตั้งอยู่</span>
        <span>ไปยังบ้านเลขที่</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_99'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_99'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_99'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 12%;">{{ $fields['field_99'] ?? '-' }}</span>

        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>
        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>
        <span>รหัสไปรษณีย์</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>

        <span>ในที่ดิน</span>
        <input type="checkbox" {{ isset($fields['field_99']) && $fields['field_99'] == 1 ? 'checked' : '' }}>
        <span>โฉนดที่ดิน</span>
        <input type="checkbox" {{ isset($fields['field_99']) && $fields['field_99'] == 2 ? 'checked' : '' }}>
        <span>น.ส. ๓</span>
        <input type="checkbox" {{ isset($fields['field_99']) && $fields['field_99'] == 3 ? 'checked' : '' }}>
        <span>น.ส. ๓ ก</span>
        <input type="checkbox" {{ isset($fields['field_99']) && $fields['field_99'] == 4 ? 'checked' : '' }}>
        <span>ส.ค.๑</span>
        <input type="checkbox" {{ isset($fields['field_99']) && $fields['field_99'] == 5 ? 'checked' : '' }}>
        <span>อื่น ๆ เลขที่</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_99'] ?? '-' }}</span>
        <span>เป็นที่ดินของ</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_99'] ?? ' ' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span style="margin-left: 5rem">ข้อ ๒ เป็นอาคาร</span>
        <br>
        <span style="margin-left: 10rem">ชนิด</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_86'] ?? '-' }}</span>
        <span>จำนวน</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_87'] ?? '-' }}</span>
        <span>เพื่อใช้เป็น</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_88'] ?? '-' }}</span>

        <span>พื้นที่อาคาร/ความยาว</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_99'] ?? '-' }}</span>
        <span>โดยมีที่จอดรถ ที่กลับรถ และทางเข้าออกของรถ จำนวน</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_89'] ?? '-' }}</span>
        <span>คัน พื้นที่</span>
        <span class="dotted-line" style="width: 5%;">{{ $fields['field_99'] ?? '-' }}</span>
        <span>ตารางเมตร ตามแผนผังบริเวณ แบบแปลน รายการประกอบแบบแปลน และรายการคํานวณเลขที่</span>
        <span class="dotted-line" style="width: 5%;">{{ $fields['field_99'] ?? '-' }}</span>
        <span>ที่แนบท้ายใบอนุญาตนี้</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span style="margin-left: 5rem">ข้อ ๓ โดยมี</span>
        <span class="dotted-line" style="width: 62%;">{{ $fields['field_93'] ?? '' }}</span>
        <span>เป็นผู้ควบคุมงาน หรือ</span>
        <span class="dotted-line" style="width: 50%;">{{ $fields['field_99'] ?? '' }}</span>
        <span>เป็นผู้ออกแบบและคํานวณอาคาร</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span style="margin-left: 5rem">ข้อ ๔ ผู้ได้รับใบอนุญาตต้องปฏิบัติตามเงื่อนไข ดังต่อไปนี้</span>
        <br>
        <span style="margin-left: 10rem;">
            (๑) ผู้ได้รับใบอนุญาตต้องปฏิบัติตามหลักเกณฑ์ วิธีการ และเงื่อนไขตามที่กําหนด
            ในกฎกระทรวง ซึ่งออกตามความในมาตรา ๘ (๑๑) แห่งพระราชบัญญัติควบคุมอาคาร พ.ศ. ๒๕๒๒ หรือข้อบัญญัติท้องถิ่น
            ซึ่งออกตามความ
            ในมาตรา ๙ หรือมาตรา ๑๐ แห่งพระราชบัญญัติควบคุมอาคาร พ.ศ.๒๕๒๒</span>
        <br>
        <div style="text-align: center; margin-top: 5rem;">
            <div class="title_doc">
                -๒-</div>
        </div>
        <div style="margin-left: 10rem;">(๒)
            <span class="dotted-line" style="width: 90%;">{{ $fields['field_99'] ?? '' }}</span>
        </div>

        <div class="box_text" style="text-align: left;">
            <span style="margin-left:5rem;">ใบอนุญาตฉบับนี้ให้ใช้ได้จนถึงวันที่</span>
            <span class="dotted-line" style="width: 16%; text-align: center;">
                {{ $fields['field_30'] ?? '' }}</span>
            <span>เดือน</span>
            <span class="dotted-line" style="width: 16%; text-align: center;">
                {{ $fields['field_31'] ?? '' }}</span>
            <span>พ.ศ.</span>
            <span class="dotted-line" style="width: 16%; text-align: center;">
                {{ $fields['field_32'] ?? '' }}</span>
            <br>
            <span style="margin-left:13rem;">ออกให้ ณ วันที่</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_27'] ?? '' }}</span>
            <span>เดือน</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_28'] ?? '' }}</span>
            <span>พ.ศ.</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_29'] ?? '' }}</span>
        </div>

    </div>

    <div class="signature-section"
        style="display: flex; flex-direction: column; align-items: flex-end; gap: 2rem; margin-right: 5rem; margin-top:1rem; margin-bottom:1.5rem;">

        <div class="signature-item" style="text-align: right;">
            <span>(ลายมือชื่อ)</span>
            <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                {{ $fields['field_33'] ?? '' }}
            </span>
            <span>ผู้อนุญาต</span>
            <div>
                <span>(</span>
                <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                    {{ $fields['field_33'] ?? '' }}
                </span>
                <span style="margin-right: 3rem;">)</span>
            </div>
            <span>ตำแหน่ง</span>
            <span class="dotted-line"
                style="width: 35%; display: inline-block; text-align: center; margin-right:3rem;">
                {{ $fields['field_99'] ?? '' }}
            </span>
            <br>
            <span style="margin-right:8rem;">เจ้าพนักงานท้องถิ่น</span>
        </div>

        <div class="box_text" style="text-align: left; margin-left:5rem;">
            <span>หมายเหตุ ๑. ข้อความใดที่ไม่ต้องการให้ขีดฆ่า</span>
            <br>
            <span style="margin-left:3.4rem;">๒. ใส่เครื่องหมาย / ในช่อง [ ] หน้าข้อความที่ต้องการ</span>
            <br>
        </div>
    </div>

    <div style="text-align: center; margin-top: 95%;">
        <div class="title_doc">
            -๓-</div>
    </div>
    <div style="text-align: center;">
        <div class="title_doc">
            คําเตือน</div>
    </div>
    <div>
        <span style="margin-left:5rem;">๑.
            ในกรณีที่ผู้ได้รับใบอนุญาตยังมิได้ดําเนินการก่อสร้างและยังไม่ได้แจ้งชื่อผู้ควบคุมงานก่อนเริ่มก่อสร้าง ต้อง
            แจ้งชื่อผู้ควบคุมงานตามแบบ น.๓ ต่อเจ้าพนักงานท้องถิ่น</span>
        <br>
        <span style="margin-left:5rem;">๒.
            ถ้าผู้ได้รับใบอนุญาตจะบอกเลิกตัวผู้ควบคุมงานที่ได้ระบุชื่อไว้ในใบอนุญาต หรือผู้ควบคุมงานจะบอกเลิกการ
            เป็นผู้ควบคุมงาน ให้มีหนังสือแจ้งให้เจ้าพนักงานท้องถิ่นทราบ
            ทั้งนี้ไม่เป็นการกระทบถึงสิทธิและหน้าที่ทางแพ่งระหว่าง
            ผู้ได้รับใบอนุญาตกับผู้ควบคุมงานนั้น
            ในการบอกเลิกตัวผู้ควบคุมงานนี้ผู้ได้รับใบอนุญาตต้องระงับการดําเนินการตามที่
            ได้รับอนุญาตไว้ก่อนจนกว่าจะมีผู้ควบคุมงานคนใหม่ และมีหนังสือแจ้งพร้อมกับส่งมอบหนังสือแสดงความยินยอมของ
            ผู้ควบคุมงานคนใหม่ให้แก่เจ้าพนักงานท้องถิ่นแล้ว</span>
        <br>
        <span style="margin-left:5rem;">๓.
            ผู้ได้รับใบอนุญาตที่ต้องจัดให้มีพื้นที่หรือสิ่งที่สร้างขึ้นเพื่อใช้เป็นที่จอดรถ ที่กลับรถและทางเข้าออกของรถ
            ตามที่กําหนดไว้ในใบอนุญาตฉบับนี้ ต้องแสดงที่จอดรถ ที่กลับรถ
            และทางเข้าออกของรถไว้ให้ปรากฏตามแผนผังบริเวณที่รับ
            ใบอนุญาตการดัดแปลงหรือใช้ที่จอดรถ ที่กลับรถ และทางเข้าออกของรถเพื่อการอื่น นั้นต้องได้รับใบอนุญาตจาก
            เจ้าพนักงานท้องถิ่น</span>
        <br>
        <span style="margin-left:5rem;">๔.
            ผู้ได้รับใบอนุญาตก่อสร้าง ดัดแปลง หรือเคลื่อนย้ายอาคารประเภทควบคุมการใช้ เมื่อได้ทําการตามที่ได้รับ
            ใบอนุญาตเสร็จแล้ว ต้องได้รับใบรับรองจากเจ้าพนักงานท้องถิ่นตามมาตรา 32 วรรคสี่
            ก่อนจึงจะใช้อาคารนั้นได้</span>
        <br>
        <span style="margin-left:5rem;">๕.
            ใบอนุญาตฉบับนี้ ให้ใช้ได้ตามระยะเวลาที่กําหนดในใบอนุญาต ถ้าประสงค์จะขอต่ออายุใบอนุญาตจะต้อง
            ยื่นคําขอก่อนใบอนุญาตสิ้นอายุ</span>
    </div>

</body>

</html>
