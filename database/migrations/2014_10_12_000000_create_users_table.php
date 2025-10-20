<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address');
            $table->enum('role', ['admin-trash', 'admin-e-service','admin-emergency', 'user','admin-request'])->default('user');
            $table->rememberToken();
            $table->timestamps();
            $table->text('api_token')->nullable();
        });

        DB::table('users')->insert([
            [
                'name' => 'Admin Trash',
                'email' => 'admin02@example.com',
                'password' => Hash::make('123456789'),
                'address' => '123/45',
                'role' => 'admin-trash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin E-Service',
                'email' => 'admin01@example.com',
                'password' => Hash::make('123456789'),
                'address' => '67/78',
                'role' => 'admin-e-service',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Admin Emergency',
                'email' => 'admin03@example.com',
                'password' => Hash::make('123456789'),
                'address' => '67/78',
                'role' => 'admin-emergency',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Request',
                'email' => 'admin04@example.com',
                'password' => Hash::make('123456789'),
                'address' => '67/78',
                'role' => 'admin-request',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'นายเก้า อดิศร',
                'email' => 'users01@example.com',
                'password' => Hash::make('123456789'),
                'address' => '123 หมู่ 5',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
