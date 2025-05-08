@props(['label' => '', 'placeholder' => 'Zoeken...', 'params' => []])

<form method="GET" action="{{ route(Route::currentRouteName()) }}" class="w-full max-w-xs">
    @foreach($params as $name)
        @if($name === 'search')
            @continue
        @endif
        <input type="hidden" name="{{ $name }}" value="{{ request($name) }}">
    @endforeach
    <x-forms.input-field label="{{$label}}" type="search" name="search" placeholder="{{$placeholder}}" value="{{ request('search') }}" class="h-9 w-full px-3 text-sm text-gray-900 border border-gray-400 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-500 dark:text-white"/>
</form>
