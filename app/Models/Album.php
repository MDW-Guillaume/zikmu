<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;




class Album extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'cover',
        'length',
        'release',
        'artist_id',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();
        // auto-sets values on creation
        static::creating(function ($query) {

            $query->slug = Str::slug($query->name);
            $i = 2;
            while (Album::where('slug', $query->slug)->count() > 0) {
                $query->slug = Str::slug($query->name) . '-' . $i;
                $i++;
            }

            if (isset($query->cover)) {
                $artist = Artist::where('id', $query->artist_id)->first();

                $destinationPath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $query->slug;
                if(gettype($query->cover) != 'string'){
                    $filename = $query->cover->getClientOriginalName();
                    $filename = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . '.' . pathinfo($filename, PATHINFO_EXTENSION);
                    $query->cover->move($destinationPath, $filename);
                    $query->cover = $filename;
                    $query->length = 0;
                }
            }
        });

        static::updating(function ($query) {


            $album = Album::where('id', $query->id)->first();
            $artist = Artist::where('id', $album->artist_id)->first();
            $destinationPath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $album->slug . '/';

            // Vérification si la cover est modifiée
            if ($query->cover) {
                // Supprimer l'ancienne couverture
                File::delete($destinationPath . $album->cover);

                // Déplacer le fichier vers le nouvel emplacement
                $filename = $query->cover->getClientOriginalName();
                $filename = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . '.' . pathinfo($filename, PATHINFO_EXTENSION);
                $query->cover->move($destinationPath, $filename);

                // Mettre à jour la valeur de la colonne 'cover'
                $query->cover = $filename;
            } else {
                // Supprimer l'ancienne couverture
                File::delete($destinationPath . $album->cover);

                // Mettre à jour la valeur de la colonne 'cover'
                $query->cover = null;
            }

            if ($artist->id != $query->artist_id) {
                $new_artist = Artist::where('id', $query->artist_id)->first();
                $new_path = public_path('origin') . '/public/files/music/' . $new_artist->slug . '/' . $album->slug . '/';

                File::copyDirectory($destinationPath, $new_path);

                File::deleteDirectory($destinationPath);
            }
        });

        static::deleting(function ($query) {
            $album = Album::where('id', $query->id)->first();
            $artist = Artist::where('id', $album->artist_id)->first();
            $destinationPath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $album->slug;

            File::deleteDirectory($destinationPath);

            $all_album_songs = Song::where('album_id', $query->id)->get();
            foreach ($all_album_songs as $album_song) {
                $all_favorites = SongsUser::where('song_id', $album_song->id)->get();
                foreach ($all_favorites as $favorite) {
                    SongsUser::where('id', $favorite->id)->delete();
                }
                AlbumsUser::where('album_id', $album_song->album_id)->delete();
            }

            $all_songs = Song::where('album_id', $query->id)->get();
            foreach ($all_songs as $song) {
                Song::where('id', $song->id)->delete();
            }

            Album::where('id', $query->id)->delete();
        });
    }

    public function artists()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function styles()
    {
        return $this->belongsTo(Style::class);
    }

    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = $value;
    //     $this->attributes['slug'] = Str::slug($value);
    // }

    // public function setLengthAttribute($value)
    // {
    //     $this->attributes['length'] = $value;
    // }

    // public function setReleaseAttribute($value)
    // {
    //     $this->attributes['release'] = $value;
    // }

    // // Modification du fichier de cover
    // public function setArtistIdAttribute($value)
    // {
    //     if (isset($this->attributes['artist_id'])) {

    //         $oldCover = $this->getOriginal('slug');
    //         $artist = Artist::where('id', $this->attributes['artist_id'])->first();

    //         // dd( $value);
    //         $new_artist = Artist::where('id', $value)->first();
    //         // dd(public_path('origin') . '/public/files/music/' . $new_artist->slug . '/' . $this->attributes['slug']);
    //         $destinationPath = public_path('origin') . '/public/files/music/' . $new_artist->slug . '/' . $this->attributes['slug'];
    //         $sourcePath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $this->attributes['slug'];

    //         File::copyDirectory($sourcePath, $destinationPath);

    //         File::deleteDirectory($sourcePath);

    //         // Mettre à jour la valeur de la colonne 'cover'
    //         $this->attributes['artist_id'] = $value;
    //     } else {
    //         $artist = Artist::where('id', $value)->first();

    //         $destinationPath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $this->attributes['slug'];
    //         if (!File::exists($destinationPath)) {
    //             File::makeDirectory($destinationPath, 0777, true);
    //             var_dump("Répertoire créé avec succès.");
    //             // Mettre à jour la valeur de la colonne 'cover'
    //             $this->attributes['artist_id'] = $value;
    //         } else {
    //             var_dump("Le répertoire existe déjà.");
    //         }
    //     }
    // }

    // // Modification du fichier de cover
    // public function setCoverAttribute($value)
    // {
    //     // dd(isset($this->attributes['artist_id']));
    //     $artist_id = $this->attributes['artist_id'];
    //     $artist = Artist::where('id', $artist_id)->first();
    //     // dd($artist->slug);
    //     $destinationPath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $this->attributes['slug'] . '/';
    //     if (!is_null($this->getOriginal('cover'))) {
    //         $oldCover = $this->getOriginal('cover');

    //         // Supprimer l'ancienne couverture
    //         File::delete($destinationPath . $oldCover);
    //     }
    //     // Déplacer le fichier vers le nouvel emplacement
    //     $filename = $value->getClientOriginalName();
    //     $value->move($destinationPath, $filename);
    //     // Mettre à jour la valeur de la colonne 'cover'
    //     $this->attributes['cover'] = $filename;
    // }
}
