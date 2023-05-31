<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use CrudTrait;
    use HasFactory;

    public function albums() {
        return $this->belongsTo(Album::class);
    }

    public function artists() {
        return $this->belongsTo(Artist::class);
    }



}
