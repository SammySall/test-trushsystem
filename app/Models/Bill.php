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
        'slip_path',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'paid_date' => 'datetime',
    ];

    public function trashLocation()
    {
        return $this->belongsTo(TrashLocation::class, 'trash_location_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
