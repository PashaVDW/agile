@extends('layouts.default')

@section('title', $event->title)

@section('content')
    <div class="container">
        <div class="info">
            <div class="intro">
                <h2>{{$event->title}}</h2>
                <p>
                    @if($event->description)
                        Beste leden,
                        <br />
                        <br />
                        {{$event->description}}
                        <br />
                        <br />
                        Liefs, Concat
                    @endif
                </p>
            </div>
        </div>
        <div class="details">
            <h2>Informatie</h2>
            <h4>{{ucfirst($event->category->value)}}</h4>
            <ul>
                <li><span>Datum:</span> {{$event->date}}</li>
                <li><span>Prijs:</span> {{$event->price}}</li>
                <li><span>Titel:</span> {{$event->title}}</li>
                <li><span>Aantal plaatsen:</span> {{$event->capacity}}</li>
                <li><span>Betalen voor: </span><a href="{{$event->payment_link}}" target="_blank">{{$event->title}}</a></li>
            </ul>
        </div>
    </div>
@stop
