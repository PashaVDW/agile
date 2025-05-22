@component('mail::message')
    <p style="font-size: 22px; font-weight: bold; margin-bottom: 20px;">
        {{ $payload['title'] }}
    </p>

{!! nl2br(e($payload['body'])) !!}

{{--    @if(!empty($payload['imageUrl']))--}}
{{--        {!! '<img src="' . asset($payload['imageUrl']) . '" alt="Afbeelding" style="max-width: 100%; height: auto;" />' !!}--}}
{{--    @endif--}}


    @if($payload['type'] === 'announcement')
        @component('mail::button', ['url' => route('user.announcement.show', ['id' => $payload['id']])])
            Bekijk aankondiging
        @endcomponent
    @endif

    @if($payload['type'] === 'event')
        @component('mail::button', ['url' => route('user.event.show', ['id' => $payload['id']])])
            Bekijk evenement
        @endcomponent
    @endif

    Met vriendelijke groeten,
    Concat
@endcomponent

