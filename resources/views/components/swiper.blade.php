@props(['item', 'alt'])

@if($item->hasPhotos())
    <div class="swiper-container" id="testimonialSwiper">
        <div class="swiper-wrapper">
            @foreach($item->getDecodedPhotos() as $image)
                <div class="swiper-slide">
                    <img src="{{ asset($item->getGalleryImagePath($image)) }}" alt="{{ $item->$alt }}">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
@endif
