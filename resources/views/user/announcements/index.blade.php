@extends("layouts.default")

@section("title", "Aankondigingen")

@section("content")
    <div class="section">
        <div class="container">
            <div class="items-wrapper">
                <div class="items">
                    @foreach($announcements as $announcement)
                        <x-item
                                :item="$announcement"
                                :alt="($announcement->banner ? 'Afbeelding voor ' . $announcement->title : '')"
                                :image="$announcement->banner_url"
                                :route="null"
                        />
                    @endforeach
                </div>
                <div class="container pagination-container">
                    <div class="pagination">
                        {{ $announcements->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
