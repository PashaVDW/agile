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
                <div class="space-y-6 pt-2" x-data="{ messageType: 'normal', webhookName: '' }">
                    <!-- Message Type Selection -->
                    <div class="text-center mb-6">
                        <label class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">Message Type</label>
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <button @click="messageType = 'normal'" type="button" :class="{ 'bg-gray-100 text-gray-900': messageType === 'normal', 'bg-white text-gray-700': messageType !== 'normal' }" class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-l-lg focus:z-10 focus:ring-2 focus:ring-gray-500 dark:border-gray-600 dark:text-white">
                                Normal
                            </button>
                            <button @click="messageType = 'embed'" type="button" :class="{ 'bg-gray-100 text-gray-900': messageType === 'embed', 'bg-white text-gray-700': messageType !== 'embed' }" class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-r-lg focus:z-10 focus:ring-2 focus:ring-gray-500 dark:border-gray-600 dark:text-white">
                                Embed
                            </button>
                        </div>
                    </div>

                    <!-- Webhook Name Selection -->
                    <div class="mb-5">
                        <label for="webhook_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Webhook Name</label>
                        <select id="webhook_name" name="webhook_name" x-model="webhookName" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="" selected disabled>Select a webhook</option>
                            <option value="general">General Announcements</option>
                            <option value="events">Event Notifications</option>
                        </select>
                    </div>

                    <!-- Normal Message Type -->
                    <div x-show="messageType === 'normal'" x-transition>
                        <div>
                            <label for="discord_message" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                            <textarea id="discord_message" name="discord_message" rows="5" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Enter your message here...">{{ old('discord_message', $announcement->discord_message ?? '') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Format with Markdown: **bold**, *italic*, ~~strikethrough~~, `code`</p>
                        </div>

                        <div class="mt-4 p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <p class="text-sm text-gray-700 dark:text-gray-300">Preview: New announcement posted!</p>
                        </div>
                    </div>

                    <!-- Embed Message Type -->
                    <div x-show="messageType === 'embed'" x-transition class="space-y-4">
                        <div>
                            <label for="embed_title" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" id="embed_title" name="embed_title" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Enter embed title">
                        </div>

                        <div>
                            <label for="embed_description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea id="embed_description" name="embed_description" rows="3" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Enter embed description"></textarea>
                        </div>

                        <div>
                            <label for="embed_color" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                            <input type="color" id="embed_color" name="embed_color" value="#E77625" class="h-10 w-full rounded-lg border border-gray-300 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600">
                        </div>

                        <div class="border-t border-gray-200 pt-4 dark:border-gray-600">
                            <h4 class="mb-3 font-medium text-sm text-gray-700 dark:text-gray-300">Author</h4>
                            
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label for="author_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <input type="text" id="author_name" name="author_name" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Author name">
                                </div>
                                <div>
                                    <label for="author_url" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">URL</label>
                                    <input type="url" id="author_url" name="author_url" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="https://example.com">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <div class="border-l-4 border-orange-500 pl-3">
                                <p class="font-medium text-gray-900 dark:text-white">Embed Preview</p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">This will be sent as a rich embed to Discord</p>
                            </div>
                        </div>
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
