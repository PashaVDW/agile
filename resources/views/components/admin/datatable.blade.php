<div class="container">
    <div class="min-w-full">
        <div class="py-2 grid grid-cols-3 gap-3 w-full max-w-6xl mx-auto items-center">
            <div></div>
            <div class="flex justify-center">
                <form method="GET" action="{{ $searchAction }}" class="w-full max-w-xs">
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        class="h-9 w-full px-3 text-sm text-gray-900 border border-gray-400 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-500 dark:text-white"
                        placeholder="{{ $searchPlaceholder ?? 'Zoek...' }}"
                    />
                </form>
            </div>
            <div class="flex justify-end">
                <a href="{{ $createUrl }}" class="btn btn-primary">
                    {{ $createLabel }}
                </a>
            </div>
        </div>

        <div data-datatable="true" data-datatable-page-size="5" data-datatable-state-save="true">
            <div class="scrollable-x-auto">
                <table id="{{ $tableId ?? 'datatable-table' }}" class="table table-auto border-gray-400" data-datatable-table="true">
                    <thead>
                    <tr class="bg-gray-100">
                        {{ $thead }}
                    </tr>
                    </thead>
                    <tbody class="text-gray-800">
                    {{ $tbody }}
                    </tbody>
                </table>
            </div>

            <div class="card-footer flex justify-between flex-col md:flex-row gap-3 text-gray-900 text-2sm font-semibold mt-4">
                <div class="flex items-center gap-2">
                    <span class="font-bold">Toon</span>
                    <select class="select select-sm w-16" data-datatable-size="true"></select>
                    <span class="font-bold">per pagina</span>
                </div>
                <div class="flex items-center gap-4">
                    <span data-datatable-info="true"></span>
                    <div class="pagination" data-datatable-pagination="true"></div>
                </div>
            </div>
        </div>
    </div>
</div>
