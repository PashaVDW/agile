@props(['event'])

<div class="card-container">
    <div class="card">
        <img src="{{ asset($event->banner_url)}}" alt="{{ $event->title }}">
        <h3>{{$event->title}}</h3>
        <h6 class="no-margin">{{ucfirst($event->category->value)}}</h6>
        <p>
            {{Str::of($event->description)->words(20, '...')}}
        </p>

        {{--                    priority 2???--}}
        <a href="{{ route('user.event.show', $event->id) }}">Lees verder</a>
    </div>
</div>
