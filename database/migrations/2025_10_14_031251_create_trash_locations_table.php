<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ตรวจสอบว่าตาราง trash_locations มีอยู่หรือไม่
        if (Schema::hasTable('trash_locations')) {
            // ตารางมีอยู่แล้ว: เพิ่มคอลัมน์ tel ถ้าไม่มี
            if (!Schema::hasColumn('trash_locations', 'tel')) {
                Schema::table('trash_locations', function (Blueprint $table) {
                    $table->string('tel')->nullable()->after('status');
                });
            }

            // อัปเดตค่า tel ของทุกแถว
            DB::table('trash_locations')->update([
                'tel' => '0634461165'
            ]);

            // เปลี่ยนเป็น NOT NULL
            Schema::table('trash_locations', function (Blueprint $table) {
                $table->string('tel')->nullable(false)->change();
            });
        } else {
            // ตารางไม่มีอยู่: สร้างตารางใหม่
            Schema::create('trash_locations', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // ตัวอย่าง column อื่น ๆ ปรับตามจริง
                $table->string('status')->default('active');
                $table->string('tel')->default('0634461165'); // ใส่ค่าเริ่มต้น
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ลบคอลัมน์ tel ถ้าตารางมีอยู่
        if (Schema::hasTable('trash_locations') && Schema::hasColumn('trash_locations', 'tel')) {
            Schema::table('trash_locations', function (Blueprint $table) {
                $table->dropColumn('tel');
            });
        }
    }
};
