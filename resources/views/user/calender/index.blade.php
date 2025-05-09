@extends("layouts.default")

@section("title", "Calender")

@section("content")
    <div class="section">
        <div class="container">
            @if ($events->isNotEmpty())
                <div class="calender">
                    @foreach ($events as $month => $monthEvents)
                        <div class="calender-month">
                            <h1>{{ __($month) }}</h1>
                            <ul>
                                @foreach ($monthEvents as $event)
                                    <li>
                                        <strong>{{ $event->start_date->format('d-m-Y') }}</strong> -
                                        {{ $event->title }}
                                        <i>{{ __($event->category->value) }}</i>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@stop
