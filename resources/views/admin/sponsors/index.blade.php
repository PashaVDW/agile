@extends("admin.index")

@section("content")
    <x-admin.datatable
        :searchAction="route('admin.old_boards.index')"
        :createUrl="route('admin.old_boards.create')"
        createLabel="Voeg oud bestuur toe"
        tableId="old-boards-table"
        searchPlaceholder="Zoek op naam of termijn..."
    >
        <x-slot:thead>
            <th class="min-w-[200px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Namen</th>
            <th class="w-[185px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Termijn</th>
            <th class="w-[120px] border-b border-gray-400 px-4 py-2 text-gray-900 font-bold">Afbeelding</th>
            <th class="w-[60px] border-b border-gray-400 px-4 py-2"></th>
            <th class="w-[60px] border-b border-gray-400 px-4 py-2"></th>
        </x-slot:thead>

        <x-slot:tbody>
            @foreach ($oldBoards as $oldBoard)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2">{{ $oldBoard->names }}</td>
                    <td class="px-4 py-2">{{ $oldBoard->term }}</td>
                    <td class="px-4 py-2">
                        @if ($oldBoard->image_url)
                            <img src="{{ asset($oldBoard->image_url) }}" class="w-12 h-12 object-cover rounded-md" />
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.old_boards.show', ['id' => $oldBoard->id]) }}" class="btn btn-sm btn-icon btn-clear btn-light">
                            <i class="ki-outline ki-notepad-edit"></i>
                        </a>
                    </td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('admin.old_boards.delete', ['id' => $oldBoard->id]) }}">
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
        {{ $oldBoards->links() }}
    </div>
@endsection
