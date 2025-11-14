<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('toxic_trash_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        DB::table('toxic_trash_locations')->insert([
            ['name' => 'ม.1', 'lat' => 13.487003, 'lng' => 100.996010, 'active' => 1],
            ['name' => 'ม.2', 'lat' => 13.487003, 'lng' => 100.996010, 'active' => 1],
            ['name' => 'ม.3', 'lat' => 13.486961, 'lng' => 100.996051, 'active' => 1],
            ['name' => 'ม.6', 'lat' => 13.490176, 'lng' => 101.018473, 'active' => 1],
            ['name' => 'ม.7', 'lat' => 13.506529, 'lng' => 101.032932, 'active' => 1],
            ['name' => 'ม.5', 'lat' => 13.474611, 'lng' => 101.007072, 'active' => 1],
            ['name' => 'ม.8', 'lat' => 13.464466, 'lng' => 100.992700, 'active' => 1],
            ['name' => 'ม.4', 'lat' => 13.480000, 'lng' => 101.000000, 'active' => 1], // ไม่มีลิงก์จึงใช้พิกัดกลาง
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('toxic_trash_locations');
    }
};
