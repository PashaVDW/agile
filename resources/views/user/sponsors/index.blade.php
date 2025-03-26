@extends("layouts.default")

@section("title", "Sponsors")

@section("content")
    <div class="instruction-message">
        <p>Wil je sponsor worden? Mail dan naar <a href="mailto:info@svconcat.nl">info@svconcat.nl</a></p>
    </div>

    <div class="sponsors-overview">
        <div class="sponsors-container">
            @foreach($sponsors as $sponsor)
                <div class="sponsor">
                    <img src="{{ asset($sponsor->image_url)}}" alt="{{ $sponsor->name }}" class="sponsor-image">
                    <h1 class="has-background">{{$sponsor->name}}</h1>
                    <p>{!! $sponsor->description !!}</p>
                </div>
            @endforeach
        </div>
    </div>
@stop
