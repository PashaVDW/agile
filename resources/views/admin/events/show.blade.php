@extends('admin.index')

@section("title", $event->title ?? 'Event')

@section("content")
    <div class="container">
        @if(isset($event))
            <form method="POST" action="{{ route('admin.event.update', ['id' => $event->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @else
                    <form method="POST" action="{{ route('admin.event.store') }}" enctype="multipart/form-data">
                        @csrf
                        @endif
                        <x-forms.input-field type="text" name="title" :required="true" value="{{ $event->title ?? '' }}"/>
                        <x-forms.input-textarea name="description" :class="'min-h-[100px] max-h-[300px]'" :required="true">{{ $event->description ?? '' }}</x-forms.input-textarea>
                        <x-forms.input-field type="date" name="date" :required="true" value="{{ $event->formatted_date_for_input ?? '' }}"/>
                        <x-forms.input-field type="number" name="price" value="{{ $event->price ?? '' }}"/>
                        <x-forms.input-field type="number" name="capacity" value="{{ $event->capacity ?? '' }}"/>
                        <x-forms.input-file name="image" :title="($event->title ?? '')" value="{{ $event->banner_url ?? '' }}"/>
                        <x-forms.input-select name="category" :required="true" :enum="$categories" :value="($event->category->name ?? '')"/>
                        <x-forms.input-field name="payment_link" :value="($event->payment_link ?? '')"/>
                        @if(isset($event) && $event->status->name === 'ARCHIVED')
                            <x-forms.input-file name="gallery" :title="($event->title ?? '')" :multiple="true"/>
                        @endif
                        <button type="submit" class="button right">{{ isset($event) ? 'Update event' : 'Add event' }}</button>
                    </form>
                    @if(isset($event))
                        <form method="POST" action="{{ route('admin.event.delete', ['id' => $event->id]) }}" class="mt-4">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="button delete">Delete event</button>
                        </form>

        @endif
    </div>
@stop
