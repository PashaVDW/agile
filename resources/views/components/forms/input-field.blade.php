@props([
  "name",
  "required" => false,
  "value" => "",
  "class" => "",
  "type" => "text",
  "label" => "",
])

<div class="mb-4">
  <label class="block text-gray-700 text-sm font-bold mb-1" for="{{ $name }}">
    {{ \Illuminate\Support\Str::of($label)->kebab()->replace("-", " ")->ucfirst() }}
    @if ($required)
      <span class="">*</span>
    @endif
  </label>
  <input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ $value }}"
    class="border border-gray-400 bg-white rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 {{ $class }}"
    {{ $required ? "required" : "" }}
  />
  @error($name)
    <span class="text-xs italic">{{ $message }}</span>
  @enderror
</div>
