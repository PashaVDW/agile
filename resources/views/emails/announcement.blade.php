@component('mail::message')
    # 📢 {{ $announcement->title }}

    {{ $announcement->description }}

    @if($announcement->banner)
        {!! "![Banner Image]({$announcement->banner_url})" !!}
    @endif

    @component('mail::button', ['url' => config('app.url')])
        Bekijk op de website
    @endcomponent

    Met vriendelijke groet,<br>
    {{ config('app.name') }}
@endcomponent
