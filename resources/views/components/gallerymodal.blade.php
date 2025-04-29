@props(
['id',
'gallery',
'image']
)

{{--<div id="imageModal{{$id}}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden gallery-modal">
    <div class="bg-white rounded-lg overflow-hidden relative max-w-3xl w-full">
        <!-- Close Button -->
        --}}{{--<button class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" onclick="toggleModal(false)">
            &times;
        </button>--}}{{--
        <button id="close{{$id}}Button" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Annuleren</button>
        <!-- Image with Zoom -->
        <div class="overflow-hidden">
            <img src="{{ asset($gallery->getGalleryImagePath($image)) }}" alt="Zoomed Image" class="transform transition-transform duration-300 hover:scale-110">
        </div>
    </div>
</div>--}}






<div
    data-dialog-backdrop="image-modal{{$id}}"
    data-dialog-backdrop-close="true"
    class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300"
>
    <div
        class="relative m-4 w-2/4 rounded-lg bg-white shadow-sm"
        role="modal"
        data-dialog="image-modal{{$id}}"
    >
        <div class="relative border-b border-t border-b-blue-gray-100 border-t-blue-gray-100 p-0 font-sans text-base font-light leading-relaxed text-blue-gray-500 antialiased">
            <img
                alt="nature"
                class="h-[30rem] w-full object-cover object-center"
                src="{{ asset($gallery->getGalleryImagePath($image)) }}"
            />
        </div>
    </div>
</div>

