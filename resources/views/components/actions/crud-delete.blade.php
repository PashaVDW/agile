@props(['item', 'route', 'title', 'message'])

@php
    $modalId = 'deleteModal-' . $item->id;
@endphp

<form method="POST" action="{{ route($route, ['id' => $item->id]) }}" class="mt-4">
    @method('DELETE')
    @csrf

    <button
        type="button"
        dusk="delete-announcement-{{ $item->id }}"
        data-modal-id="{{ $modalId }}"
        class="button delete"
    >
        {{ $title }}
    </button>

    <x-modal id="{{ $modalId }}" title="{{ $title }}" message="{{ $message }}" />
</form>
