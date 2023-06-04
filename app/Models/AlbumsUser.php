<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumsUser extends Model
{
    use HasFactory;

    public function users() {
        return $this->hasMany(User::class);
    }

    public function albums() {
        return $this->hasMany(Album::class);
    }
}
