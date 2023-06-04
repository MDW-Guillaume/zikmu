<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class Artist extends Model
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
        'follow',
        'cover',
        'style_id',
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
            while (Artist::where('slug', $query->slug)->count() > 0) {
                $query->slug = Str::slug($query->name) . '-' . $i;
                $i++;
            }
            $destinationPath = public_path('origin') . '/public/files/music/' . $query->slug . '/';
            $filename = $query->cover->getClientOriginalName();
            $filename = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . '.' . pathinfo($filename, PATHINFO_EXTENSION);
            $query->cover->move($destinationPath, $filename);

            $query->cover = $filename;


            if (!isset($query->follow)) {
                $query->follow = 0;
            }
        });

        static::updating(function ($query) {

            $oldArtist = Artist::where('id', $query->id)->first();
            // dd($query->cover->getClientOriginalName());

            $destinationPath = public_path('origin') . '/public/files/music/' . $oldArtist->slug . '/';

            // Supprimer l'ancienne couverture
            File::delete($destinationPath . $oldArtist->cover);

            // Déplacer le fichier vers le nouvel emplacement
            $filename = $query->cover->getClientOriginalName();
            $filename = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . '.' . pathinfo($filename, PATHINFO_EXTENSION);
            $query->cover->move($destinationPath, $filename);

            // Mettre à jour la valeur de la colonne 'cover'
            $query->cover = $filename;
        });

        static::deleting(function ($query) {
            // $destinationPath = public_path('origin') . '/public/files/music/' . $query->slug;
            // $albums = Album::where('artist_id', $query->id)->get();

            // $all_artist_favorites = ArtistsUser::where('artist_id', $query->id)->get();


            // foreach ($all_artist_favorites as $artist_favorite) {
            //     $artist_favorite->delete();
            // }

            // foreach ($albums as $album) {
            //     $all_albums_favorites = AlbumsUser::where('album_id', $album->id)->get();
            //     foreach ($all_albums_favorites as $albums_favorites) {
            //         $albums_favorites->delete();
            //     }

            //     $all_album_songs = Song::where('album_id', $album->id)->get();

            //     foreach($all_album_songs as $album_song){
            //         $all_songs_favorites = SongsUser::where('song_id', $album_song->id)->get();
            //         foreach ($all_songs_favorites as $songs_favorites) {
            //             $songs_favorites->delete();
            //         }
            //     }
            // }


            // foreach ($albums as $album) {
            //     $all_songs = Song::where('album_id', $album->id)->get();
            //     foreach ($all_songs as $song) {
            //         Song::where('id', $song->id)->delete();
            //     }
            //     Album::where('id', $album->id)->delete();
            // }

            // File::deleteDirectory($destinationPath);

            $destinationPath = public_path('origin') . '/public/files/music/' . $query->slug;

            $all_artist_favorites = ArtistsUser::where('artist_id', $query->id)->get();
            foreach ($all_artist_favorites as $artist_favorite) {
                $artist_favorite->delete();
            }

            $albums = Album::where('artist_id', $query->id)->get();
            foreach ($albums as $album) {
                $all_albums_favorites = AlbumsUser::where('album_id', $album->id)->get();
                foreach ($all_albums_favorites as $albums_favorites) {
                    $albums_favorites->delete();
                }

                $all_album_songs = Song::where('album_id', $album->id)->get();
                foreach ($all_album_songs as $album_song) {
                    $all_songs_favorites = SongsUser::where('song_id', $album_song->id)->get();
                    foreach ($all_songs_favorites as $songs_favorites) {
                        $songs_favorites->delete();
                    }
                }

                $all_songs = Song::where('album_id', $album->id)->get();
                foreach ($all_songs as $song) {
                    $song->delete();
                }

                $album->delete();
            }

            File::deleteDirectory($destinationPath);
        });
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'artist_id');
    }
    public function artists()
    {
        return $this->hasMany(Artist::class);
    }
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
    // public function styles(){
    //     return $this->hasOne(Style::class);
    // }
    public function styles()
    {
        return $this->belongsTo(Style::class, 'style_id');
    }

    // public function setNameAttribute($value)
    // {
    // }

    // public function setCoverAttribute($value)
    // {
    //     // dd($value->getClientOriginalName());
    //     $oldCover = $this->getOriginal('cover');
    //     $destinationPath = public_path('origin') . '/public/files/music/' . $this->attributes['slug'] . '/';

    //     // Supprimer l'ancienne couverture
    //     File::delete($destinationPath . $oldCover);

    //     // Déplacer le fichier vers le nouvel emplacement
    //     $filename = $value->getClientOriginalName();
    //     $value->move($destinationPath, $filename);

    //     // Mettre à jour la valeur de la colonne 'cover'
    //     $this->attributes['cover'] = $filename;
    // }
}
