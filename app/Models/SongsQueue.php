<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongsQueue extends Model
{
    use HasFactory;


    public function users() {
        return $this->hasMany(User::class);
    }

    public function songs() {
        return $this->hasMany(Song::class);
    }

    protected $fillable = ['user_id', 'song_id', 'position'];
}
