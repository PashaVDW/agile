@extends("admin.index")

@section("title", "Sponsoren")

@section("content")
    <div>
        <a href="{{route('admin.sponsor.create')}}">Sponsor aanmaken</a>

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
                        <td>{{$sponsor->active}}</td>
                        <td><a href="{{ route("admin.sponsor.show", ["id" => $sponsor->id]) }}">Update</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
