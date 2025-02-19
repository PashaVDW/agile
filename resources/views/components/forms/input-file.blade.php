@props([
  "name",
  "required" => false,
  "value",
  "title" => "",
  "class" => "",
])

<div class="">
  <label class="" for="{{ $name }}">
    {{ \Illuminate\Support\Str::of($name)->kebab()->replace("-", " ")->ucfirst() }}
    @if ($required)
      <span class="">*</span>
    @endif
  </label>
  @if ($value)
    <div class="">
      <a href="{{ asset($value) }}" target="_blank" class="">{{ $title }}</a>
    </div>
  @endif

  <input
    type="file"
    name="{{ $name }}"
    class="{{ $class }}"
    {{ $required ? "required" : "" }}
  />
  @error($name)
    <span class="">{{ $message }}</span>
  @enderror
</div>
