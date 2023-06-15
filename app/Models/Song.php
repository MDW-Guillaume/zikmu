<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;




class Song extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'length',
        'position',
        'album_id',
        'song_file',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();
        // auto-sets values on creation
        static::creating(function ($query) {
            $song_slug = Str::slug($query->name);
            if ($query->song_file) {
                $filePath = $query->song_file->getPathname();
                $audio = new Mp3Info($filePath, true);
                $query->length = intval($audio->duration);

                $album_count_songs = Song::where('album_id', $query->album_id)->count();
                $album_count_songs++;
                $query->position = $album_count_songs;

                $album = Album::where('id', $query->album_id)->first();
                $artist = Artist::where('id', $album->artist_id)->first();
                $destinationPath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $album->slug . '/';

                $original_name = $query->song_file->getClientOriginalName();
                $filename = $song_slug . '.' . pathinfo($original_name, PATHINFO_EXTENSION);
                $query->song_file->move($destinationPath, $filename);

                unset($query->song_file);
            }else{
                $filename = $query->slug;

            }

            $query->slug = $filename;
        });

        static::updating(function ($query) {

            $album = Album::where('id', $query->original['album_id'])->first();
            $artist = Artist::where('id', $album->artist_id)->first();
            $destinationPath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $album->slug . '/';
            $originalPath = $destinationPath . $query->original['slug'];
            if (isset($query->song_file)) {
                $filePath = $query->song_file->getRealPath();

                if (file_get_contents($filePath) != file_get_contents($originalPath)) {
                    if ($query->name != $query->original['name']) {
                        $new_filename = $query->song_file->getClientOriginalName();
                        $extention = pathinfo($new_filename, PATHINFO_EXTENSION);
                        $query->slug = Str::slug($query->name) . '.' . $extention;
                    }

                    File::delete($originalPath);
                    $filename = $query->slug;
                    $query->song_file->move($destinationPath, $filename);
                }
            }
            if ($query->album_id != $query->original['album_id']) {
                $new_album = Album::where('id', $query->album_id)->first();
                $new_artist = Artist::where('id', $new_album->artist_id)->first();
                $new_songs_count = Song::where('album_id', $query->album_id)->count();
                $new_path = public_path('origin') . '/public/files/music/' . $new_artist->slug . '/' . $new_album->slug . '/' . $query->slug;

                $new_songs_count++;
                $query->position = $new_songs_count;

                File::copy($destinationPath . $query->slug, $new_path);

                File::delete($destinationPath . $query->slug);
            }
            unset($query->song_file);
        });
        // Gestion de la position complexe avec le changement d'album


        static::deleting(function ($query) {

            $album = Album::where('id', $query->album_id)->first();
            $artist = Artist::where('id', $album->artist_id)->first();
            $filepath = public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $album->slug . '/' . $query->slug;
            $songs = $songs = Song::where('album_id', $query->album_id)
                ->where('position', '>=', $query->position)
                ->orderBy('position')
                ->get();

            if ($songs->count() > 0) {
                foreach ($songs as $song) {
                    $song->decrement('position');
                }
            }

            File::delete($filepath);

            $all_favorites = SongsUser::where('song_id', $query->id)->get();

            foreach ($all_favorites as $favorite) {
                SongsUser::where('id', $favorite->id)->delete();
            }
        });
    }

    public function albums()
    {
        return $this->belongsTo(Album::class);
    }

    public function artists()
    {
        return $this->belongsTo(Artist::class);
    }
}
