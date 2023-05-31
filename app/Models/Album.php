<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use CrudTrait;
    use HasFactory;

    public function artists(){
        return $this->belongsTo(Artist::class);
    }

    public function songs(){
        return $this->hasMany(Song::class);
    }

    public function styles(){
        return $this->belongsTo(Style::class);
    }
}
