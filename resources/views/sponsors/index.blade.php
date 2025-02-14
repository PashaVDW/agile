<div>

    <a href="{{route('sponsor.create')}}">Create sponsor</a>

    @foreach($sponsors as $sponsor)
        <a href="{{route('sponsor.show', ['id' => $sponsor->id])}}">
            {{$sponsor->name}}
        </a>
    @endforeach
</div>
