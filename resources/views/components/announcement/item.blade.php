@props(['announcement'])

<div class="item">
    <div class="block image-block">
        <img
            src="{{ $announcement->image ? asset('storage/' . $announcement->image) : '' }}"
            alt="{{ $announcement->image ? 'Afbeelding voor ' . $announcement->title : '' }}"
            @if(!$announcement->image) class="no-image" @endif
        >
    </div>
    <div class="block text-block">
        <div class="item-header">
            <h3 class="has-background">{{ $announcement->title }}</h3>
        </div>
        <div class="item-body">
            <p>{!! Str::of(strip_tags($announcement->description))->words(20, '...') !!}</p>
        </div>
        <div class="item-footer">
            <a href="#" class="button item-button" aria-label="Lees meer over {{ $announcement->title }}">
                Lees verder
            </a>
        </div>
    </div>
</div>
