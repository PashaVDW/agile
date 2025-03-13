@extends("layouts.default")

@section("title", "Events")

@section("content")
    <div class="container">
        <div class="items">
            @foreach($events as $event)
                <x-item :event="$event"/>
            @endforeach
        </div>
        <div class="sidebar">
        </div>
    </div>
@stop
