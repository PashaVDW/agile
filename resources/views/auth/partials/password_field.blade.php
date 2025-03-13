<div class="w-full text-left mb-3">
    <label class="text-black font-semibold">{{ $label }}</label>
    <div class="input-wrapper relative">
        <input name="{{ $name }}" class="input w-full" placeholder="{{ $placeholder }}" type="password" required />
        <i class="eye-icon ki-filled ki-eye absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer" onclick="togglePassword('{{ $name }}')"></i>
    </div>
    @error($name)
    <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>
