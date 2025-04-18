@extends("admin.index")

@section("title", "Sponsoren")

@section("content")
    <div class="container">
        <a href="{{route('admin.sponsor.create')}}" class="button right">Sponsor aanmaken</a>
        <table class="table">
            <thead>
                <tr>
                    <td>Naam</td>
                    <td>Status</td>
                    <td>Acties</td>
                </tr>
            </thead>
            <tbody>
                @foreach($sponsors as $sponsor)
                    <tr>
                        <td>{{$sponsor->name}}</td>
                        <td>{{__($sponsor->active)}}</td>
                        <td><a href="{{ route("admin.sponsor.show", ["id" => $sponsor->id]) }}">Bewerken</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $sponsors->links() }}
        </div>
    </div>
@stop
