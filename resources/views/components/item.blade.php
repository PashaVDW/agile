@props(['event'])
<div class="item">
    <div class="block image-block">
        <img src="{{ asset($event->image_url)}}" alt="{{ $event->title }}">
    </div>
    <div class="block text-block">
        <div class="item-header">
            <h3 class="has-background">{{$event->title}}</h3>
            <h6>{{__($event->category->value)}}</h6>
        </div>
        <div class="item-body">
            <p>
                {{Str::of($event->description)->words(20, '...')}}
            </p>
        </div>
        <div class="item-footer">
            <a href="{{ route('user.event.show', $event->id) }}" class="button item-button">Lees verder</a>
        </div>
    </div>
</div>
