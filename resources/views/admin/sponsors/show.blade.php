@extends('admin.index')

@section("title", $sponsor->name ?? 'Sponsor')

@section("content")
    <div class="container">
        @if(isset($sponsor))
            <form method="POST" action="{{ route('admin.sponsor.update', ['id' => $sponsor->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @else
                    <form method="POST" action="{{ route('admin.sponsor.store') }}" enctype="multipart/form-data">
                        @csrf
                        @endif
                        <x-forms.input-field type="text" name="name" :required="true" value="{{ old('name',$sponsor->name ?? '' )}}"/>
                        <x-forms.input-textarea name="description" :class="'min-h-[100px] max-h-[300px]'">{{ old('description',$sponsor->description ?? '' )}}</x-forms.input-textarea>
                        <x-forms.input-file name="image" :title="($sponsor->name ?? '')" value="{{ $sponsor->image_url ?? ''}}"/>
                        <x-forms.input-select name="active" :required="true" :list="$types" :value="($sponsor->active ?? '')"/>

                        @if($events->count() > 0)
                            <h2 class="mt-4">Events</h2>
                            @foreach($events as $event)
                                <x-forms.input-checkbox name="events[]" :value="$event->id" :label="$event->title" :checked="isset($sponsor) && $sponsor->events->contains($event->id)"/>
                            @endforeach
                        @endif

                        <button type="submit" class="button right">{{ isset($sponsor) ? 'Update sponsor' : 'Add sponsor' }}</button>
                    </form>
                    @if(isset($sponsor))
                        <form method="POST" action="{{ route('admin.sponsor.delete', ['id' => $sponsor->id]) }}" class="mt-4">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="button delete">Sponsor verwijderen</button>
                        </form>
        @endif
    </div>
@stop
