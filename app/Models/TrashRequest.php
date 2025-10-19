<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashRequest extends Model
{
    use HasFactory;

    protected $fillable = [
    'prefix', 'fullname', 'age', 'nationality', 'tel', 'fax',
    'house_no', 'village_no', 'subdistrict', 'district', 'province',
    'place_type', 'lat', 'lng',
    'picture_path', 'status', 'receiver_id', 'received_at',
];


    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function histories()
    {
        return $this->hasMany(TrashRequestHistory::class);
    }
}
