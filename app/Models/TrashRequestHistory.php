<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashRequestHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'receiver_name',
        'status',
        'file',
        'reply_message',
        'reply_date'
    ];


    public function trashRequest()
    {
        return $this->belongsTo(TrashRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
