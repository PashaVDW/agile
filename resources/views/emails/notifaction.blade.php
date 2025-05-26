@component('mail::message')
    <p class="title-text">
        {{ $payload['title'] }}
    </p>

{!! nl2br(e($payload['body'])) !!}

    <br>
    @if(!empty($payload['imageUrl']))
        <img src="{{ asset($payload['imageUrl']) }}" alt="Afbeelding" class="email-image">
    @endif


    @if($payload['type'] === 'announcement')
        @component('mail::button', ['url' => route('user.announcement.show', ['id' => $payload['id']])])
            Bekijk aankondiging
        @endcomponent
    @endif

    @if($payload['type'] === 'event')
        @component('mail::button', ['url' => route('user.event.show', ['id' => $payload['id']])])
            Bekijk evenement op onze site voor meer informatie
        @endcomponent
    @endif

    Met vriendelijke groeten,
    Concat
@endcomponent

