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
                <h2 class="has-background">Agenda's</h2>
                <span class="tip">
                    ?
                    <span class="tooltiptext">
                        Door op de Google agenda knop te klikken wordt je automatisch doorgewezen naar je persoonlijke google agenda waar de concat agenda is toegevoegd.
                        <br />
                        Het downloaden van de agenda is een moment opname van de agenda op dat moment. Dit is een .ics bestand die je kan importeren in je eigen agenda.
                        <br />
                        Webcal is een link die je kan toevoegen aan je agenda. Wijzigingen kunnen enkele ogenblikken duren voordat deze zichtbaar zijn in je agenda.
                    </span>
                </span>
                <br />
                <div class="buttons">
                    <button class="item-button" id="webcal">Webcal</button>
                    <a href="{{ route('calendar.ics') }}" target="_blank" class="button item-button">Download</a>
                    <a href="https://calendar.google.com/calendar/u/0?cid=NTUwYjc2YTM3N2JmNDg2MjNjYWY5MTIzMmY2ZjI1MzI0NWEyNWVkMjYzYmY3OGQ3NmVkNjIwNmJkOWEwMDNjMkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t" class="button item-button">Google agenda</a>
                </div>
                <br />
                @if(auth()->check())
                <x-filters.dropdown :onchange="'this.form.submit()'" label="Filter" name="status" :list="['all' => 'Alle activiteiten', 'my_events' => 'Mijn activiteiten']" value="{{ request('status') }}"/>
                @endif
            </div>
        </div>
    </div>
@stop
