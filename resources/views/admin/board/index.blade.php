@extends("admin.index")

@section("title", "Board Members")

@section("content")
    <div class="container">
        <div class="filter-wrapper">
            <form method="GET" action="{{ route(Route::currentRouteName()) }}">
                <x-forms.input-field label="Zoek" name="search" value="{{ request('search') }}"/>
            </form>
            <a href="{{ route("admin.board.create") }}" class="button right">Voeg bestuur lid toe</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <td>naam</td>
                <td>rol</td>
                <td>foto</td>
                <td>acties</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($boardMembers as $boardMember)
                <tr>
                    <td>{{ $boardMember->name }}</td>
                    <td>{{ $boardMember->role }}</td>
                    <td><img src="{{ asset($boardMember->image_url) }}" width="50" height="50"></td>
                    <td>
                        <a href="{{ route("admin.board.show", ["id" => $boardMember->id]) }}">Bewerk</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $boardMembers->links() }}
        </div>
    </div>
@stop
