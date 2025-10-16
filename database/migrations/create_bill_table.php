<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ตรวจสอบว่าตาราง trash_locations มีอยู่ก่อน
        if (!Schema::hasTable('trash_locations')) {
            // สร้างตาราง trash_locations ตัวอย่าง (ปรับตามจริง)
            Schema::create('trash_locations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('status')->default('active');
                $table->timestamps();
            });
        }

        // สร้างตาราง bills
        Schema::create('bills', function (Blueprint $table) {
            $table->id(); // id สำหรับลำดับ
            $table->foreignId('trash_location_id')
                  ->constrained('trash_locations')
                  ->onDelete('cascade'); // เชื่อมกับ trash_locations

            $table->decimal('amount', 10, 2); // จำนวนเงิน
            $table->enum('status', ['ยังไม่ชำระ','รอการตรวจสอบ', 'ชำระแล้ว'])->default('ยังไม่ชำระ'); // สถานะ
            $table->date('due_date'); // วันที่ครบกำหนด
            $table->date('paid_date')->nullable(); // วันที่ชำระ เป็น NULL ได้

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
