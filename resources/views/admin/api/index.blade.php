@extends("admin.index")

@section("title", "API")

@section("content")
    <div class="container">
        @if(!$tokenExists)
            <a href="{{route('admin.api.create-token')}}" class="button">Maak de eerste Weeztix connectie aan</a>
        @endif
        <form action="{{route('admin.api.refresh-token')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <button type="submit" class="button">Hernieuw de Weeztix token</button>
            <p class="hint">Gebruik deze optie alleen in geval van nood (als de bv auto refresh niet optijd refreshed). Deze token is nodig om de API te kunnen gebruiken.</p>
        </form>
    </div>
@stop
