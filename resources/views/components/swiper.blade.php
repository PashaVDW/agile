@props(['item'])

@if($item instanceof \Illuminate\Database\Eloquent\Model && $item->hasPhotos())
    <div class="swiper-container" id="gallerySwiper">
        <div class="swiper-wrapper">
            @foreach($item->getDecodedPhotos() as $image)
                <div class="swiper-slide">
                    <img src="{{ asset($item->getGalleryImagePath($image)) }}" alt="">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
@elseif($item instanceof \Illuminate\Database\Eloquent\Collection && $item->isNotEmpty())
    <div class="swiper-container" id="gallerySwiper">
        <div class="swiper-wrapper">
            @foreach($item as $subItem)
                <div class="swiper-slide">
                    <img src="{{ asset($subItem->image_url) }}" alt="">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
@endif
