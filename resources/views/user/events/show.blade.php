@extends('layouts.default')

@section('title', $event->title)

@section('content')
{{--    Inleiding, sponsors, fotos--}}
    <div>
        <div>
            <img src="{{ asset($event->image_url)}}" alt="{{ $event->title }}">
        </div>
    </div>


<div class="flex horizontal centered">
    {{-- Event Description --}}
    <div class="paper" id="post-content">
        <h2>{{$event->title}}</h2>
        <p>
            @if($event->description)
                Beste leden,<br>
                {{$event->description}}<br>
                Liefs, Concat
            @endif
        </p>
    </div>

    <div class="sidebar">
        {{-- Informatie over event --}}
        <div class="card">
            <h3>Informatie</h3><br>
            <p>{{ucfirst($event->category->value)}}</p><br>
            <p>Gepost op: <b>{{date_format($event->created_at, 'd-m-Y')}}</b><br>
                Laatst bewerkt op: <b>{{date_format($event->updated_at, 'd-m-Y')}}</b><br>
                Leestijd: <b></b></p>
        </div>

        {{--Event detail info--}}
        <div class="card">
            <ul>
                <li>Date: {{$event->date}}</li>
                <li>Price: {{$event->price}}</li>
                <li>Title: {{$event->title}}</li>
                <li>Capacity: {{$event->capacity}}</li>
                <li><a href="{{$event->payment_link}}" target="_blank">Pay for {{$event->title}}</a></li>
            </ul>
        </div>
    </div>
</div>
    <div class="flex horizontal spaced">
        <div class="card">
            <p>
                <a href="mailto:info@svconcat.nl">
                    info@svconcat.nl
                </a>
                <a href="tel:+31644848495">
                    (0)6 44848495
                </a>
            </p>
            <br>
            <p>
                <a href="https://www.instagram.com/svconcat/">Instagram</a>
                <a href="https://www.linkedin.com/company/sv-concat/">LinkedIn</a>
            </p>
        </div>
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
@stop
