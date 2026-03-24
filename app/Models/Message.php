<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'title', 'message', 'name_file', 'email', 'status'
    ];

    public function replies() {
        return $this->hasMany(Reply::class);
    }
}
