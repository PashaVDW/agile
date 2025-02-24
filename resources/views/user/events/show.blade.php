@extends('layouts.default')

@section('title', $event->title)

@section('content')
{{--    inleiding, sponsore, fotos--}}
    <div>
        <div>
            <img src="{{ asset($event->image_url)}}" alt="{{ $event->title }}">
        </div>
    </div>

{{--event detail info--}}
    <div>
        <ul>
            <li>Date: {{$event->date}}</li>
            <li>Price: {{$event->price}}</li>
            <li>Title: {{$event->title}}</li>
            <li>Capacity: {{$event->capacity}}</li>
            <li><a href="{{$event->payment_link}}" target="_blank">Pay for {{$event->title}}</a></li>
        </ul>
    </div>
@stop
