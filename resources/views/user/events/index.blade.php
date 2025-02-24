@extends("layouts.default")

@section("title", "Events")

@section("content")
    <div>
        @foreach($events as $event)
            <div>
                <div>
                    <img src="{{ asset($event->image_url)}}" alt="{{ $event->title }}">
                </div>
                <div>
                    <h2>{{$event->title}}</h2>
                    <p>{{Str::of($event->description)->words(20, '...')}}</p>
                </div>
                <div>
                    <a href="{{ route('user.event.show', $event->id) }}">View Details</a>
                </div>
            </div>
        @endforeach
    </div>
@stop
