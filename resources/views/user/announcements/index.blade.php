@extends("layouts.default")

@section("title", "Mededelingen")

@section("content")
    <div class="container">
        <div class="items">
            @foreach($announcements as $announcement)
                <div class="item">
                    <div class="block image-block">
                        <img src="{{ asset($announcement->image_url) }}" alt="{{ $announcement->title }}" @if(!$announcement->image) class="no-image" @endif>
                    </div>
                    <div class="block text-block">
                        <div class="item-header">
                            <h3 class="has-background">{{ $announcement->title }}</h3>
                            <h6>{{ __('Aankondiging') }}</h6>
                        </div>
                        <div class="item-body">
                            <p>
                                {!! Str::of(strip_tags($announcement->description))->words(20, '...') !!}
                            </p>
                        </div>
                        <div class="item-footer">
                            <a href="{{route('user.announcement.show', ['id' => $announcement->id])}}" class="button item-button">Lees verder</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="sidebar">
            <form method="GET" action="{{ route(Route::currentRouteName()) }}">
                <x-forms.input-select :onchange="'this.form.submit()'" name="status" label="Status" default="Alle statussen" enum="{{\App\Enums\ActiveTypeEnum::class}}" value="{{ request('status') }}"/>
            </form>
        </div>
    </div>
@stop
