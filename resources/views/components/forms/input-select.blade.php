@props([
  "name",
  "required" => false,
  "list",
  "value",
  "class" => "",
])

<div class="">
  <label class="" for="{{ $name }}">
    {{ \Illuminate\Support\Str::of($name)->kebab()->replace("-", " ")->ucfirst() }}
    @if ($required)
      <span class="">*</span>
    @endif
  </label>
  <select
    name="{{ $name }}"
    id="{{ $name }}"
    class="{{ $class }}"
    {{ $required ? "required" : "" }}
  >
    <option value="">Select a {{ $name }}</option>
    @foreach ($list as $code => $typeName)
      <option
        value="{{ $typeName }}"
        {{ $typeName == $value ? "selected" : "" }}
      >
        {{ $typeName }}
      </option>
    @endforeach
  </select>
  @error($name)
    <span class="">{{ $message }}</span>
  @enderror
</div>
