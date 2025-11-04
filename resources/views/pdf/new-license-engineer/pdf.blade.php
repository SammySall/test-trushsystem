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
        <span>แบบ ข. ๔</span>
    </div>
    <div style="text-align: right; font-weight: bold;">
        <div style="border: 1px solid #000; padding: 0.5rem; display: inline-block; width: 25%; text-align: center;">
            <span>สำหรับเจ้าหน้าที่</span>
            <br>
            <span>เลขรับที่</span>
            <span class="dotted-line" style="width: 65%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
            <br>
            <span>วันที่</span>
            <span class="dotted-line" style="width: 75%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
            <br>
            <span>ลงชื่อ</span>
            <span class="dotted-line" style="width: 50%; text-align: center;">{{ $fields['field_99'] ?? '' }}</span>
            <span>ผู้รับคำขอ</span>
        </div>
    </div>

    <div class="title_doc">
        <div style="padding: 0.5rem; ">
            คำขอใบอนุญาตก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร
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

    <div class="box_text" style="text-align: left;">
        <span style="margin-left: 5rem;">ข้าพเจ้า</span>
        <span class="dotted-line" style="width: 40%; text-align: center;">
            {{ $fields['field_2'] ?? '-' }} {{ $fields['field_1'] ?? '-' }}
        </span>
        <span>เจ้าของอาคารหรือตัวแทนเจ้าของอาคาร</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span
            style="margin-left: 5rem;">[{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? '/' : ' ' }}]</span>
        <span>เป็นบุคคลธรรมดา </span>
        <span>เลขบัตรประชาชน</span>
        <span class="dotted-line" style="width: 20%; text-align: center;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_52'] : '-' }}</span>
        <span>อยู่บ้านเลขที่</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_8'] : '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 10%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_9'] : '-' }}</span>

        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_6'] : '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 18%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_7'] : '-' }}</span>
        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 18%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_10'] : '-' }}</span>
        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 18%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_11'] : '-' }}</span>

        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 20%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_12'] : '-' }}</span>
        <span>รหัสไปรษณีย์</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_53'] : '-' }}</span>
        <span>โทรศัพท์</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_13'] : '-' }}</span>
        <span>โทรสาร</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'individual' ? $fields['field_14'] : '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span
            style="margin-left: 5rem;">[{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? '/' : ' ' }}]</span>
        <span>เป็นนิติบุคคลประเภท </span>
        <span class="dotted-line" style="width: 15%; text-align: center;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_24'] : '-' }}</span>
        <span>จดทะเบียนเมื่อ</span>
        <span class="dotted-line" style="width: 15%; text-align: center;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_55'] : '-' }}</span>
        <span>เลขทะเบียน</span>
        <span class="dotted-line" style="width: 18%; text-align: center;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_66'] : '-' }}</span>

        <span>มีสำนักงานตั้งอยู่เลขที่</span>
        <span class="dotted-line" style="width: 5%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_56'] : '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 5%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_59'] : '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_57'] : '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_58'] : '-' }}</span>
        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_60'] : '-' }}</span>

        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_61'] : '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_62'] : '-' }}</span>
        <span>รหัสไปรษณีย์</span>
        <span class="dotted-line" style="width: 10%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_54'] : '-' }}</span>
        <span>โทรศัพท์</span>
        <span class="dotted-line" style="width: 10%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_63'] : '-' }}</span>
        <span>โทรสาร</span>
        <span class="dotted-line" style="width: 10%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_64'] : '-' }}</span>
    </div>
    <div class="box_text" style="text-align: left;">
        <span>โดยมี </span>
        <span class="dotted-line" style="width: 60%; text-align: center;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_65'] : '-' }}</span>
        <span>เป็นผู้มีอำนาจลงชื่อแทนนิติบุคคลผู้ขออนุญาต </span>
        <span>อยู่บ้านเลขที่</span>
        <span class="dotted-line" style="width: 5%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_8'] : '-' }}</span>
        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 5%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_9'] : '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_6'] : '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_7'] : '-' }}</span>
        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 18%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_10'] : '-' }}</span>

        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_11'] : '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 15%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_12'] : '-' }}</span>
        <span>รหัสไปรษณีย์</span>
        <span class="dotted-line" style="width: 10%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_53'] : '-' }}</span>
        <span>โทรศัพท์</span>
        <span class="dotted-line" style="width: 10%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_13'] : '-' }}</span>
        <span>โทรสาร</span>
        <span class="dotted-line" style="width: 10%;">{{ isset($fields['field_15']) && $fields['field_15'] === 'corporation' ? $fields['field_14'] : '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left: 5rem;">
        <span>ขอยื่นคำขอใบอนุญาตดังต่อไปนี้ต่อเจ้าพนักงานท้องถิ่น</span>
        <br>

        <span>({{ isset($fields['field_option']) && $fields['field_option'] == 1 ? '/' : ' ' }})</span>
        <span>ก่อสร้างอาคาร</span>
        <br>
        <span>({{ isset($fields['field_option']) && $fields['field_option'] == 2 ? '/' : ' ' }})</span>
        <span>ดัดแปลงอาคาร</span>
        <br>
        <span>({{ isset($fields['field_option']) && $fields['field_option'] == 3 ? '/' : ' ' }})</span>
        <span>รื้อถอนอาคาร</span>
        <br>
        <span>({{ isset($fields['field_option']) && $fields['field_option'] == 4 ? '/' : ' ' }})</span>
        <span>เคลื่อนย้ายอาคารในท้องที่ที่อยู่ในเขตอำนาจของเจ้าพนักงานท้องถิ่นที่อาคารจะทำการเคลื่อนย้ายตั้งอยู่</span>
        <br>
        <span>({{ isset($fields['field_option']) && $fields['field_option'] == 5 ? '/' : ' ' }})</span>
        <span>เคลื่อนย้ายอาคารไปยังท้องที่ที่อยู่ในเขตอำนาจของเจ้าพนักงานท้องถิ่นอื่น</span>
    </div>

    <div class="box_text" style="text-align: left; margin-bottom: 5rem">
        <span style="margin-left: 5rem">ข้อ ๑ อาคารที่ขอต่ออายุใบอนุญาตได้รับใบอนุญาต</span>
        <input type="checkbox" {{ isset($fields['field_option']) && $fields['field_option'] == 1 ? 'checked' : '' }}>
        <span>ก่อสร้างอาคาร</span>
        <input type="checkbox" {{ isset($fields['field_option']) && $fields['field_option'] == 2 ? 'checked' : '' }}>
        <span>ดัดแปลงอาคาร</span>
        <input type="checkbox" {{ isset($fields['field_option']) && $fields['field_option'] == 3 ? 'checked' : '' }}>
        <span>รื้อถอนอาคาร</span>
        <input type="checkbox" {{ isset($fields['field_option']) && $fields['field_option'] == 4 ? 'checked' : '' }}>
        <span>เคลื่อนย้ายอาคาร

            ตามใบอนุญาตเลขที่</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_67'] ?? '-' }}</span>
        <span>ลงวันที่</span>
        <span class="dotted-line" style="width: 5%; text-align: center;">{{ $fields['field_76'] ?? '-' }}</span>
        <span>เดือน</span>
        <span class="dotted-line" style="width: 15%; text-align: center;">{{$fields['field_77'] ?? '-' }}</span>
        <span>พ.ศ.</span>
        <span class="dotted-line" style="width: 10%; text-align: center;">{{$fields['field_78'] ?? '-' }}</span>
        <span>ที่เลขที่</span>
        <span class="dotted-line" style="width: 13%;">{{ $fields['field_69'] ?? '-' }}</span>

        <span>หมู่ที่</span>
        <span class="dotted-line" style="width: 13%;">{{ $fields['field_72'] ?? '-' }}</span>
        <span>ตรอก/ซอย</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_70'] ?? '-' }}</span>
        <span>ถนน</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_71'] ?? '-' }}</span>
        <span>ตำบล/แขวง</span>
        <span class="dotted-line" style="width: 25%;">{{ $fields['field_73'] ?? '-' }}</span>

        <span>อำเภอ/เขต</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_74'] ?? '-' }}</span>
        <span>จังหวัด</span>
        <span class="dotted-line" style="width: 18%;">{{ $fields['field_75'] ?? '-' }}</span>
        <span>โดยมี</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_79'] ?? '-' }}</span>
        <span>เป็นเจ้าของอาคารในที่ดิน</span>
        <br>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 1 ? 'checked' : '' }}>
        <span>โฉนดที่ดิน</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 2 ? 'checked' : '' }}>
        <span>น.ส. ๓</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 3 ? 'checked' : '' }}>
        <span>น.ส. ๓ ก</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 4 ? 'checked' : '' }}>
        <span>ส.ค.๑</span>
        <input type="checkbox" {{ isset($fields['field_80']) && $fields['field_80'] == 4 ? 'checked' : '' }}>
        <span>อื่น ๆ เลขที่</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_81'] ?? '-' }}</span>
        <span>เป็นที่ดินของ</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_82'] ?? '-' }}</span>
        <span>ใบอนุญาตสิ้นอายุวันที่</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_83'] ?? '-' }}</span>
        <span>เดือน</span>
        <span class="dotted-line" style="width: 13%;">{{ $fields['field_84'] ?? '-' }}</span>
        <span>พ.ศ.</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_85'] ?? '-' }}</span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span style="margin-left: 5rem">ข้อ ๒ เป็นอาคาร</span>
        <br>
        <span style="margin-left: 10rem">ชนิด</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_86'] ?? '-' }}</span>
        <span>จำนวน</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_87'] ?? '-' }}</span>
        <span>เพื่อใช้เป็น</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_88'] ?? '-' }}</span>
        <span>โดยมีที่จอดรถ ที่กลับรถ และทางเข้าออกของรถ จำนวน</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_89'] ?? '-' }}</span>
        <span>คัน </span>
    </div>

    <div class="box_text" style="text-align: left;">
        <span style="margin-left: 5rem">ข้อ ๓ เหตุที่ทำการไม่เสร็จตามที่ได้รับอนุญาต เนื่องจาก</span>
        <span class="dotted-line" style="width: 50%;">{{ $fields['field_90'] ?? '' }}</span>
        <br>
        <span>ขณะนี้ได้ดำเนินการไปแล้วถึง</span>
        <span class="dotted-line" style="width: 80%;">{{ $fields['field_91'] ?? '' }}</span>
        <span>จึงขอต่ออายุใบอนุญาตอีก</span>
        <span class="dotted-line" style="width: 10%;">{{ $fields['field_92'] ?? '' }}</span>
        <span>วัน โดยมี</span>
        <span class="dotted-line" style="width: 20%;">{{ $fields['field_93'] ?? '' }}</span>
        <span>เลขประจำตัวประชาชน</span>
        <span class="dotted-line" style="width: 15%;">{{ $fields['field_94'] ?? '' }}</span>
        <span>เป็นผู้ควบคุมงาน</span>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;">
        <span>ข้อ ๔ ข้าพเจ้าได้แนบเอกสารหลักฐานต่าง ๆ มาพร้อมกับคำขอนี้ด้วยแล้ว ดังนี้</span>
    </div>

    <div class="box_text" style="text-align: left;">

        <div style="margin-left:10rem;">
            <label>
                <input type="checkbox" {{ in_array('files1', $uploadedFiles ?? []) ? 'checked' : '' }}>
                (๑) สำเนาเอกสารแสดงการเป็นเจ้าของอาคาร
            </label>
        </div>

        <div style="margin-left:10rem;">
            <label>
                <input type="checkbox" {{ in_array('files2', $uploadedFiles ?? []) ? 'checked' : '' }}>
                (๒)หนังสือแสดงความเป็นตัวแทนของเจ้าของอาคาร (กรณีที่ตัวแทนเจ้าของอาคารเป็นผู้ขออนุญาต)

            </label>
        </div>

        <div style="margin-left:10rem;">
            <label>
                <input type="checkbox" {{ in_array('files3', $uploadedFiles ?? []) ? 'checked' : '' }}>
                (๓) สำเนาเอกสารแสดงการเป็นผู้ครอบครองอาคาร </label>
        </div>

        <div style="margin-left:10rem;">
            <label>
                <input type="checkbox" {{ in_array('files4', $uploadedFiles ?? []) ? 'checked' : '' }}>
                (๔) หนังสือแสดงว่าเป็นผู้จัดการหรือผู้แทนซึ่งเป็นผู้ดำเนินกิจการของนิติบุคคล
            </label>
        </div>

        <div style="margin-left:10rem;">
            <label>
                <input type="checkbox" {{ in_array('files5', $uploadedFiles ?? []) ? 'checked' : '' }}>
                (๕) ใบอนุญาตตามข้อ ๑
            </label>
        </div>

        <div style="margin-left:10rem;">
            <label>
                <input type="checkbox" {{ in_array('files6', $uploadedFiles ?? []) ? 'checked' : '' }}>
                (๖) หนังสือแสดงความยินยอมของผู้ควบคุมงาน
                ชื่อ
                <span class="dotted-line"
                    style="min-width: 50%;">{{ isset($fields['files6']) ? $fields['field_95'] : ' ' }}</span>
                เลขประจำตัวประชาชน
                <span class="dotted-line"
                    style="min-width: 20%;">{{ isset($fields['files6']) ? $fields['field_96'] : ' ' }}</span>
                <span>
                    และสำเนาใบอนุญาตเป็นผู้ประกอบวิชาชีพ สถาปัตยกรรมควบคุม
                    หรือวิชาชีพวิศวกรรมควบคุม(กรณีที่อาคารมีลักษณะหรือขนาดที่อยู่ในประเภทวิชาชีพสถาปัตยกรรมควบคุมหรือ
                    วิชาชีพวิศวกรรมควบคุมตาม กฎหมายว่าด้วยการนั้น แล้วแต่กรณี และมีความประสงค์จะยื่นพร้อมคำขออนุญาตนี้)
                </span>
            </label>
        </div>

        <div style="margin-left:10rem;">
            <label>
                <input type="checkbox" {{ in_array('files6', $uploadedFiles ?? []) ? 'checked' : '' }}>
                (๗) หนังสือรับรองการได้รับอนุญาตให้เป็นผู้ประกอบวิชาชีพสถาปัตยกรรมควบคุมหรือ
                ผู้ประกอบวิชาชีพวิศวกรรมควบคุม ที่ออกโดยสภาสถาปนิกหรือสภาวิศวกร แล้วแต่กรณี
            </label>
        </div>

        <div style="margin-left:10rem;">
            <label>
                <input type="checkbox" {{ in_array('files6', $uploadedFiles ?? []) ? 'checked' : '' }}>
                (๘) เอกสารอื่น ๆ
            </label>
        </div>
    </div>

    <div class="box_text" style="text-align: right; margin-top:0.5rem; margin-bottom:3rem;">
        <span>(ลายมือชื่อ)</span>
        <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_1'] ?? '' }}</span>
        <span>ผู้ขออนุญาต</span>
        <div style="margin-right: 3rem;">
            <span>(</span>
            <span class="dotted-line" style="width: 35%; text-align: center;">{{ $fields['field_2'] ?? '' }}
                {{ $fields['field_1'] ?? '' }}</span>
            <span>)</span>
        </div>
    </div>

    <div class="box_text" style="text-align: left; margin-left:5rem;">
        <span>หมายเหตุ ๑. ข้อความใดที่ไม่ต้องการให้ขีดฆ่า</span>
        <br>
        <span style="margin-left:3.2rem;">๒. ใส่เครื่องหมาย / ในช่อง [ ] หน้าข้อความที่ต้องการ</span>
        <br>
        <span style="margin-left:3.2rem;">๓. ในกรณีที่เป็นนิติบุคคล
            หากข้อบังคับกำหนดให้ต้องประทับตราให้ประทับตรานิติบุคคลด้วย</span>
    </div>
</body>

</html>
