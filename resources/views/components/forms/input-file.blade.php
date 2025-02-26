@props([
  "name",
  "required" => false,
  "value" => "",
  "title" => "",
  "class" => "",
  "multiple" => false,
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
    name="{{ $name }}{{ $multiple ? '[]' : '' }}"
    class="{{ $class }}"
    {{ $required ? "required" : "" }}
    {{ $multiple ? "multiple" : "" }}
  />
  @error($name)
    <span class="">{{ $message }}</span>
  @enderror
</div>
