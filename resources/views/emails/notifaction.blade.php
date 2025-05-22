@component('mail::message')
    # {{ $payload['title'] }}

    {{ $payload['body'] }}

{{--    @if(!empty($payload['imageUrl']))--}}
{{--        {!! '<img src="' . asset($payload['imageUrl']) . '" alt="Afbeelding" style="max-width: 100%; height: auto;" />' !!}--}}
{{--    @endif--}}

    @isset($payload['btnUrl'])
        @component('mail::button', ['url' => $payload['btnUrl']])
            {{ $payload['btnText'] ?? 'Bekijk op de website' }}
        @endcomponent
    @endisset

    Met vriendelijke groeten,
    Concat
@endcomponent
