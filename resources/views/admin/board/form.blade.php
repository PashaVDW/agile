@extends('admin.index')

@section("title", isset($boardMember) ? 'Bewerk bestuur lid' : 'Voeg bestuur lid toe')

@section("content")
    <div class="container">
        @if(isset($boardMember))
            <form method="POST" action="{{ route('admin.board.update', ['id' => $boardMember->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @else
                    <form method="POST" action="{{ route('admin.board.store') }}" enctype="multipart/form-data">
                        @csrf
                        @endif

                        <x-forms.input-field type="text" name="name" label="Naam" required value="{{ old('name', $boardMember->name ?? '') }}"/>
                        <x-forms.input-field type="text" name="role" label="Rol" required value="{{ old('role', $boardMember->role ?? '') }}"/>
                        <x-forms.input-textarea name="description" label="Omschrijving">{{ old('description', $boardMember->description ?? '') }}</x-forms.input-textarea>
                        <x-forms.input-file name="image" label="Profiel foto" value="{{ $boardMember->image ?? '' }}"/>

                        <button type="submit" class="button right">{{ isset($boardMember) ? 'Update Board Member' : 'Add Board Member' }}</button>
                    </form>

                    @if(isset($boardMember))
                        <form method="POST" action="{{ route('admin.board.delete', ['id' => $boardMember->id]) }}" class="mt-4">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="button delete">Verwijder bestuur lid</button>
                        </form>
        @endif
    </div>
@stop
