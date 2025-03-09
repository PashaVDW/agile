@extends("layouts.default")

@section("title", "Events")

@section("content")
    <div class="container">
        @foreach($events as $event)
            <x-item :event="$event"/>
        @endforeach
    </div>
@stop
