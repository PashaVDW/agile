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
                        <x-forms.input-field type="text" name="title" :required="true" value="{{ old('title', $event->title ?? '')}}"/>
                        <x-forms.input-textarea name="description" :class="'min-h-[100px] max-h-[300px]'" :required="true">{{ old('description',$event->description ?? '')}}</x-forms.input-textarea>
                        <x-forms.input-field type="date" name="date" :required="true" value="{{ old('date',$event->formatted_date_for_input ?? '' )}}"/>
                        <x-forms.input-field type="number" name="price" value="{{ old('price',$event->price ?? '' )}}"/>
                        <x-forms.input-field type="number" name="capacity" value="{{ old('capacity',$event->capacity ?? '' )}}"/>
                        <x-forms.input-file name="image" :title="($event->title ?? '')" value="{{ old('image',$event->image_url ?? '' )}}"/>
                        <x-forms.input-select name="category" :required="true" :enum="$categories" value="{{$event->category->name ?? ''}}"/>
                        <x-forms.input-field name="payment_link" value="{{old('payment_link',$event->payment_link ?? '')}}"/>
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
