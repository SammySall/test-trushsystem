<?php

if (!function_exists('getTrashRequestTypeTitle')) {
    /**
     * แปลง slug type ของ TrashRequest เป็นชื่อเต็ม
     */
    function getTrashRequestTypeTitle(string $type): string
    {
        return match($type) {
            'new-license-engineer' => 'คำขอใบอนุญาตก่อสร้าง',
            'renew-license-engineer' => 'คำขอต่ออายุใบอนุญาตก่อสร้าง ดัดแปลง รื้อถอน หรือเคลื่อนย้ายอาคาร',
            'trash-request' => 'คำร้องขออนุญาตลงถังขยะ',
            'market-establishment-license' => 'คำขอรับใบอนุญาตจัดตั้งตลาด',
            'food-sales-license' => 'คำขอรับใบอนุญาตสถานที่จำหน่ายอาหาร',
            'health-hazard-license' => 'คำขอรับใบอนุญาตกิจการอันตรายต่อสุขภาพ',
            'waste-disposal-business-license' => 'คำขอรับใบอนุญาตประกอบกิจการรับทำการเก็บ ขน หรือกำจัดสิ่งปฏิกูลหรือมูลฝอย',
            default => 'ไม่พบข้อมูลประเภทใบอนุญาต',
        };
    }
}
