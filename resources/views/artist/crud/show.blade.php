@extends('vendor.backpack.crud.show')

@section('content')
    @parent

    <h2 class="mt-5">Albums associés : </h2>

    @php
        $albums = App\Models\Album::where('artist_id', $crud->entry->id)->get();
    @endphp

    @if ($albums->count() > 0)
        <table class="table table-striped mb-0">
            <thead style="background-color: #fff;">
                <tr>
                    <td><i>ID</i></td>
                    <td><i>Nom</i></td>
                    <td><i>Titres</i></td>
                    <td><i>Actions</i></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($albums as $album)
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
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
