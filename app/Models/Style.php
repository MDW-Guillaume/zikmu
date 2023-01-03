<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;

    public function albums() {
        return $this->hasMany(Album::class);
    }

    public function artists() {
        return $this->hasMany(Artist::class);
    }
}
