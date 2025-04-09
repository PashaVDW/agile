@extends("layouts.default")

@section("title", "Aankondigingen")

@section("content")
    <div class="section">
        <div class="container has-sidebar">
            <div class="items">
                @foreach($announcements as $announcement)
                    <div class="item">
                        <div class="block image-block">
                            <img src="{{ $announcement->image ? asset('storage/' . $announcement->image) : '' }}" alt="{{ $announcement->image ? 'Afbeelding voor ' . $announcement->title : '' }}" @if(!$announcement->image) class="no-image" @endif>
                        </div>
                        <div class="block text-block">
                            <div class="item-header">
                                <h3 class="has-background">{{ $announcement->title }}</h3>
                            </div>
                            <div class="item-body">
                                <p>
                                    {!! \Illuminate\Support\Str::of(strip_tags($announcement->description))->words(20, '...') !!}
                                </p>
                            </div>
                            <div class="item-footer">
                                <a href="{{ route('user.announcements.show', $announcement->id) }}" class="button item-button" aria-label="Lees meer over {{ $announcement->title }}">Lees verder</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="sidebar">
                <form method="GET" action="{{ route(Route::currentRouteName()) }}">
                    <label for="status" class="label">Status</label>
                    <div class="select is-fullwidth">
                        <select name="status" id="status" onchange="this.form.submit()">
                            <option value="">{{ __('Alle statussen') }}</option>
                            @foreach(\App\Enums\ActiveTypeEnum::cases() as $option)
                                <option value="{{ $option->value }}" @if(request('status') === $option->value) selected @endif>{{ __($option->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-6">
            {{ $announcements->withQueryString()->links() }}
        </div>
    </div>
@stop
