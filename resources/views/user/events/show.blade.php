@extends('layouts.default')

@section('title', $event->title)

@section('content')
    <div class="section">
        <div class="container has-sidebar">
            <div class="info">
                <div class="intro">
                    <h2>{{$event->title}}</h2>
                    <p>
                        {!! $event->description !!}
                    </p>
                </div>
                <x-swiper :item="$event->sponsors" id="gallerySwiper"/>
                <x-swiper :item="$event" id="gallerySwiper"/>
            </div>
            <div class="sidebar">
                <h2 class="has-background">Informatie</h2>
                <h4>{{__($event->category->value)}}</h4>
                <p>{{ $event->status->name === 'ARCHIVED' ? '(' . __("ARCHIVED") . ')' : "" }}</p>
                <ul>
                    @if($event->location)
                        <li><span>Locatie:</span> {{$event->location}}</li>
                    @endif
                    @if($event->start_date && $event->end_date)
                        <li><span>Start datum:</span> {{$event->getFormattedDate($event->start_date)}}</li>
                        <li><span>Eind datum:</span> {{$event->getFormattedDate($event->end_date)}}</li>
                    @endif
                    @if(!$event->end_date)
                        <li><span>Datum:</span> {{$event->getFormattedDate($event->start_date)}}</li>
                    @endif
                    @if($event->price)
                        <li><span>Prijs:</span> {{$event->price}}</li>
                    @endif
                    @if($event->capacity)
                        <li><span>Aantal plaatsen:</span> {{$event->capacity}}</li>
                    @endif
                    @if($event->payment_link)
                        <li><span>Betalen voor: </span><a href="{{$event->payment_link}}" target="_blank">{{$event->title}}</a></li>
                    @endif
                </ul>
                @if($event->is_open)
                    @if(auth()->user())
                        <form action="{{ $event->isRegistered() ? route('user.event.unregister', $event->id) : route('user.event.register', $event->id) }}" method="POST">
                            @csrf
                            @if($event->isRegistered())
                                @method('DELETE')
                            @endif
                            <button type="submit" class="item-button">
                                {{ $event->isRegistered() ? 'Afmelden' : 'Inschrijven' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="no-line button item-button">Inloggen</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
@stop
