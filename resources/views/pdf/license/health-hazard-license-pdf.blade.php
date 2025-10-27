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
        <div style="text-align: right">แบบ อภ.2<br>
        </div>
    </div>
    <div style="margin-top: 15%">
        {{-- <img src="{{ public_path('img/menuuser/LOGO.png') }}" alt="LOGO" style="width:150px; margin-bottom:10px;"> --}}
        <div class="title_doc">ใบอนุญาต<br>
            ประกอบกิจการที่เป็นอันตรายต่อสุขภาพ</div>
    </div>

    <div class="box_text" style="text-align: left;">
        <span>เล่มที่
            <span class="dotted-line" style="width: 15%; text-align: center;">
                {{ $fields['field_20'] ?? '-' }}</span>
            เลขที่ <span class="dotted-line" style="width: 10%; text-align: center;">
                {{ $fields['field_20'] ?? '-' }}</span>
            ปี <span class="dotted-line" style="width: 10%; text-align: center;">
                {{ $fields['field_20'] ?? '-' }}</span></span>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;">
        <span>อนุญาตให้ บุคคลธรรมดา นิติบุคคล ชื่อ</span>
        <span class="dotted-line" style="width: 35%;">{{ $fields['field_2'] ?? '-' }}
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>อายุ</span>
        <span class="dotted-line" style="width: 15%; text-align: center;">
            {{ $fields['field_3'] ?? '-' }}</span>
        <span>ปี</span>
    </div>

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
        <span>โทรสาร</span>
        <span class="dotted-line" style="width: 28%;">{{ $fields['field_14'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span style="margin-left:5rem;">ข้อ 1 ประกอบกิจการที่เป็นอันตรายต่อสุขภาพ ประเภท</span>
        <span class="dotted-line" style="width: 45%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>ลำดับที่</span>
        <span class="dotted-line" style="width: 20%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>ค่าธรรมเนียม</span>
        <span class="dotted-line" style="width: 20%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>บาท ใบเสร็จรับเงินเล่มที่</span>
        <span class="dotted-line" style="width: 20%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>เลขที่</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>ลงวันที่</span>
        <span class="dotted-line" style="width: 15%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>เดือน</span>
        <span class="dotted-line" style="width: 20%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>พ.ศ.</span>
        <span class="dotted-line" style="width: 15%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>โดยใช้ชื่อ <br>
            สถานประกอบการว่า</span>
        <span class="dotted-line" style="width: 32%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>พื้นที่ประกอบการ</span>
        <span class="dotted-line" style="width: 24%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span> ตารางเมตร</span>
        <br>
        <span> กำลังเครื่องจักร</span>
        <span class="dotted-line" style="width: 25%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span> แรงม้า</span>
        <span> จำนวนคนงาน</span>
        <span class="dotted-line" style="width: 25%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span> คน ตั้งอยู่ ณ เลขที่</span>
        <span class="dotted-line" style="width: 23%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_6'] ?? '-' }}</span>
        <span>ครอก/ซอย</span>
        <span class="dotted-line" style="width: 23%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 23%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span>ตำบล</span>
        <span class="dotted-line" style="width: 27%;">{{ $fields['field_7'] ?? '-' }}</span>
        <span>อำเภอ</span>
        <span class="dotted-line" style="width: 27%;">{{ $fields['field_8'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 27%;">{{ $fields['field_9'] ?? '-' }}</span>
        <span>โทรศัพท์</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_4'] ?? '-' }}</span>
        <span>โทรสาร</span>
        <span class="dotted-line" style="width: 28%;">{{ $fields['field_15'] ?? '00' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span style="margin-left:5rem;">ข้อ 2 ผู้ได้รับใบอนุญาตต้องปฏิบัติตามเงื่อนไขโดนเฉพาะ ดังต่อไปนี้</span>
        <br>
        <span style="margin-left:7rem;">(1)</span>
        <span class="dotted-line" style="width: 80%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span style="margin-left:7rem;">(2)</span>
        <span class="dotted-line" style="width: 80%; text-align: center;">
            {{ $fields['field_1'] ?? '-' }}</span>
        <span style="margin-left:5rem;">ใบอนุญาตฉบับนี้ให้ใช้ได้จนถึงวันที่</span>
        <span class="dotted-line" style="width: 16%; text-align: center;">
            {{ $fields['field_24'] ?? '' }}</span>
        <span>เดือน</span>
        <span class="dotted-line" style="width: 16%; text-align: center;">
            {{ $fields['field_25'] ?? '' }}</span>
        <span>พ.ศ.</span>
        <span class="dotted-line" style="width: 16%; text-align: center;">
            {{ $fields['field_26'] ?? '' }}</span>
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
                {{ $fields['field_31'] ?? '' }}
            </span>
            <div>
                <span>(</span>
                <span class="dotted-line" style="width: 35%; display: inline-block; text-align: center;">
                    {{ $fields['field_30'] ?? '' }} {{ $fields['field_31'] ?? '' }}
                </span>
                <span>)</span>
            </div>
            <span style=" margin-right:3.5rem;">เจ้าพนักงานท้องถิ่น</span>
        </div>

    </div>


</body>

</html>
