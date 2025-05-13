@extends("layouts.default")

@section("title", "Calender")

@section("content")
    <div class="section">
        <div class="container has-sidebar">
            <div class="calender-container">
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
            <div class="sidebar">
                <h1 class="title">Agenda's</h1>
                <a href="{{ route('calendar.ics') }}" target="_blank" class="button item-button">Download</a>
                <a href="https://calendar.google.com/calendar/u/0?cid=NTUwYjc2YTM3N2JmNDg2MjNjYWY5MTIzMmY2ZjI1MzI0NWEyNWVkMjYzYmY3OGQ3NmVkNjIwNmJkOWEwMDNjMkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t" class="button item-button">Google agenda</a>
            </div>
        </div>
    </div>
@stop
