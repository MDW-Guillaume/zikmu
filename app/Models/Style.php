<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Style extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();
        // auto-sets values on creation
        static::creating(function ($query) {
            $query->slug = Str::slug($query->name);
        });

        static::updating(function ($query) {
            $query->slug = Str::slug($query->name);
        });
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function artists()
    {
        return $this->hasMany(Artist::class, 'style_id');
    }
}
