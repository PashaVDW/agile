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

            <div class="mb-5">
                <label for="discordToggle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Discord Bericht
                </label>
                <div class="flex gap-4 items-center">
                    <input type="checkbox" id="discordToggle" class="w-16 h-16 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                    <button type="button" id="openModalBtn" class="button item-button">
                        Discord Bericht Configureren
                    </button>
                </div>
                <div id="discord-preview" class="preview-content dark:bg-gray-700 mt-4" style="display: none;">
                    <h4 class="text-lg font-semibold mb-3 dark:text-white">Discord Bericht Voorbeeld:</h4>
                    <div class="discord-message-card">
                        <div class="message-header">
                            <img src="{{ asset('images/bot-avatar.png') }}" alt="Bot Avatar" class="bot-avatar">
                            <span class="bot-name dark:text-white">Discord Bot</span>
                            <span class="message-timestamp dark:text-gray-400">vandaag om {{ now()->format('H:i') }}</span>
                        </div>
                        <div class="message-content">
                            <div class="message-tag dark:text-blue-400" id="preview-tag"></div>
                            <div id="preview-standard" style="display: none;">
                                <div class="message-title dark:text-white" id="preview-title"></div>
                                <div class="message-description dark:text-gray-300" id="preview-description"></div>
                            </div>
                            <div id="preview-embed" style="display: none;">
                                <div class="discord-embed">
                                    <div class="embed-color-bar"></div>
                                    <div class="embed-rich-content">
                                        <div class="embed-author">
                                            <span class="embed-author-name" id="preview-embed-author"></span>
                                            <a class="embed-author-link" id="preview-embed-author-url" target="_blank"></a>
                                        </div>
                                        <div class="embed-title" id="preview-embed-title"></div>
                                        <div class="embed-description" id="preview-embed-description"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="message-footer dark:text-gray-400">
                            <small>Verzonden naar <span class="channel-name" id="preview-channel"></span></small>
                        </div>
                    </div>
                </div>
                @include('components.discord-modal')
            </div>

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
