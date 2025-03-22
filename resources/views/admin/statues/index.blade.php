@extends("admin.index")

@section("title", "Statues")

@section("content")
    <div class="container">
        <form method="POST" action="{{isset($statue) ? route('admin.statue.update') : route('admin.statue.store')}}" enctype="multipart/form-data">
            @if(isset($statue))
                @method('PUT')
            @endif
            @csrf
            <x-forms.input-file name="filepath" label="Statuten" title="Statuten PDF" value="{{old('filepath', $statue->filepath_url ?? '') }}"/>
            <button type="submit" class="button">Opslaan</button>
        </form>
    </div>
@stop
