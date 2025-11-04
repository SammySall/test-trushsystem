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
            ใบอนุญาตประกอบกิจการตลาด
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
        </div>

        <div class="box_text" style="text-align: left; margin-left:5rem;">
            <span>อนุญาตให้ </span>
            <span class="dotted-line" style="width: 20%;">
                {{ $fields['field_2'] ?? '-' }} {{ $fields['field_1'] ?? '-' }}
            </span>
            <span>สัญชาติ</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_4'] ?? '-' }}</span>
            <span>อยู่บ้านเลขที่</span>
            <span class="dotted-line" style="width: 12%; text-align: center;">
                {{ $fields['field_8'] ?? '-' }}</span>
            <span>หมู่ที่</span>
            <span class="dotted-line" style="width: 12%;">{{ $fields['field_9'] ?? '-' }}</span>
        </div>


        <div class="box_text" style="text-align: left;">
            <span>ตรอก/ซอย</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_6'] ?? '-' }}</span>
            <span>ถนน</span>
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_7'] ?? '-' }}</span>
            <span>ตำบล/แขวง</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_10'] ?? '-' }}</span>
            <span>อำเภอ/เขต</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_11'] ?? '-' }}</span>
            <span>จังหวัด</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_12'] ?? '-' }}</span>
            <span>โทรศัพท์</span>
            <span class="dotted-line" style="width: 18%;">{{ $fields['field_13'] ?? '-' }}</span>
        </div>



        @php
            // แปลงเป็นตัวเลข (กันกรณี string)
            $isEvenOption = $option % 2 === 0; // true ถ้าเป็นคู่ (2, 4)
        @endphp
        <div class="box_text" style="text-align: left;">
            <span style="margin-left:5rem;">ข้อ ๑) ประกอบกิจการตลาดประเภทที่</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_99'] ?? '-' }}</span>
            <span>โดยใช้ชื่อตลาดว่า</span>
            <span class="dotted-line" style="width: 20%; text-align: center;">
                {{ $fields['field_99'] ?? '' }}</span>
            <span>ตั้งอยู่บ้านเลขที่</span>
            <span class="dotted-line" style="width: 12%; text-align: center;">
                {{ $fields['field_36'] ?? '-' }}</span>
            <span>หมู่ที่</span>
            <span class="dotted-line" style="width: 5%; text-align: center;">
                {{ $fields['field_39'] ?? '-' }}</span>
            <span>ตรอก/ซอย</span>
            <span class="dotted-line" style="width: 12%; text-align: center;">
                {{ $fields['field_37'] ?? '' }}</span>
            <span>ถนน</span>
            <span class="dotted-line" style="width: 12%; text-align: center;">
                {{ $fields['field_38'] ?? '-' }}</span>
            <span>ตำบล/แขวง</span>
            <span class="dotted-line" style="width: 12%;">{{ $fields['field_42'] ?? '-' }}</span>
            <span>อำเภอ/เขต</span>
            <span class="dotted-line" style="width: 18%;">{{ $fields['field_43'] ?? '-' }}</span>
            <span>จังหวัด</span>
            <span class="dotted-line" style="width: 18%;">{{ $fields['field_44'] ?? '-' }}</span>
            <span>โทรศัพท์</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_45'] ?? '-' }}</span>
            <span>โทรสาร</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_35'] ?? '-' }}</span>
            <span>มีพื้นที่ประกอบการ</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>
            <span>ตารางเมตร มีจำนวนแผงในตลาด</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>
            <span>แผง ทั้งนี้ได้เสียค่าธรรมเนียม ใบอนุญาต</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_16'] ?? '-' }}</span>
            <span>บาท (</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>
            <span>) ใบเสร็จรับเงินเล่มที่</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>
            <span>เลขที่</span>
            <span class="dotted-line" style="width: 15%;">{{ $fields['field_99'] ?? '-' }}</span>
            <span>ลงวันที่</span>
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
            <span style="margin-left:5rem;">ข้อ ๒) ผู้ได้รับอนุญาตต้องปฏิบัติตามสุขลักษณะที่กำหนดไว้ในกฎกระทรวง ฉบับที่
                ๔ (พ.ศ. ๒๕๔๒) หรือ
                ข้อกำหนดท้องถิ่น (เทศบัญญัติ)</span>
        </div>

        <div class="box_text" style="text-align: left;">
            <span style="margin-left:5rem;">ข้อ ๓) ผู้ได้รับอนุญาตต้องปฏิบัติตามเงื่อนไข ดังต่อไปนี้
            </span>
            <br>
            <span style="margin-left:10rem;">๓.๑ </span>
            <span class="dotted-line" style="width: 40%; text-align: center;">
                {{ $fields['field_99'] ?? '-' }}</span>
            <br>
            <span style="margin-left:10rem;">๓.๒ </span>
            <span class="dotted-line" style="width: 40%; text-align: center;">
                {{ $fields['field_99'] ?? '-' }}</span>
            <br>
            <span style="margin-left:10rem;">๓.๓ </span>
            <span class="dotted-line" style="width: 40%; text-align: center;">
                {{ $fields['field_99'] ?? '-' }}</span>
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

        <div class="signature-section"
            style="display: flex; flex-direction: column; align-items: flex-end; gap: 2rem; margin-right: 5rem; margin-top:1rem; margin-bottom:1.5rem;">

            <div class="signature-item" style="text-align: right;">
                <span>(ลายมือชื่อ)</span>
                <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                    {{ $fields['field_33'] ? 'สมจิตร์ พันธุ์สุวรรณ' : '' }}
                </span>
                <div>
                    <span>(</span>
                    <span style="width: 35%; display: inline-block; text-align: center;">
                        นางสมจิตร์ พันธุ์สุวรรณ
                    </span>
                    <span>)</span>
                </div>
                <span>ตำแหน่ง</span>
                <span style="width: 35%; display: inline-block; text-align: center; ">
                    นายกเทศมนตรีตำบลท่าข้าม
                </span>
            </div>

            <div class="box_text" style="text-align: left; margin-left:5rem;">
                <span>คำเตือน ต้องแสดงใบอนุญาตนี้ไว้ในที่เปิดเผย ณ สถานที่ที่ได้รับอนุญาตให้ประกอบกิจการ</span>
            </div>
        </div>


</body>

</html>
