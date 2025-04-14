@extends("layouts.default")

@section("title", "Aankondigingen")

@section("content")
    <div class="section">
        <div class="container has-sidebar">
            <div class="items">
                @foreach($announcements as $announcement)
                    <x-item
                        :item="$announcement"
                        :alt="$announcement->banner ? 'Afbeelding voor ' . $announcement->title : ''"
                        route=""
                    />
                @endforeach
            </div>
        </div>
        <div class="mt-6">
            {{ $announcements->withQueryString()->links() }}
        </div>
    </div>
@endsection
