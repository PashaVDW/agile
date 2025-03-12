@props([
  "name",
  "required" => false,
  "list",
  "value",
  "class" => "",
])

<div class="mb-4">
  <label class="block text-gray-700 text-sm font-bold mb-1" for="{{ $name }}">
    {{ \Illuminate\Support\Str::of($name)->kebab()->replace("-", " ")->ucfirst() }}
    @if ($required)
      <span class="">*</span>
    @endif
  </label>

    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            class="border border-gray-400 bg-white rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 appearance-none pr-8 {{ $class }}"
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
    </div>
  @error($name)
    <span class="text-xs italic">{{ $message }}</span>
  @enderror
</div>
