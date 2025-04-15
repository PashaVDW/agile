@extends("admin.index")

@section("title", "Events")

@section("content")
    <div class="container has-sliders">
        <x-admin.datatable
            :searchAction="route('admin.events.index')"
            :createUrl="route('admin.event.create')"
            createLabel="Event aanmaken"
            tableId="events-table"
            searchPlaceholder="Zoek op titel..."
        >
            <x-slot:thead>
                <th class="border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Titel</th>
                <th class="border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Datum / Start datum</th>
                <th class="border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Categorie</th>
                <th class="border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Aangemaakt op</th>
                <th class="border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Bijgewerkt op</th>
                <th class="border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Banner</th>
                <th class="border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Acties</th>
            </x-slot:thead>

            <x-slot:tbody>
                @foreach ($events as $event)
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2">
                            {{ Str::of($event->title)->words(5, '...') }}
                            <span>{{ $event->status->name === 'ARCHIVED' ? '(' . __('ARCHIVED') . ')' : '' }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $event->getFormattedDate($event->start_date) }}</td>
                        <td class="px-4 py-2">{{ __($event->category->value) }}</td>
                        <td class="px-4 py-2">{{ $event->getFormattedDate($event->created_at) }}</td>
                        <td class="px-4 py-2">{{ $event->getFormattedDate($event->updated_at) }}</td>
                        <td class="px-4 py-2">
                            <img src="{{ asset($event->banner_url) }}" class="w-12 h-12 object-cover rounded-md" />
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.event.show', ['id' => $event->id]) }}" class="text-blue-600 hover:underline">Bewerken</a>
                        </td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-admin.datatable>

        <div class="mt-4">
            {{ $events->links() }}
        </div>

        <div class="sliders mt-10">
            <form method="POST" action="{{ route('admin.home-images.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-forms.input-file name="gallery" label="Home galerij" :multiple="true" :gallery="$homeImages ?? []" />
                <button type="submit" class="button right">Opslaan</button>
            </form>
        </div>
    </div>
@endsection
