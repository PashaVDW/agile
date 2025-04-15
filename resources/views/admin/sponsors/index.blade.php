@extends("admin.index")

@section("content")
    <x-admin.datatable
        :searchAction="route('admin.sponsors.index')"
        :createUrl="route('admin.sponsor.create')"
        createLabel="Voeg sponsor toe"
        tableId="sponsors-table"
        searchPlaceholder="Zoek op naam..."
    >
        <x-slot:thead>
            <th class="min-w-[200px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Naam</th>
            <th class="border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Beschrijving</th>
            <th class="w-[120px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Status</th>
            <th class="w-[120px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Afbeelding</th>
            <th class="w-[60px] border-b border-gray-400 px-4 py-2"></th>
            <th class="w-[60px] border-b border-gray-400 px-4 py-2"></th>
        </x-slot:thead>

        <x-slot:tbody>
            @foreach ($sponsors as $sponsor)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2">{{ $sponsor->name }}</td>
                    <td class="px-4 py-2">{{ $sponsor->description }}</td>
                    <td class="px-4 py-2">{{ $sponsor->active }}</td>
                    <td class="px-4 py-2">
                        @if ($sponsor->image_url)
                            <img src="{{ asset($sponsor->image_url) }}" class="w-12 h-12 object-cover rounded-md" />
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.sponsor.show', ['id' => $sponsor->id]) }}" class="btn btn-sm btn-icon btn-clear btn-light">
                            <i class="ki-outline ki-notepad-edit"></i>
                        </a>
                    </td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('admin.sponsor.delete', ['id' => $sponsor->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-icon btn-clear btn-light" onclick="return confirm('Weet je zeker dat je deze wilt verwijderen?')">
                                <i class="ki-outline ki-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-slot:tbody>
    </x-admin.datatable>

    <div class="mt-4">
        {{ $sponsors->links() }}
    </div>
@endsection
