<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorsUrl extends Model
{
    protected $fillable = ['url'];

    public function scopeActive($query) {
        return $query->where('active', );
    }
}
