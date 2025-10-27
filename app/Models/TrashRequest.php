<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix', 'fullname', 'age', 'nationality', 'tel', 'fax','id_card',
        'house_no', 'village_no', 'alley', 'road', 'subdistrict', 'district', 'province',
        'place_type', 'lat', 'lng', 'type', 'addon','note',
        'status', 'receiver_id', 'creator_id', 'received_at',
        'convenient_date', 'appointment_date'
    ];

    // ความสัมพันธ์กับผู้รับผิดชอบ
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // ความสัมพันธ์กับผู้สร้าง
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // ความสัมพันธ์กับประวัติการร้องขอ
    public function histories()
    {
        return $this->hasMany(TrashRequestHistory::class);
    }

    public function files()
    {
        return $this->hasMany(TrashRequestFile::class, 'trash_request_id', 'id');
    }

    public function trash_location()
    {
        return $this->belongsTo(TrashLocation::class, 'trash_location_id', 'id');
    }

    public function bill()
{
    return $this->hasOneThrough(
        Bill::class,          // Model ปลายทาง
        TrashLocation::class, // Model กลาง
        'id',                 // Local key ของ TrashLocation ที่ TrashRequest ใช้เชื่อม = trash_location_id? (ต้องตรวจสอบ)
        'trash_location_id',  // Foreign key ของ Bill ที่เชื่อม TrashLocation
        'trash_location_id',  // Local key ของ TrashRequest
        'id'                  // Local key ของ TrashLocation
    );
}

}
