@extends('vendor.backpack.crud.show')

@section('content')
    @parent

    <h2 class="mt-5">Titres associés : </h2>

    @php
        $songs = App\Models\Song::where('album_id', $crud->entry->id)->get();
    @endphp

    @if ($songs->count() > 0)
        <table class="table table-striped mb-0">
            <thead style="background-color: #fff;">
                <tr>
                    <td><i>ID</i></td>
                    <td><i>Nom</i></td>
                    <td><i>Slug</i></td>
                    <td><i>Position</i></td>
                    <td><i>Actions</i></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($songs as $song)
                    <tr>
                        <td>
                            {{ $song->id }}
                        </td>
                        <td>
                            {{ $song->name }}
                        </td>
                        <td>
                            {{ $song->slug }}
                        </td>
                        <td>
                            {{ $song->position }}
                        </td>
                        <td>
                            <a href="/admin/song/{{ $song->id }}/show" class="btn btn-sm btn-link"><i
                                    class="la la-eye"></i> Aperçu</a>
                            <a href="/admin/song/{{ $song->id }}/edit" class="btn btn-sm btn-link"><i
                                    class="la la-edit"></i>
                                Modifier</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <h3 class="mt-3">Album vide</h3>
    @endif
@endsection
