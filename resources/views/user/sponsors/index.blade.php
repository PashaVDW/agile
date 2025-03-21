@extends("layouts.default")

@section("title", "Sponsors")

@section("content")
    @foreach($sponsors as $sponsor)
        <div class="sponsor">
            <h1 class="has-background">{{$sponsor->name}}</h1>
            <p>{!! $sponsor->description !!}</p>
        </div>
    @endforeach
@stop
