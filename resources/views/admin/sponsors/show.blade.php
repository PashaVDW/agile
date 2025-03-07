@extends('admin.index')

@section("title", $sponsor->name ?? 'Sponsor')

@section("content")
    <div>
        @if(isset($sponsor))
            <form method="POST" action="{{ route('admin.sponsor.update', ['id' => $sponsor->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @else
                    <form method="POST" action="{{ route('admin.sponsor.store') }}" enctype="multipart/form-data">
                        @csrf
                        @endif
                        <x-forms.input-field type="text" name="name" :required="true" value="{{ $sponsor->name ?? '' }}"/>
                        <x-forms.input-textarea name="description" :class="'min-h-[100px] max-h-[300px]'">{{ $sponsor->description ?? '' }}</x-forms.input-textarea>
                        <x-forms.input-file name="image" :title="($sponsor->name ?? '')" value="{{ $sponsor->image ?? '' }}"/>
                        <x-forms.input-select name="active" :required="true" :list="$types" :value="($sponsor->active ?? '')"/>

                        @if(isset($sponsor))
                            @foreach($sponsor->events as $event)
                                @else
                                    @foreach($events as $event)
                                        @endif
                                        <x-forms.input-checkbox name="events[]" :value="$event->id" :label="$event->name" :checked="isset($sponsor) ? $sponsor->events->contains($event) : false"/>
                                    @endforeach

                        <button type="submit">{{ isset($sponsor) ? 'Update sponsor' : 'Add sponsor' }}</button>
                    </form>
                    @if(isset($sponsor))
                        <form method="POST" action="{{ route('admin.sponsor.delete', ['id' => $sponsor->id]) }}" class="mt-4">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="">Sponsor verwijderen</button>
                        </form>
        @endif



    </div>
@stop
