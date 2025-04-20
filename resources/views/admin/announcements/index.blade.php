@extends("admin.index")

@section("content")
    <div class="container">
        <div class="min-w-full">
            <div class="py-2 grid grid-cols-3 gap-3 w-full max-w-6xl mx-auto items-center">
                <div></div>
                <div class="flex justify-center">
                    <form method="GET" action="{{ route('admin.announcements.index') }}" class="w-full max-w-xs">
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            class="h-9 w-full px-3 text-sm text-gray-900 border border-gray-400 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-500 dark:text-white"
                            placeholder="Zoek op titel of omschrijving..."
                        />
                    </form>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                        Nieuwe Announcement Aanmaken
                    </a>
                </div>
            </div>

            <div data-datatable="true" data-datatable-page-size="5" data-datatable-state-save="true">
                <div class="scrollable-x-auto">
                    <table id="announcement-table" class="table table-auto border-gray-400" data-datatable-table="true">
                        <thead>
                        <tr>
                            <th class="min-w-[200px] border-b border-gray-400">Datum & Tijd Aangemaakt</th>
                            <th class="w-[185px] border-b border-gray-400">Titel</th>
                            <th class="w-[185px] border-b border-gray-400">Omschrijving</th>
                            <th class="w-[120px] border-b border-gray-400">Afbeelding</th>
                            <th class="w-[60px] border-b border-gray-400"></th>
                            <th class="w-[60px] border-b border-gray-400"></th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-800">
                        @foreach ($announcements as $announcement)
                            <tr class="border-b border-gray-300">
                                <td>{{ $announcement->created_at->format('d M, Y H:i') }}</td>
                                <td>{{ $announcement->title }}</td>
                                <td>{{ Str::limit($announcement->description, 100) }}</td>
                                <td>
                                    @if ($announcement->image)
                                        <img src="{{ $announcement->banner_url }}" class="w-12 h-12 object-cover rounded-md" />
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-icon btn-clear btn-light">
                                        <i class="ki-outline ki-notepad-edit"></i>
                                    </a>
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
@endsection
