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
                        <x-forms.input-textarea name="description" :required="true">{{ old('description',$event->description ?? '')}}</x-forms.input-textarea>
                        <x-forms.input-field type="date" name="date" id="eventDate" :required="true" value="{{ old('date',$event->formatted_date_for_input ?? '' )}}"/>
                        <x-forms.input-field type="number" name="price" value="{{ old('price',$event->price ?? '' )}}"/>
                        <x-forms.input-field type="number" name="capacity" value="{{ old('capacity',$event->capacity ?? '' )}}"/>
                        <x-forms.input-file name="banner" :title="($event->title ?? '')" value="{{ old('image',$event->banner_url ?? '' )}}"/>
                        <x-forms.input-select name="category" :required="true" :enum="$categories" value="{{$event->category->name ?? ''}}"/>
                        <x-forms.input-field name="payment_link" value="{{old('payment_link',$event->payment_link ?? '')}}"/>

                        @if(isset($event) && $event->status->name === 'ARCHIVED')
                            <x-forms.input-file name="gallery" :title="($event->title ?? '')" :multiple="true" :gallery="$event ?? []"/>
                        @endif

                        @if(!isset($event) || $event->status->name !== 'ARCHIVED')
                            <button id="openModalButton" type="button" class="button right hidden">{{ isset($event) ? 'Update event' : 'Add event' }}</button>
                        @endif
                        <button id="submitButton" type="submit" class="button right">{{ isset($event) ? 'Update event' : 'Add event' }}</button>
                        <x-modal id="dateModal" title="Date Format" message="Ingevoerde datum ligt vóór de huidige datum. Klopt dit?" />
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
