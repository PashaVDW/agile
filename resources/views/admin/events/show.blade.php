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
                        <x-forms.input-field type="text" name="title" label="Titel" :required="true" value="{{ old('title', $event->title ?? '')}}"/>
                        <x-forms.input-textarea name="description" label="Beschrijving" :class="'max-h-[300px]'">{{ old('description',$event->description ?? '')}}</x-forms.input-textarea>
                        <x-forms.input-field type="date" name="date" label="Datum" :required="true" value="{{ old('date',$event->formatted_date_for_input ?? '' )}}"/>
                        <x-forms.input-field type="number" name="price" label="Prijs" value="{{ old('price',$event->price ?? '' )}}"/>
                        <x-forms.input-field type="number" name="capacity" label="Aantal plaatsen" value="{{ old('capacity',$event->capacity ?? '' )}}"/>
                        <x-forms.input-file name="banner" :title="($event->title ?? '')" label="Afbeelding" value="{{ $event->banner_url ?? '' }}"/>
                        <x-forms.input-select name="category" :required="true" label="Categorie" :enum="$categories" value="{{old('category', $event->category->value ?? '')}}"/>
                        <x-forms.input-field name="payment_link" label="Betaal link" value="{{old('payment_link',$event->payment_link ?? '')}}"/>

                        @if(isset($event) && $event->status->name === 'ARCHIVED')
                            <x-forms.input-file name="gallery" :title="($event->title ?? '')" label="Galerij" :multiple="true" :gallery="$event ?? []"/>
                        @endif

                        @if(!isset($event) || $event->status->name !== 'ARCHIVED')
                            <button id="openModalButton" type="button" class="button right hidden">{{ isset($event) ? 'Evenement updaten' : 'Evenement toevoegen' }}</button>
                        @endif
                        <button id="submitButton" type="submit" class="button right">{{ isset($event) ? 'Evenement updaten' : 'Evenement toevoegen' }}</button>
                        <x-modal id="dateModal" title="Date Format" message="Ingevoerde datum ligt vóór de huidige datum. Klopt dit?" />
                    </form>
                    @if(isset($event))
                        <form method="POST" action="{{ route('admin.event.delete', ['id' => $event->id]) }}" class="mt-4">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="button delete">Evenement verwijderen</button>
                        </form>
        @endif

    </div>
@stop
