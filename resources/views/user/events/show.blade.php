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

            {{--    archived images--}}
            @if($event->hasPhotos())
                <div class="swiper-container" id="testimonialSwiper">
                    <div class="swiper-wrapper">
                        @foreach($event->getDecodedPhotos() as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset('/storage/'.$image) }}" alt="{{ $event->title }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            @endif

        </div>
        <div class="sidebar">
            <h2 class="has-background">Informatie</h2>
            <h4>{{ucfirst($event->category->value)}}</h4>
            <p>{{$event->status->name === 'ARCHIVED' ? 'Gearchiveerd' : ''}}</p>
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
