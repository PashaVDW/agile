@extends("layouts.default")

@section("title", "Events")

@section("content")
    <div id="post-list" class="flex horizontal wrap centered stretch">
        @foreach($events as $event)
            <x-item :event="$event"/>
        @endforeach
    </div>
@stop
