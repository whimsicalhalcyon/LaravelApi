<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Reply extends Model
{
    protected $fillable = [
        'title', 'message', 'email_reply', 'UserID'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }


}
