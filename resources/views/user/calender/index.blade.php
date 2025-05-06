@extends("layouts.default")

@section("title", "Calender")

@section("content")
    <div class="section">
        <div class="container">
            <div class="calender">
                @foreach ($events->groupBy(function($event) {
                    return $event->start_date->format('F');
                }) as $month => $monthEvents)
                    <div class="calender-month">
                        <h1>{{ __($month) }}</h1>
                        <ul>
                            @foreach ($monthEvents as $event)
                                <li>
                                    <strong>{{ $event->start_date->format('d-m-Y') }} </strong> -
                                    {{ __($event->category->value) }} -
                                    {{ $event->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
