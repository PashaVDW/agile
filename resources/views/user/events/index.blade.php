@extends("layouts.default")

@section("title", "Events")

@section("content")
    <div class="container">
        <div class="items">
            @foreach($events as $event)
                <x-item :event="$event"/>
            @endforeach
        </div>
        <div class="sidebar">
            <form method="GET" action="{{ route(Route::currentRouteName()) }}">
                <x-forms.input-select :onchange="'this.form.submit()'" name="status" label="Categorie" enum="{{\App\Enums\ActiveTypeEnum::class}}" value="{{ request('status') }}"/>
            </form>
        </div>
    </div>
@stop
