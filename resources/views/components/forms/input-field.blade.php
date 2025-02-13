@props(['name', 'required' => false, 'value', 'class' => '', 'type' => 'text'])

<div class="">
    <label class="" for="{{ $name }}">
        {{ \Illuminate\Support\Str::of($name)->kebab()->replace('-', ' ')->ucfirst() }}
        @if($required)
            <span class="">*</span>
        @endif
    </label>
    <input type="{{$type}}" name="{{ $name }}" value="{{ $value }}" class="{{$class}} " {{ $required ? 'required' : '' }}>
    @error($name)
        <span class="">{{ $message }}</span>
    @enderror
</div>
