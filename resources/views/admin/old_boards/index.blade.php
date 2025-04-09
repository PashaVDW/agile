@extends("admin.index")

@section("title", "Oude Besturen")

@section("content")
    <div class="container">
        <div class="filter-wrapper">
            <form method="GET" action="{{ route(Route::currentRouteName()) }}">
                <x-filters.search-bar label="Zoeken" placeholder="Zoeken..." :params="$bindings"/>
            </form>
            <a href="{{ route("admin.old_boards.create") }}" class="button right">Voeg oud bestuur toe</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <td>Namen</td>
                <td>Termijn</td>
                <td>Foto</td>
                <td>Acties</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($oldBoards as $oldBoard)
                <tr>
                    <td>{{ $oldBoard->names }}</td>
                    <td>{{ $oldBoard->term }}</td>
                    <td><img src="{{ asset($oldBoard->image_url) }}" width="50" height="50"></td>
                    <td>
                        <a href="{{ route("admin.old_boards.show", ["id" => $oldBoard->id]) }}">Bewerk</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $oldBoards->links() }}
        </div>
    </div>
@stop
