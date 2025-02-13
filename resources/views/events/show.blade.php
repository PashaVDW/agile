<div>
    @if(isset($event))
        <form method="POST" action="{{ route('event.update', ['id' => $event->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @else
                <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data">
                    @csrf
                    @endif
                    <x-forms.input-field type="text" name="title" :required="true" value="{{ $event->title ?? '' }}"/>
                    <x-forms.input-textarea name="description" :class="'min-h-[100px] max-h-[300px]'" :required="true">{{ $event->description ?? '' }}</x-forms.input-textarea>
                    <x-forms.input-field type="date" name="date" :required="true" value="{{ $event->date ?? '' }}"/>
                    <x-forms.input-field type="number" name="price" value="{{ $event->price ?? '' }}"/>
                    <x-forms.input-field type="number" name="capacity" value="{{ $event->capacity ?? '' }}"/>
                    <x-forms.input-file name="image" :title="($event->title ?? '')" value="{{ $event->image ?? '' }}"/>
                    <button type="submit">{{ isset($event) ? 'Update event' : 'Add event' }}</button>
                </form>
                @if(isset($event))
                    <form method="POST" action="{{ route('event.delete', ['id' => $event->id]) }}" class="mt-4">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="">Delete event</button>
                    </form>
    @endif



</div>
