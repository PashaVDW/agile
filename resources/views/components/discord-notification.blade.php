@props([
    'discordMessage' => '',
])

<div class="space-y-8 pt-4" x-data="{ 
    messageType: 'normal', 
    webhookName: '',
    message: '{{ $discordMessage }}',
    embed: {
        title: '',
        description: '',
        color: '#E77625',
        authorName: '',
        authorUrl: ''
    }
}">
    <!-- Message Type Selection -->
    <div class="text-center mb-8">
        <label class="block mb-4 text-sm font-medium text-gray-700 dark:text-gray-300">Message Type</label>
        <div class="inline-flex rounded-lg p-1 bg-transparent" role="group">
            <button 
                @click.prevent="messageType = 'normal'" 
                type="button" 
                :class="{ 
                    'border-b-2 border-orange-500 text-gray-900 dark:text-white': messageType === 'normal', 
                    'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white': messageType !== 'normal' 
                }" 
                class="px-6 py-2.5 text-sm font-medium rounded-md transition-all duration-200 mx-2 bg-transparent hover:bg-gray-50/30 dark:hover:bg-gray-700/30"
            >
                Normal
            </button>
            <button 
                @click.prevent="messageType = 'embed'" 
                type="button" 
                :class="{ 
                    'border-b-2 border-orange-500 text-gray-900 dark:text-white': messageType === 'embed', 
                    'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white': messageType !== 'embed' 
                }" 
                class="px-6 py-2.5 text-sm font-medium rounded-md transition-all duration-200 mx-2 bg-transparent hover:bg-gray-50/30 dark:hover:bg-gray-700/30"
            >
                Embed
            </button>
        </div>
    </div>

    <!-- Webhook Name Selection -->
    <div class="mb-7">
        <label for="webhook_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Webhook Name</label>
        <select 
            id="webhook_name" 
            name="webhook_name" 
            x-model="webhookName" 
            class="block w-full rounded-lg border border-gray-300 bg-white p-3.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
        >
            <option value="" selected disabled>Select a webhook</option>
            <option value="general">General Announcements</option>
            <option value="events">Event Notifications</option>
        </select>
    </div>

    <!-- Normal Message Type -->
    <div x-show="messageType === 'normal'" x-transition class="mt-3">
        <div class="mb-7">
            <label for="discord_message" class="block mb-2.5 text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
            <textarea 
                id="discord_message" 
                name="discord_message" 
                rows="5" 
                x-model="message"
                class="block w-full rounded-lg border border-gray-300 bg-white p-3.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                placeholder="Enter your message here..."
            ></textarea>
            <p class="mt-2 text-xs text-gray-500">Format with Markdown: **bold**, *italic*, ~~strikethrough~~, `code`</p>
        </div>

        <div class="mt-5 p-4 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
            <div class="flex items-center mb-2">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                    <span x-text="webhookName ? webhookName.charAt(0).toUpperCase() : 'W'"></span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="webhookName ? (webhookName === 'general' ? 'General Announcements' : 'Event Notifications') : 'Webhook'"></p>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-gray-300 break-words" x-text="message || 'Preview of your message will appear here'"></p>
        </div>
    </div>

    <!-- Embed Message Type -->
    <div x-show="messageType === 'embed'" x-transition class="space-y-6 mt-3">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label for="embed_title" class="block mb-2.5 text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input 
                    type="text" 
                    id="embed_title" 
                    name="embed_title" 
                    x-model="embed.title"
                    class="block w-full rounded-lg border border-gray-300 bg-white p-3.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                    placeholder="Enter embed title"
                >
            </div>
            <div>
                <label for="embed_color" class="block mb-2.5 text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                <div class="flex items-center space-x-3">
                    <input 
                        type="color" 
                        id="embed_color" 
                        name="embed_color" 
                        x-model="embed.color"
                        class="h-10 w-16 rounded-lg border border-gray-300 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600"
                    >
                    <span class="text-sm text-gray-500" x-text="embed.color.toUpperCase()"></span>
                </div>
            </div>
        </div>

        <div>
            <label for="embed_description" class="block mb-2.5 text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea 
                id="embed_description" 
                name="embed_description" 
                rows="4" 
                x-model="embed.description"
                class="block w-full rounded-lg border border-gray-300 bg-white p-3.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                placeholder="Enter embed description"
            ></textarea>
            <div class="mt-2 text-xs text-gray-500">
                <div class="flex flex-wrap gap-2 mt-1">
                    <button @click.prevent="embed.description += '**Bold Text**'" class="px-3 py-1.5 bg-transparent border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-50/30 dark:hover:bg-gray-700/30 hover:text-gray-900 dark:hover:text-white transition-all duration-200 text-sm">
                        <span class="font-bold">B</span>
                    </button>
                    <button @click.prevent="embed.description += '*Italic Text*'" class="px-3 py-1.5 bg-transparent border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-50/30 dark:hover:bg-gray-700/30 hover:text-gray-900 dark:hover:text-white transition-all duration-200 text-sm">
                        <span class="italic">I</span>
                    </button>
                    <button @click.prevent="embed.description += '~~Strikethrough~~'" class="px-3 py-1.5 bg-transparent border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-50/30 dark:hover:bg-gray-700/30 hover:text-gray-900 dark:hover:text-white transition-all duration-200 text-sm">
                        <span class="line-through">S</span>
                    </button>
                    <button @click.prevent="embed.description += '`Code`'" class="px-3 py-1.5 bg-transparent border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-50/30 dark:hover:bg-gray-700/30 hover:text-gray-900 dark:hover:text-white transition-all duration-200 text-sm">
                        <span class="font-mono">{}</span>
                    </button>
                    <button @click.prevent="embed.description += '[Link Text](https://example.com)'" class="px-3 py-1.5 bg-transparent border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-50/30 dark:hover:bg-gray-700/30 hover:text-gray-900 dark:hover:text-white transition-all duration-200 text-sm">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6 dark:border-gray-600">
            <h4 class="mb-4 font-medium text-sm text-gray-700 dark:text-gray-300">Author</h4>
            
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="author_name" class="block mb-2.5 text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input 
                        type="text" 
                        id="author_name" 
                        name="author_name" 
                        x-model="embed.authorName"
                        class="block w-full rounded-lg border border-gray-300 bg-white p-3.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                        placeholder="Author name"
                    >
                </div>
                <div>
                    <label for="author_url" class="block mb-2.5 text-sm font-medium text-gray-700 dark:text-gray-300">URL</label>
                    <input 
                        type="url" 
                        id="author_url" 
                        name="author_url" 
                        x-model="embed.authorUrl"
                        class="block w-full rounded-lg border border-gray-300 bg-white p-3.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                        placeholder="https://example.com"
                    >
                </div>
            </div>
        </div>

        <div class="mt-6 border rounded-lg overflow-hidden">
            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-800 border-b">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                    <span x-text="webhookName ? webhookName.charAt(0).toUpperCase() : 'W'"></span>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="webhookName ? (webhookName === 'general' ? 'General Announcements' : 'Event Notifications') : 'Webhook'"></p>
                </div>
            </div>
            <div class="p-4">
                <div class="border-l-4 rounded-sm pl-3 py-2" :style="'border-color:' + embed.color">
                    <p class="font-medium text-base text-gray-900 dark:text-white" x-text="embed.title || 'Embed Title'"></p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1.5 whitespace-pre-line" x-text="embed.description || 'Embed description will appear here'"></p>
                    <div class="mt-3 text-xs text-gray-500" x-show="embed.authorName">
                        <span x-text="embed.authorName"></span>
                        <span x-show="embed.authorUrl">
                            • <a :href="embed.authorUrl" class="text-blue-500 hover:underline" target="_blank" x-text="embed.authorUrl"></a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 