<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trash_requests', function (Blueprint $table) {
            $table->id();
            $table->string('prefix');
            $table->string('type');
            $table->string('fullname');
            $table->integer('age')->nullable();
            $table->string('nationality')->nullable();
            $table->string('tel');
            $table->string('fax')->nullable();
            $table->string('house_no');
            $table->string('village_no')->nullable();
            $table->string('alley')->nullable();
            $table->string('road')->nullable();
            $table->string('subdistrict');
            $table->string('district');
            $table->string('province');
            $table->string('place_type')->nullable(); // 1-5 ตาม radio
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->text('addon')->nullable();
            $table->string('note')->nullable();
            $table->text('id_card')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('receiver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('creator_id')->nullable()->constrained('users')->nullOnDelete(); // เพิ่ม create_id
            $table->timestamp('received_at')->nullable();
            $table->datetime('convenient_date')->nullable();
            $table->datetime('appointment_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_requests');
    }
};
