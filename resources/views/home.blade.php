@extends('layouts.default')

@section('title', 'Home')

@section('content')
<div class="concat-banner">
    <div class="concat-title">
        <div>
            <h2>Welkom bij</h2>
            <h1>
                Studievereniging
                <br />
                Concat
            </h1>
        </div>
        <img src="/assets/images/logo-white.svg" alt="Concat Logo" />
        <div class="real-pseudo-element"></div>
    </div>
</div>

<div class="events">
    <div class="container">
        <div class="items">
            @foreach ($events as $event)
                <x-item :event="$event" />
            @endforeach
        </div>
        @if ($randomEvent)
            <div class="sidebar">
                <x-swiper :item="$randomEvent" alt="title" />
            </div>
        @endif
    </div>
</div>
@stop
