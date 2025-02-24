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

@props(['name', 'required' => false, 'enum' => null, 'list' => [], 'value', 'class' => ''])

<div class="">
    <label class="" for="{{ $name }}">
        {{ \Illuminate\Support\Str::of($name)->kebab()->replace('-', ' ')->ucfirst() }}
        @if($required)
            <span class="">*</span>
        @endif
    </label>

    <select name="{{ $name }}" id="{{ $name }}" class="{{$class}} " {{ $required ? 'required' : '' }} >
        <option value="">Select a {{ $name }}</option>
        @if($enum)
            @foreach($enum::cases() as $item)
                <option value="{{ $item->value }}" {{ $item->name == $value ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        @else
            @foreach($list as $key => $item)
                <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}>
                    {{ $item }}
                </option>
            @endforeach
        @endif
    </select>
    @error($name)
    <span class="">{{ $message }}</span>
    @enderror
</div>
