@props([
    'attribute' => 'gallery',
    'model' => null,
    'modelname' => '',
    'id',
    'label' => '',
    'class' => '',
   ])
<div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-1" for="{{ $id }}">
            {{ ucfirst($label) }}
        </label>
        <h5 id="message" class="text-center text-danger"></h5>
        <form action="{{ isset($model) ? route( 'admin.gallery.upload',  [strtolower(class_basename($model)), $model->id]) : route('admin.gallery.store', $modelname) }}" method="POST" enctype="multipart/form-data" class="dropzone border border-gray-400 bg-white rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 {{ $class }}" id="{{$id}}">
            @csrf
            <input type="hidden" name="attribute" value="{{ $attribute }}">
        </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        mDropzone();
    });

    function mDropzone() {
        var maxFilesize = 5; // MB
        var maxFilesAmount = null; // unlimited

        Dropzone.options.{{$id}} = {
            paramName:"{{$attribute}}",
            maxFilesize: maxFilesize, // MB
            maxFiles: maxFilesAmount,
            resizeQuality: 1.0,
            acceptedFiles: ".jpeg,.jpg,.png,.webp,.gif,.svg",
            addRemoveLinks: {{ isset($model) }},
            timeout: 60000,
            dictDefaultMessage: "Sleep bestanden hierheen of klik om te uploaden",
            dictFileTooBig: "Bestand is te groot (max. "+maxFilesize+" MB)",
            dictInvalidFileType: "Bestandstype ongeldig. Alleen JPG, JPEG, PNG, WEBP, GIF, SVG zijn toegestaan.",
            maxfilesexceeded: function(file) {
                this.removeFile(file);
                document.getElementById("message").innerHTML = "Je kunt niet meer dan " + maxFilesAmount + " bestanden uploaden.";
                },
            removedfile: function (file) {
                @if(isset($model))
                    var fileName = file.name;
                    $.ajax({
                        url: "{{ route('admin.gallery.delete', [strtolower(class_basename($model)), $model->id]) }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            file_names: [fileName],
                            attribute: "{{ $attribute }}"
                        },
                        success: function (response) {
                        },
                        error: function (xhr, status, error) {
                        }
                    });

                    var previewElement = file.previewElement;
                    if (previewElement != null) {
                        previewElement.parentNode.removeChild(previewElement);
                    }
                @endif
            },
            init: function() {
                @if(isset($model))
                    var myDropzone = this;
                    $.ajax({
                        url: "{{ route('admin.gallery.fetch', [strtolower(class_basename($model)), $model->id]) }}",
                        type: "GET",
                        dataType: "json",
                        success: function (response) {
                            response.forEach(function (file) {
                                var mockFile = { name: file.name, size: file.size };
                                myDropzone.emit("addedfile", mockFile);
                                myDropzone.emit("thumbnail", mockFile, file.path);
                                myDropzone.emit("complete", mockFile);
                            });
                            if(response.length > 0) {
                                document.getElementsByClassName("dz-message")[0].style.display = "none";
                            }
                        },
                        error: function (xhr, status, error) {
                        }
                    });
                @endif
            }
        };
    }
</script>
