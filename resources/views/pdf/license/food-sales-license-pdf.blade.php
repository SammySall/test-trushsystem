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
            font-size: 36px;
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
        {{-- <img src="{{ public_path('img/menuuser/LOGO.png') }}" alt="LOGO" style="width:150px; margin-bottom:10px;"> --}}
        <div style="text-align: right">แบบ อภ.{{ $fields['field_option'] + 3 }}<br>
        </div>
    </div>
    <div style="text-align: center;">
        <img src="{{ public_path('img/icon/logo.png') }}" alt="LOGO" style="width:120px;">
        @php
            // แปลงค่าจาก string เป็นตัวเลข (กันกรณี field_option เป็น "3" แทน 3)
            $option = isset($fields['field_option']) ? (int) $fields['field_option'] : 0;

            $isCertificate = $option > 2;

            // ตั้งชื่อเอกสารตามประเภท
            switch ($option) {
                case 1:
                    $documentSubtitle = 'จัดตั้งสถานที่จำหน่ายอาหาร';
                    break;
                case 2:
                    $documentSubtitle = 'จัดตั้งสถานที่สะสมอาหาร';
                    break;
                case 3:
                    $documentSubtitle = 'การแจ้งตั้งสถานที่จำหน่ายอาหาร';
                    break;
                case 4:
                    $documentSubtitle = 'การแจ้งตั้งสถานที่สะสมอาหาร';
                    break;
                default:
                    $documentSubtitle = 'จัดตั้งสถานที่จำหน่ายอาหาร';
                    break;
            }
        @endphp

        <div class="title_doc">
            {{ $isCertificate ? 'หนังสือรับรอง' : 'ใบอนุญาต' }}{{ $documentSubtitle }}
        </div>



        <div class="box_text" style="text-align: left;">
            <span>เล่มที่</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_99'] ?? '-' }}</span>
            เลขที่ <span class="dotted-line" style="width: 10%; text-align: center;">
                {{ $fields['field_99'] ?? '-' }}</span>
            / <span class="dotted-line" style="width: 10%; text-align: center; ">
                {{ $year ?? '-' }}</span>
            </span>
            <span style="margin-left:10rem;">สำนักงาน</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_99'] ?? '' }}</span>
        </div>

        @php
            $personType = $fields['field_24'] ?? 'individual';
            $isIndividual = $personType === 'individual';
            $isCorporation = $personType === 'corporation';
        @endphp

        @if ($isCertificate)
            {{-- field_option > 2 --}}
            <div class="box_text" style="text-align: left; margin-left:5rem;">
                <span>เจ้าพนักงานท้องถิ่นรับรองให้ </span>

                {{-- Checkbox บุคคลธรรมดา --}}
                <input type="checkbox" disabled {{ $isIndividual ? 'checked' : '' }}>
                <span> บุคคลธรรมดา </span>

                {{-- Checkbox นิติบุคคล --}}
                <input type="checkbox" disabled {{ $isCorporation ? 'checked' : '' }}>
                <span> นิติบุคคล </span>

                <span> ชื่อ </span>
                <span class="dotted-line" style="width: 35%;">
                    {{ $fields['field_2'] ?? '-' }} {{ $fields['field_1'] ?? '-' }}
                </span>

                <span> อายุ </span>
                <span class="dotted-line" style="width: 15%; text-align: center;">
                    {{ $fields['field_3'] ?? '-' }}
                </span>
                <span> ปี </span>
            </div>
        @else
            {{-- field_option ≤ 2 --}}
            <div class="box_text" style="text-align: left; margin-left:5rem;">
                <span>อนุญาตให้ </span>

                <input type="checkbox" disabled {{ $isIndividual ? 'checked' : '' }}>
                <span> บุคคลธรรมดา </span>

                <input type="checkbox" disabled {{ $isCorporation ? 'checked' : '' }}>
                <span> นิติบุคคล </span>

                <span> ชื่อ </span>
                <span class="dotted-line" style="width: 30%;">
                    {{ $fields['field_2'] ?? '-' }} {{ $fields['field_1'] ?? '-' }}
                </span>

                <span> อายุ </span>
                <span class="dotted-line" style="width: 12%; text-align: center;">
                    {{ $fields['field_3'] ?? '-' }}
                </span>
                <span> ปี </span>
            </div>
        @endif


        <div class="box_text" style="text-align: left;">
            <span>สัญชาติ</span>
            <span class="dotted-line" style="width: 18%; text-align: center;">
                {{ $fields['field_4'] ?? '-' }}</span>
            <span>เลขประจำตัวประชาชนเลขที่</span>
            <span class="dotted-line" style="width: 30%; text-align: center;">
                {{ $fields['field_5'] ?? '-' }}</span>
            <span>อยู่บ้าน/สำนักงานเลขที่</span>
            <span class="dotted-line" style="width: 28%; text-align: center;">
                {{ $fields['field_8'] ?? '-' }}</span>
            <span>ครอก/ซอย</span>
            <span class="dotted-line" style="width: 28%; text-align: center;">
                {{ $fields['field_6'] ?? '-' }}</span>
            <span>ถนน</span>
            <span class="dotted-line" style="width: 28%; text-align: center;">
                {{ $fields['field_7'] ?? '-' }}</span>
        </div>

        <div class="box_text" style="text-align: left;">
            <span>หมู่ที่</span>
            <span class="dotted-line" style="width: 12%;">{{ $fields['field_9'] ?? '-' }}</span>
            <span>ตำบล/แขวง</span>
            <span class="dotted-line" style="width: 31%;">{{ $fields['field_10'] ?? '-' }}</span>
            <span>อำเภอ/เขต</span>
            <span class="dotted-line" style="width: 31%;">{{ $fields['field_11'] ?? '-' }}</span>
            <span>จังหวัด</span>
            <span class="dotted-line" style="width: 25%;">{{ $fields['field_12'] ?? '-' }}</span>
            <span>โทรศัพท์</span>
            <span class="dotted-line" style="width: 25%;">{{ $fields['field_13'] ?? '-' }}</span>
        </div>

        @php
            // แปลงเป็นตัวเลข (กันกรณี string)
            $isEvenOption = $option % 2 === 0; // true ถ้าเป็นคู่ (2, 4)
        @endphp
        <div class="box_text" style="text-align: left;">
            <span style="margin-left:5rem;">1. จัดตั้งสถานที่{{ $isEvenOption ? 'สะสมอาหาร' : 'จำหน่ายอาหาร' }}
                ประเภท</span>
            <span class="dotted-line" style="width: 53%; text-align: center;">
                {{ $fields['field_15'] ?? '-' }}</span>
            <span>สถานที่ชื่อ</span>
            <span class="dotted-line" style="width: 45%; text-align: center;">
                {{ $fields['field_34'] ?? '' }}</span>
            <span>พื้นที่ประกอบการ</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_35'] ?? '-' }}</span>
            <span>ตารางเมตร</span>
        </div>

        <div class="box_text" style="text-align: left;">
            <span style="margin-left:5rem;">2. ตั้งอยู่เลขที่</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_36'] ?? '-' }}</span>
            <span>ตรอก/ซอย</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_37'] ?? '' }}</span>
            <span>ถนน</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_38'] ?? '-' }}</span>
            <span>หมู่ที่</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_39'] ?? '-' }}</span>
            <span>โทรศัพท์</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_40'] ?? '-' }}</span>
        </div>

        <div class="box_text" style="text-align: left;">
            <span style="margin-left:5rem;">3. ค่าธรรมเนียมฉบับละ</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_16'] ?? '-' }}</span>
            <span>บาทต่อปี ใบรับเงินเล่มที่</span>
            <span class="dotted-line" style="width: 13%; text-align: center;">
                {{ $fields['field_00'] ?? '' }}</span>
            <span>เลขที่</span>
            <span class="dotted-line" style="width: 13%; text-align: center;">
                {{ $fields['field_00'] ?? '-' }}</span>
            <span>วันที่</span>
            <span class="dotted-line" style="width: 13%; text-align: center;">
                {{ $fields['field_17'] ?? '-' }}</span>
            <span>เดือน</span>
            <span class="dotted-line" style="width: 13%; text-align: center;">
                {{ $fields['field_18'] ?? '-' }}</span>
            <span>ปี</span>
            <span class="dotted-line" style="width: 13%; text-align: center;">
                {{ $fields['field_19'] ?? '-' }}</span>
        </div>

        <div class="box_text" style="text-align: left;">
            <span style="margin-left:5rem;">4.
                ผู้ได้รับ{{ $isCertificate ? 'หนังสือรับรองการแจ้ง' : 'ใบอนุญาต' }}ต้องปฏิบัติตามเงื่อนไขดังต่อไปนี้</span>
            <br>

            <span style="margin-left:6rem;">
                4.1ต้องปฏิบัติตาม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ว่าด้วยสถานที่จำหน่ายอาหารและสถานที่สะสมอาหารและปฏิบัติการอื่นใดเกี่ยวด้วยสุขลักษณะ
                ตามคำแนะนำของเจ้าพนักงานสาธารณสุข คำสั่งเจ้าหน้าที่พนักงานท้องถิ่น
                รวมทั้งระเบียบ ข้อบังคับ และคำสั่ง
            </span>
            <br>
            <span style="margin-left:6rem;">
                4.2
                <span class="dotted-line" style="width: 83%; text-align: center;">
                    {{ $fields['field_99'] ?? '' }}</span>
                <span>ออกให้ ณ วันที่</span>
                <span class="dotted-line" style="width: 8%; text-align: center;">
                    {{ $fields['field_27'] ?? '' }}</span>
                <span>เดือน</span>
                <span class="dotted-line" style="width: 15%; text-align: center;">
                    {{ $fields['field_28'] ?? '' }}</span>
                <span>พ.ศ.</span>
                <span class="dotted-line" style="width: 15%; text-align: center;">
                    {{ $fields['field_29'] ?? '' }}</span>
                <span>สิ้นสุดวันที่</span>
                <span class="dotted-line" style="width: 8%; text-align: center;">
                    {{ $fields['field_30'] ?? '' }}</span>
                <span>เดือน</span>
                <span class="dotted-line" style="width: 15%; text-align: center;">
                    {{ $fields['field_31'] ?? '' }}</span>
                <span>พ.ศ.</span>
                <span class="dotted-line" style="width: 15%; text-align: center;">
                    {{ $fields['field_32'] ?? '' }}</span>
            </span>
        </div>

        <div class="signature-section"
            style="display: flex; flex-direction: column; align-items: flex-end; gap: 2rem; margin-right: 5rem; margin-top:1rem; margin-bottom:1.5rem;">

            <div class="signature-item" style="text-align: right;">
                <span>(ลายมือชื่อ)</span>
                <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                    {{ $fields['field_33'] ?? '' }}
                </span>
                <div>
                    <span>(</span>
                    <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                        {{ $fields['field_33'] ?? '' }}
                    </span>
                    <span>)</span>
                </div>
                <span style=" margin-right:3.5rem;">เจ้าพนักงานท้องถิ่น</span>
            </div>

        </div>


</body>

</html>
