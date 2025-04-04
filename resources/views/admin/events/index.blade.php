@extends("admin.index")

@section("title", "Events")

@section("content")
    <div class="container">
        <div class="filter-wrapper">
            <x-filters.dropdown :onchange="'this.form.submit()'" label="Status" default="Alle statussen" name="status" enum="{{\App\Enums\ActiveTypeEnum::class}}" value="{{ request('status') }}" :params="$bindings"/>
            <x-filters.search-bar label="Zoeken" placeholder="Zoeken..." :params="$bindings"/>
            <a href="{{ route("admin.event.create") }}" class="button right">Event aanmaken</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <td>Titel</td>
                    <td>Datum / Start datum</td>
                    <td>Categorie</td>
                    <td>Aangemaakt op</td>
                    <td>Bijgewerkt op</td>
                    <td>Acties</td>
                </tr>
            </thead>
            <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ Str::of($event->title)->words(5, '...') }} <span>{{ $event->status->name === 'ARCHIVED' ? '(' . __("ARCHIVED") . ')' : "" }}</span></td>
                    <td>{{ $event->getFormattedDate($event->start_date) }} </td>
                    <td>{{ __($event->category->value)}}</td>
                    <td>{{ $event->getFormattedDate($event->created_at) }}</td>
                    <td>{{ $event->getFormattedDate($event->updated_at) }}</td>
                    <td><a href="{{ route("admin.event.show", ["id" => $event->id]) }}">Bewerken</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
@stop
