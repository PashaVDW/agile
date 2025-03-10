@extends("admin.index")

@section("title", "Events")

@section("content")
    <div class="container">
        <form method="GET" action="{{ route(Route::currentRouteName()) }}">
            <x-forms.input-select :onchange="'this.form.submit()'" name="status" enum="{{\App\Enums\ActiveTypeEnum::class}}" value="{{ request('status') }}"/>
        </form>
        <a href="{{ route("admin.event.create") }}" class="button right">Create event</a>
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
                    <td>{{Str::of($event->title)->words(5, '...')}} <span>{{ $event->status->name === 'ARCHIVED' ? '(Archived)' : "" }}</span></td>
                    <td>{{ $event->formatted_date }} </td>
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
