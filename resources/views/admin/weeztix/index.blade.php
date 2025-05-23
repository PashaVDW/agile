@extends("admin.index")

@section("title", "Weeztix")

@section("content")
    <div class="container">
        <div class="wrapper">
            <h2>Weeztix</h2>
            <div class="button-wrapper">
                @if(!$tokenExists)
                    <a href="{{route('admin.weeztix.create-token')}}" class="button">Maak de eerste Weeztix connectie aan</a>
                @endif
                @if($tokenExists)
                    <form action="{{route('admin.weeztix.refresh-token')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="button">Hernieuw de Weeztix token</button>
                        <p class="hint">Gebruik deze optie alleen in geval van nood (als de bv auto refresh niet optijd refreshed). Deze token is nodig om de API te kunnen gebruiken.</p>
                    </form>
                @endif
            </div>
        </div>
    </div>
@stop
