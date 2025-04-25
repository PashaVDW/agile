@extends("layouts.default")

@section("title", "Events")

@section("content")
    <section class="section">
        <div class="image-container">
            {{--@foreach($gallery->gallery as $image)
                <div class="image">
                    <img src="{{ asset($gallery->getGalleryImagePath($image)) }}" class="gallery-image">
                </div>
            @endforeach--}}
            @foreach($gallery->gallery as $image)
                    <button type="button" class="image" data-bs-toggle="modal" data-bs-target="#exampleModal{{$loop->index}}">
                        <img src="{{ asset($gallery->getGalleryImagePath($image)) }}" class="gallery-image">
                    </button>
            @endforeach
        </div>
    </section>


    @if($gallery->hasPhotos())
        @foreach($gallery->gallery as $image)
            <div class="modal fade" id="exampleModal{{$loop->index}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body d-flex justify-center align-middle">
                            <div class="w-100 h-100 overflow-hidden zoom-wrapper">
                                <div class="d-flex justify-center area-wrapper">
                                    <img src="{{ asset($gallery->getGalleryImagePath($image)) }}" class="d-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@stop
