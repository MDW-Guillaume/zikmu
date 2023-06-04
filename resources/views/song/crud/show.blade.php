@extends('vendor.backpack.crud.show')

@section('content')
    @parent


    @php
        $song = App\Models\Song::where('id', $crud->entry->id)->first();
        $album = App\Models\Album::where('id', $song->album_id)->first();
        $artist = App\Models\Artist::where('id', $album->artist_id)->first();
    @endphp

    <h2 class="mt-5">Artiste associé : </h2>

    @if ($artist->count() > 0)
        <table class="table table-striped mb-0 col-md-8">
            <thead style="background-color: #fff;">
                <tr>
                    <td><i>ID</i></td>
                    <td><i>Nom</i></td>
                    <td><i>Follow</i></td>
                    <td><i>Actions</i></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $artist->id }}</td>
                    <td>{{ $artist->name }}</td>
                    <td>{{ $artist->follow }}</td>
                    <td>
                        <a href="/admin/artist/{{ $artist->id }}/show" class="btn btn-sm btn-link"><i class="la la-eye"></i>
                            Aperçu</a>
                        <a href="/admin/artist/{{ $artist->id }}/edit" class="btn btn-sm btn-link"><i class="la la-edit"></i>
                            Modifier</a>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    <h2 class="mt-5">Album associé : </h2>

    @if ($album->count() > 0)
        <table class="table table-striped mb-0 col-md-8">
            <thead style="background-color: #fff;">
                <tr>
                    <td><i>ID</i></td>
                    <td><i>Nom</i></td>
                    <td><i>Titres</i></td>
                    <td><i>Actions</i></td>
                </tr>
            </thead>
            <tbody>
                @php $nb_songs = App\Models\Song::where('album_id', $album->id)->count() @endphp
                <tr>
                    <td>
                        {{ $album->id }}
                    </td>
                    <td>
                        {{ $album->name }}
                    </td>
                    <td>
                        {{ $nb_songs }}
                    </td>
                    <td>
                        <a href="/admin/album/{{ $album->id }}/show" class="btn btn-sm btn-link"><i
                                class="la la-eye"></i> Aperçu</a>
                        <a href="/admin/album/{{ $album->id }}/edit" class="btn btn-sm btn-link"><i
                                class="la la-edit"></i>
                            Modifier</a>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
@endsection
