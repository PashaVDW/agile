@props([
  "name",
  "required" => false,
  "value" => "",
  "title" => "",
  "class" => "",
  "label" => "",
])

<div class="mb-4">
  <label class="block text-gray-700 text-sm font-bold mb-1" for="{{ $name }}">
    {{ \Illuminate\Support\Str::of($label)->kebab()->replace("-", " ")->ucfirst() }}
    @if ($required)
      <span class="">*</span>
    @endif
  </label>

    @if ($value && $value !== "assets/images/no-image.png")
        <div class="mb-2">
            <a href="{{ asset($value) }}" target="_blank" class="file">
                {{ $title ?: 'Bekijk bestand' }}
            </a>
        </div>
    @endif

  <input
    type="file"
    name="{{ $name }}"
    class="border border-gray-400 bg-white rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 {{ $class }}"
    {{ $required ? "required" : "" }}
  />
  @error($name)
    <span class="text-xs italic">{{ $message }}</span>
  @enderror
</div>
