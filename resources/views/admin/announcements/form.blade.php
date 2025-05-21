@extends("admin.index")

@section("title", isset($announcement) ? 'Aankondiging bewerken' : 'Aankondiging aanmaken')

@section("content")
    <div class="container max-w-lg mx-auto">
        <div class="mb-4">
            <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Terug naar overzicht
            </a>
        </div>
        <form
            method="POST"
            action="{{ isset($announcement) ? route('admin.announcements.update', $announcement->id) : route('admin.announcements.store') }}"
            enctype="multipart/form-data"
        >
            @csrf
            @if(isset($announcement))
                @method('PUT')
            @endif

            <div class="mb-5">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Titel <span class="text-red-600">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $announcement->title ?? '') }}"
                    placeholder="Vul de titel in"
                    class="bg-gray-50 border @error('title') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required
                />
                @error('title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Omschrijving <span class="text-red-600">*</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="Voer hier de omschrijving in..."
                    class="bg-gray-50 border @error('description') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required
                >{{ old('description', $announcement->description ?? '') }}</textarea>
                @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <x-accordion>
                <div class="space-y-6 pt-2">
                    <div>
                        <label for="discord_webhook" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Webhook URL</label>
                        <input type="text" id="discord_webhook" name="discord_webhook" value="{{ old('discord_webhook', $announcement->discord_webhook ?? '') }}" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="https://discord.com/api/webhooks/...">
                        <p class="mt-1 text-xs text-gray-500">Enter the Discord webhook URL to send the announcement notification to.</p>
                    </div>

                    <div>
                        <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">Message Formatting</label>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <div class="mb-2 flex items-center">
                                    <input id="format_plain" name="message_format" type="radio" value="plain" class="h-4 w-4 border-gray-300 focus:ring-gray-500" checked>
                                    <label for="format_plain" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Plain Text</label>
                                </div>
                                <div class="rounded-lg border border-gray-200 bg-white p-4 text-sm dark:border-gray-600 dark:bg-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300">New announcement: Title</p>
                                </div>
                            </div>
                            <div>
                                <div class="mb-2 flex items-center">
                                    <input id="format_embed" name="message_format" type="radio" value="embed" class="h-4 w-4 border-gray-300 focus:ring-gray-500">
                                    <label for="format_embed" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Embed</label>
                                </div>
                                <div class="rounded-lg border border-gray-200 bg-white p-4 text-sm dark:border-gray-600 dark:bg-gray-700">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Title</p>
                                        <p class="text-gray-700 dark:text-gray-300">New announcement posted!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="discord_message" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Custom Message</label>
                        <textarea id="discord_message" name="discord_message" rows="5" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400" placeholder="Optional custom message to include with the announcement">{{ old('discord_message', $announcement->discord_message ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Format with Markdown: **bold**, *italic*, ~~strikethrough~~, `code`</p>
                    </div>
                </div>
            </x-accordion>
            
            <div class="mb-5">
                <x-forms.input-file name="image" label="Afbeelding" :title="($announcement->title ?? '')" value="{{ $announcement->banner_url ?? '' }}" />
                @error('image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <button
                    type="submit"
                    class="button right"
                >
                    {{ isset($announcement) ? 'Bijwerken' : 'Aanmaken' }}
                </button>
            </div>
        </form>

        @if(isset($announcement))
            <x-actions.crud-delete
                :item="$announcement"
                route="admin.announcements.delete"
                title="Aankondiging verwijderen"
                message="Weet je zeker dat je deze aankondiging wilt verwijderen?"
            />
        @endif

    </div>
@endsection
