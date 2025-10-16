<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    public function trashLocation()
    {
        return $this->belongsTo(TrashLocation::class, 'trash_location_id');
    }
}
