<div>

    <a href="{{route('event.create')}}">Create event</a>

    @foreach($events as $event)
        <a href="{{route('event.show', ['id' => $event->id])}}">
            {{$event->title}}
        </a>
    @endforeach
</div>


