<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistsUser extends Model
{
    use HasFactory;

    public function users() {
        return $this->hasMany(User::class);
    }

    public function artists() {
        return $this->hasMany(Album::class);
    }
    public function artistUsers() {
        return $this->hasMany(ArtistUser::class, 'artist_id')->onDelete('cascade');
    }
}
