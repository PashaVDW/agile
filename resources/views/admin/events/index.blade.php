@extends("admin.index")

@section("title", "Events")

@section("content")
    <div>
        <a href="{{ route("admin.event.create") }}" class="">Create event</a>
        <table class="table">
            <thead>
                <tr>
                    <td>Title</td>
                    <td>Date</td>
                    <td>Category</td>
                    <td>Created at</td>
                    <td>Updated at</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->title }} <strong>{{ $event->date < now() ? '(Archived)' : "" }}</strong></td>
                    <td>{{ $event->date }}</td>
                    <td>{{ $event->category->name }}</td>
                    <td>{{ $event->created_at }}</td>
                    <td>{{ $event->updated_at }}</td>
                    <td><a href="{{ route("admin.event.show", ["id" => $event->id]) }}">Update</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
@stop
