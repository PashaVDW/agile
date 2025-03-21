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
                        <x-forms.input-field type="number" name="price" label="Prijs" value="{{ old('price',$event->price ?? '' )}}"/>
                        <x-forms.input-field type="number" name="capacity" label="Aantal plaatsen" value="{{ old('capacity',$event->capacity ?? '' )}}"/>
                        <x-forms.input-file name="banner" :title="($event->title ?? '')" label="Afbeelding" value="{{ $event->banner_url ?? '' }}"/>
                        <x-forms.input-select name="category" :required="true" label="Categorie" :enum="$categories" value="{{old('category', $event->category->value ?? '')}}"/>
                        <x-forms.input-field name="payment_link" label="Betaal link" value="{{old('payment_link',$event->payment_link ?? '')}}"/>
                        <x-forms.input-field name="location" label="Locatie" value="{{old('location',$event->location ?? '')}}"/>
                        <x-forms.input-field type="datetime-local" name="start_date" label="Datum / Start datum" value="{{ old('start_date', isset($event) ? $event->getFormattedDateForInput($event->start_date) : '' ) }}"/>
                        <x-forms.input-field type="datetime-local" name="end_date" label="Eind datum" value="{{ old('end_date', isset($event) ? $event->getFormattedDateForInput($event->end_date) : '' )}}"/>

                    @if(isset($event) && $event->status->name === 'ARCHIVED')
                            <x-forms.input-file name="gallery" :title="($event->title ?? '')" label="Galerij" :multiple="true" :gallery="$event ?? []"/>
                        @endif

                        @if($sponsors->count() > 0)
                            <h2 class="mt-4">Sponsoren</h2>
                            @foreach($sponsors as $sponsor)
                                <x-forms.input-checkbox name="sponsors[]" :value="$sponsor->id" :label="$sponsor->name" :checked="isset($event) && $event->sponsors->contains($sponsor->id)"/>
                            @endforeach
                        @endif

                        @if(!isset($event) || $event->status->name !== 'ARCHIVED')
                            <button id="openModalButton" type="button" class="button right hidden" data-modal-id="dateModal">{{ isset($event) ? 'Evenement updaten' : 'Evenement toevoegen' }}</button>
                        @endif
                        <button id="submitButton" type="submit" class="button right">{{ isset($event) ? 'Evenement updaten' : 'Evenement toevoegen' }}</button>
                        <x-modal id="dateModal" title="Date Format" message="Ingevoerde datum ligt vóór de huidige datum. Klopt dit?" />
                    </form>
                    @if(isset($event))
                        <form method="POST" action="{{ route('admin.event.delete', ['id' => $event->id]) }}" class="mt-4">
                            @method('DELETE')
                            @csrf
                            <button id="openModalDeleteButton" data-modal-id="deleteModal" type="button" class="button delete">Evenement verwijderen</button>
                            <x-modal id="deleteModal" title="Evenement verwijderen" message="Weet je zeker dat je deze wilt verwijderen" />
                        </form>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            openModal();
        });

        function openModal() {
            const eventDateInput = document.getElementsByName('start_date')[0];
            const openModalButton = document.getElementById('openModalButton');
            const openModalDeleteButton = document.getElementById('openModalDeleteButton');
            const submitButton = document.getElementById('submitButton');
            const today = new Date().toISOString().split('T')[0];
            const modals = document.getElementsByClassName('modal-wrapper');

            function checkDate() {
                const selectedDate = eventDateInput.value;
                if (selectedDate < today) {
                    openModalButton.classList.remove('hidden');
                    submitButton.classList.add('hidden');
                } else {
                    openModalButton.classList.add('hidden');
                    submitButton.classList.remove('hidden');
                }
            }

            function showModal(button) {
                for (let i = 0; i < modals.length; i++) {
                    if (modals[i].id === button.getAttribute('data-modal-id')) {
                        modals[i].classList.toggle('hidden');
                    }
                }
            }
            openModalDeleteButton.addEventListener('click', function () {
                showModal(openModalDeleteButton);
            });

            eventDateInput.addEventListener('change', checkDate);
            openModalButton.addEventListener('click', function () {
                showModal(openModalButton);
            });


            checkDate();
        }
    </script>
@stop
