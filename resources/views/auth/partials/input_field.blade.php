<div class="w-full text-left mb-3">
    <label class="text-black font-semibold">{{ $label }}</label>
    <input name="{{ $name }}" class="input @error($name) border-red-500 @enderror" placeholder="{{ $placeholder }}" type="{{ $type }}" required />
    @error($name)
    <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>
