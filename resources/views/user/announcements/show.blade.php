@extends('layouts.default')

@section('title', $announcement->title)

@section('content')
    <div class="section">
        <div class="container">
            <div class="info">
                <div class="intro">
                    <h2>{{$announcement->title}}</h2>
                    <p>
                        {!! $announcement->description !!}
                    </p>
                </div>
            </div>
            <div class="sidebar">
                <ul>
                    @if($announcement->updated_at)
                        <li><span>Gewijzigd op:</span> {{ $announcement->updated_at->format("d M, Y H:i")}}</li>
                    @endif
                    @if($announcement->created_at)
                        <li><span>Aangemaakt op:</span> {{ $announcement->created_at->format("d M, Y H:i")}}</li>
                    @endif
                </ul>
                @if($announcement->image)
                    <div class="image-block">
                        <img src="{{ asset($announcement->image_url) }}" alt="{{ $announcement->title }}">
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
