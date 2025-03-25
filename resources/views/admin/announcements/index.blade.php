@extends("admin.index")

@section("content")
    <div class="container">
        <div class="min-w-full">
            <div class="py-2 grid grid-cols-3 gap-3 w-full max-w-6xl mx-auto items-center">
                <div></div>
                <div class="flex justify-center">
                    <input
                        type="search"
                        id="announcement-search"
                        class="h-9 w-full max-w-xs px-3 text-sm text-gray-900 border border-gray-400 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-500 dark:text-white"
                        placeholder="Zoek naar Titels, Datums..."
                    />
                </div>
                <div class="flex justify-end">
                    <button onclick="window.location.href='{{ route('announcements.create') }}'" class="btn btn-primary">
                        Nieuwe Aanmaken
                    </button>
                </div>
            </div>

            <div data-datatable="true" data-datatable-page-size="5" data-datatable-state-save="true">
                <div class="scrollable-x-auto">
                    <table id="announcement-table" class="table table-auto border-gray-400" data-datatable-table="true">
                        <thead>
                        <tr>
                            <th class="min-w-[200px] border-b border-gray-400">
                                <span class="sort" data-sort="announcement-date">
                                    <span class="sort-label">Datum & Tijd Aangemaakt</span>
                                    <span class="sort-icon"></span>
                                </span>
                            </th>
                            <th class="w-[185px] border-b border-gray-400">
                                <span class="sort" data-sort="announcement-title">
                                    <span class="sort-label">Titel</span>
                                    <span class="sort-icon"></span>
                                </span>
                            </th>
                            <th class="w-[185px] border-b border-gray-400">Omschrijving</th>
                            <th class="w-[120px] border-b border-gray-400">Image</th>
                            <th class="w-[60px] border-b border-gray-400"></th>
                            <th class="w-[60px] border-b border-gray-400"></th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-800">
                        @foreach ($announcements as $announcement)
                            <tr class="border-b border-gray-300">
                                <td class="announcement-date" data-announcement-date="{{ $announcement->created_at->timestamp }}">
                                    {{ $announcement->created_at->format('d M, Y H:i') }}
                                </td>
                                <td class="announcement-title" data-announcement-title="{{ strtolower($announcement->title) }}">
                                    {{ $announcement->title }}
                                </td>
                                <td>{{ Str::limit($announcement->description, 100) }}</td>
                                <td>
                                    @if($announcement->image)
                                        <img src="{{ asset('storage/' . $announcement->image) }}" class="w-12 h-12 object-cover rounded-md">
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-sm btn-icon btn-clear btn-light">
                                        <i class="ki-outline ki-notepad-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <button
                                        data-modal-toggle="#deleteModal"
                                        data-delete-action="{{ route('announcements.destroy', $announcement->id) }}"
                                        class="btn btn-sm btn-icon btn-clear btn-light delete-btn"
                                    >
                                        <i class="ki-outline ki-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer flex justify-between flex-col md:flex-row gap-3 text-gray-600 text-2sm font-medium mt-4">
                    <div class="flex items-center gap-2">
                        Toon
                        <select class="select select-sm w-16" data-datatable-size="true"></select>
                        per pagina
                    </div>
                    <div class="flex items-center gap-4">
                        <span data-datatable-info="true"></span>
                        <div class="pagination" data-datatable-pagination="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" data-modal="true" id="deleteModal">
        <div class="modal-content max-w-[600px] top-[20%]">
            <div class="modal-header justify-center">
                <h3 class="modal-title text-center">Bevestig verwijderen</h3>
            </div>
            <div class="modal-body text-center">
                Weet je zeker dat je deze aankondiging wilt verwijderen?
            </div>
            <div class="modal-footer flex justify-center">
                <div class="flex gap-3">
                    <button type="button" class="btn btn-secondary" data-modal-dismiss="true">Annuleren</button>
                    @if($announcements->count() > 0)
                        <form method="POST" id="deleteForm" action="{{ route('announcements.destroy', $announcements->first()) }}">
                            @csrf @method("DELETE")
                            <button type="submit" class="btn btn-danger">Verwijderen</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DELETE logica
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteForm = document.getElementById('deleteForm');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const action = button.getAttribute('data-delete-action');
                    deleteForm.setAttribute('action', action);
                });
            });

            // LIVE SEARCH
            const searchInput = document.getElementById('announcement-search');
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase();
                const rows = document.querySelectorAll('#announcement-table tbody tr');
                rows.forEach(row => {
                    const title = row.querySelector('.announcement-title')?.textContent.toLowerCase() || '';
                    const date = row.querySelector('.announcement-date')?.textContent.toLowerCase() || '';
                    const match = title.includes(query) || date.includes(query);
                    row.style.display = match ? '' : 'none';
                });
            });
        });
    </script>
