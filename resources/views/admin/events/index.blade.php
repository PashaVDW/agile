@extends("admin.index")

@section("title", "Events")

@section("content")
    <div class="container">
        <a href="{{ route("admin.event.create") }}" class="button right">Event aanmaken</a>
        <table class="table">
            <thead>
                <tr>
                    <td>Titel</td>
                    <td>Datum</td>
                    <td>Categorie</td>
                    <td>Aangemaakt op</td>
                    <td>Bijgewerkt op</td>
                    <td>Acties</td>
                </tr>
            </thead>
            <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{Str::of($event->title)->words(5, '...')}} <span>{{ $event->status->name === 'ARCHIVED' ? '(Archived)' : "" }}</span></td>
                    <td>{{ $event->formatted_date }} </td>
                    <td>{{ __($event->category->value)}}</td>
                    <td>{{ $event->getFormattedDateTime($event->created_at) }}</td>
                    <td>{{ $event->getFormattedDateTime($event->updated_at) }}</td>
                    <td><a href="{{ route("admin.event.show", ["id" => $event->id]) }}">Updaten</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
@stop
