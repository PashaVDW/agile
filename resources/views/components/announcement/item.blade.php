@props(['item', 'alt' => '', 'route'])

<div class="item">
    <div class="block image-block">
        <img src="{{ asset($item->banner_url) }}" alt="{{ $alt }}" @if(!$item->banner) class="no-image" @endif>
    </div>
    <div class="block text-block">
        <div class="item-header">
            <h3 class="has-background">{{ $item->title }}</h3>
        </div>
        <div class="item-body">
            <p>
                {!! Str::of(strip_tags($item->description))->words(20, '...') !!}
            </p>
        </div>
        <div class="item-footer">
            <a href="#" class="button item-button" aria-label="Lees meer over {{ $item->title }}">
                Lees verder
            </a>
        </div>
    </div>
</div>
