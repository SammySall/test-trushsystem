<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'trash_location_id',
        'user_id',
        'amount',
        'status',
        'due_date',
        'paid_date',
        'slip_path', // เพิ่มตรงนี้
    ];

    public function trashLocation()
    {
        return $this->belongsTo(TrashLocation::class, 'trash_location_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
