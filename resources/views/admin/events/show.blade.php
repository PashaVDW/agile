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
                        <x-forms.input-file name="image" :title="($event->title ?? '')" label="Afbeelding" value="{{ $event->image_url ?? '' }}"/>
                        <x-forms.input-select name="category" :required="true" label="Categorie" :enum="$categories" value="{{old('category', $event->category->value ?? '')}}"/>
                        <x-forms.input-field name="payment_link" label="Betaal link" value="{{old('payment_link',$event->payment_link ?? '')}}"/>

                        @if($sponsors->count() > 0)
                            <h2 class="mt-4">Sponsoren</h2>
                            @foreach($sponsors as $sponsor)
{{--                                <x-forms.input-checkbox name="sponsors[]" :value="$sponsor->id" :label="$sponsor->name" :checked="isset($event) && $event->sponsors->contains($sponsor->id)"/>--}}
                            @endforeach
                        @endif

                        <button type="submit" class="button right">{{ isset($event) ? 'Evenement updaten' : 'Evenement toevoegen' }}</button>
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
