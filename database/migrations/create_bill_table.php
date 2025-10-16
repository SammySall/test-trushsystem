<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trash_location_id')
                ->constrained('trash_locations')
                ->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['ยังไม่ชำระ', 'รอการตรวจสอบ', 'ชำระแล้ว'])->default('ยังไม่ชำระ');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->timestamps();
        });

        // ✅ ใส่ข้อมูลตัวอย่างตาม laravel_bills.sql
        DB::table('bills')->insert([
            [
                'id' => 1,
                'trash_location_id' => 1,
                'amount' => 2000.00,
                'status' => 'ยังไม่ชำระ',
                'due_date' => '2025-10-28',
                'paid_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
