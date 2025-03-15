@extends('layouts.default')

@section('title', $event->title)

@section('content')
    <div class="container">
        <div class="info">
            <div class="intro">
                <h2>{{$event->title}}</h2>
                <p>
                    {!! $event->description !!}
                </p>
            </div>
            <x-swiper :item="$event->sponsors"/>
            <x-swiper :item="$event" />
        </div>
        <div class="sidebar">
            <h2 class="has-background">Informatie</h2>
            <h4>{{__($event->category->value)}}</h4>
            <p>{{ $event->status->name === 'ARCHIVED' ? '(' . __("ARCHIVED") . ')' : "" }}</p>
            <ul>
                <li><span>Datum:</span> {{$event->formatted_date}}</li>
                <li><span>Prijs:</span> {{$event->price}}</li>
                <li><span>Aantal plaatsen:</span> {{$event->capacity}}</li>
                <li><span>Betalen voor: </span><a href="{{$event->payment_link}}" target="_blank">{{$event->title}}</a></li>
            </ul>
        </div>
    </div>
@stop
