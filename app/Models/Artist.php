<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use CrudTrait;
    use HasFactory;

    public function albums(){
        return $this->hasMany(Album::class, 'artist_id');
    }
    public function artists(){
        return $this->hasMany(Artist::class);
    }
    public function songs(){
        return $this->hasMany(Song::class);
    }
    // public function styles(){
    //     return $this->hasOne(Style::class);
    // }
    public function styles(){
        return $this->belongsTo(Style::class, 'style_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'follow',
        'cover',
        'style_id',
        'created_at',
        'updated_at',
    ];
}
