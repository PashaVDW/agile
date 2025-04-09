@extends("layouts.default")

@section("title", "Aankondigingen")

@section("content")
    <div class="section">
        <div class="container has-sidebar">
            <div class="items">
                @foreach($announcements as $announcement)
                    <x-announcement.item :announcement="$announcement" />
                @endforeach
            </div>
            <div class="sidebar">
                <x-announcement.filters />
            </div>
        </div>
        <div class="mt-6">
            {{ $announcements->withQueryString()->links() }}
        </div>
    </div>
@stop
