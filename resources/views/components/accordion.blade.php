@props([
    'open' => false,
    'id' => 'accordion-' . uniqid()
])

<div x-data="{ open: {{ $open ? 'true' : 'false' }}, checked: false }" class="mb-5">
    <button
        @click="open = !open"
        :aria-expanded="open"
        :class="{ 'rounded-b-none': open }"
        class="flex w-full items-center justify-between p-4 text-left text-base font-medium bg-transparent rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors dark:border-gray-700 dark:hover:bg-gray-800"
        type="button"
    >
        <div class="flex items-center space-x-4">
            <div class="flex items-center justify-center h-5 w-5 border border-gray-300 bg-white rounded dark:border-gray-600">
                <input 
                    type="checkbox" 
                    :id="'{{ $id }}'"
                    x-model="checked"
                    name="use_discord"
                    @click.stop
                    class="h-4 w-4 rounded border-gray-300 focus:ring-gray-500"
                >
            </div>
            <span class="text-gray-900 dark:text-white">Fire Discord Hook</span>
        </div>
        <svg
            :class="{ 'rotate-180': open }"
            class="h-5 w-5 shrink-0 transition-transform duration-300 text-gray-400"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="rounded-b-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800"
    >
        <div class="space-y-4">
            {{ $slot }}
        </div>
    </div>
</div>
