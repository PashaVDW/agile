@extends("admin.index")

@section("title", "Commissies")

@section("content")
    <div class="container">
        <div class="filter-wrapper">
            <form method="GET" action="{{ route(Route::currentRouteName()) }}">
                <x-filters.search-bar label="Zoeken" placeholder="Zoeken..." :params="$bindings"/>
            </form>
            <a href="{{ route("admin.commission.create") }}" class="button right">Voeg commissie toe</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <td>Naam</td>
                <td>Omschrijving</td>
                <td>Acties</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($commissions as $commission)
                <tr>
                    <td>{{ $commission->name }}</td>
                    <td>{{ $commission->description }}</td>
                    <td>
                        <a href="{{ route("admin.commission.show", ["id" => $commission->id]) }}">Bewerk</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $commissions->links() }}
        </div>
    </div>
@stop
