@extends("layouts.default")

@section("title", "Aankondigingen")

@section("content")
    <div class="section">
        <div class="container has-sidebar">
            <div class="items-wrapper">
                <div class="items">
                    @foreach($announcements as $announcement)
                        <div class="item">
                            <div class="block image-block">
                                <img src="{{ asset($announcement->banner_url) }}" alt="{{ $announcement->banner ? 'Afbeelding voor ' . $announcement->title : '' }}" @if(!$announcement->banner) class="no-image" @endif>
                            </div>
                            <div class="block text-block">
                                <div class="item-header">
                                    <h3 class="has-background">{{ $announcement->title }}</h3>
                                    <h6>Aankondiging</h6>
                                </div>
                                <div class="item-body">
                                    <p>
                                        {!! Str::of(strip_tags($announcement->description))->words(20, '...') !!}
                                    </p>
                                </div>
                                <div class="item-footer">
                                    <span class="button item-button opacity-50 cursor-not-allowed">Lees verder</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-6">
            {{ $announcements->withQueryString()->links() }}
        </div>
    </div>
@endsection
