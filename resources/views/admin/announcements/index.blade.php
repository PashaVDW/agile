@extends("admin.index")

@section("content")
    <x-admin.datatable
        :searchAction="route('announcements.index')"
        :createUrl="route('announcements.create')"
        createLabel="Nieuwe Announcement Aanmaken"
        tableId="announcement-table"
        searchPlaceholder="Zoek op titel of omschrijving..."
    >
        <x-slot:thead>
            <th class="min-w-[200px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Datum & Tijd Aangemaakt</th>
            <th class="w-[185px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Titel</th>
            <th class="w-[185px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Omschrijving</th>
            <th class="w-[120px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Afbeelding</th>
            <th class="w-[60px] border-b border-gray-400 px-4 py-2"></th>
            <th class="w-[60px] border-b border-gray-400 px-4 py-2"></th>
        </x-slot:thead>

        <x-slot:tbody>
            @foreach ($announcements as $announcement)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2">{{ $announcement->created_at->format('d M, Y H:i') }}</td>
                    <td class="px-4 py-2">{{ $announcement->title }}</td>
                    <td class="px-4 py-2">{{ Str::limit($announcement->description, 100) }}</td>
                    <td class="px-4 py-2">
                        @if ($announcement->image)
                            <img src="{{ asset($announcement->image_url) }}" class="w-12 h-12 object-cover rounded-md" />
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-sm btn-icon btn-clear btn-light">
                            <i class="ki-outline ki-notepad-edit"></i>
                        </a>
                    </td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('announcements.destroy', $announcement->id) }}">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-sm btn-icon btn-clear btn-light" onclick="return confirm('Weet je zeker dat je deze wilt verwijderen?')">
                                <i class="ki-outline ki-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-slot:tbody>
    </x-admin.datatable>
@endsection
