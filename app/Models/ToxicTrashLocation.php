<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToxicTrashLocation extends Model
{
    protected $fillable = ['name', 'lat', 'lng', 'active'];
}
