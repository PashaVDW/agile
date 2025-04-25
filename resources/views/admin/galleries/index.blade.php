@extends("admin.index")

@section("title", "Galleries")

@section("content")

<div class="container">
    <x-forms.input-dropzone attribute="gallery" :model="$gallery" id="homeGallery" label="Gallerij"/>
</div>

    @stop
