@props([
  "name",
  "required" => false,
  "class" => "",
])

<div class="">
  <label class="" for="{{ $name }}">
    {{ \Illuminate\Support\Str::of($name)->kebab()->replace("-", " ")->ucfirst() }}
    @if ($required)
      <span class="">*</span>
    @endif
  </label>
  <textarea
    name="{{ $name }}"
    id="{{ $name }}"
    class="{{ $class }}"
    {{ $required ? "required" : "" }}
  >
{{ $slot }}</textarea
  >
  @error($name)
    <span class="">{{ $message }}</span>
  @enderror
</div>
