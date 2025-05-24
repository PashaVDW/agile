@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/discord-modal.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="{{ asset('assets/js/discord-modal.js') }}"></script>
@endpush

<div class="discord-section">
    <label for="discordToggle" class="discord-label">
        Discord Bericht
    </label>
    <div class="discord-controls">
        <div class="discord-checkbox-wrapper">
            <input type="checkbox" id="discordToggle" class="discord-checkbox">
        </div>
        <button type="button" id="openModalBtn" class="discord-button" disabled>
            Discord Bericht Configureren
        </button>
    </div>
    <div id="discord-hint" class="discord-hint">
        Vink het vakje aan om een Discord bericht te configureren
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
</div>

{{-- Discord Modal Component --}}
<div id="myModal" class="modal">
    <div class="modal-content dark:bg-gray-800">
        <span class="close-button dark:text-gray-400">&times;</span>
        <h2 class="text-2xl font-bold mb-6 dark:text-white">Discord Bericht Configureren</h2>

        <div class="tabs">
            <button type="button" class="tab-button active dark:text-gray-300" data-tab="standard">Standaard</button>
            <button type="button" class="tab-button dark:text-gray-300" data-tab="embed">Embed</button>
        </div>

        <div id="standard-content" class="tab-content active">
            <div class="step-pages">
                {{-- Standard Page 1: Channel & Tag --}}
                <div class="step-page active" data-page="1">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Stap 1: Kanaal & Tag Selectie</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="standard-channel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecteer Kanaal:</label>
                            <select id="standard-channel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Selecteer Kanaal --</option>
                                <option value="general">#general</option>
                                <option value="announcements">#announcements</option>
                                <option value="support">#support</option>
                                <option value="off-topic">#off-topic</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="standard-tag" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecteer Tag:</label>
                            <select id="standard-tag" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Selecteer Tag --</option>
                                <option value="everyone">@everyone</option>
                                <option value="here">@here</option>
                                <option value="role-dev">@Developer</option>
                                <option value="role-user">@User</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Standard Page 2: Message Content --}}
                <div class="step-page" data-page="2">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Stap 2: Bericht Inhoud</h3>
                    <div class="form-group">
                        <label for="standard-title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bericht Titel:</label>
                        <input type="text" id="standard-title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Voer bericht titel in">
                    </div>

                    <div class="form-group">
                        <label for="standard-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bericht Inhoud:</label>
                        <textarea id="standard-description" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Voer het bericht in"></textarea>
                    </div>
                </div>

                {{-- Standard Page 3: Review & Send --}}
                <div class="step-page" data-page="3">
                    <form id="standard-form" onsubmit="return false;">
                        <h3 class="text-xl font-semibold mb-4 dark:text-white">Stap 3: Controleren & Versturen</h3>
                        <div class="preview-content dark:bg-gray-700">
                            <h4 class="text-lg font-semibold mb-3 dark:text-white">Live Voorbeeld:</h4>
                            <div class="discord-message-card">
                                <div class="message-header">
                                    <img src="{{ asset('images/bot-avatar.png') }}" alt="Bot Avatar" class="bot-avatar">
                                    <span class="bot-name dark:text-white">Discord Bot</span>
                                    <span class="message-timestamp dark:text-gray-400">vandaag om {{ now()->format('H:i') }}</span>
                                </div>
                                <div class="message-content">
                                    <div class="message-tag dark:text-blue-400" id="preview-standard-tag"></div>
                                    <div class="message-title dark:text-white" id="preview-standard-title"></div>
                                    <div class="message-description dark:text-gray-300" id="preview-standard-description"></div>
                                </div>
                                <div class="message-footer dark:text-gray-400">
                                    <small>Verzonden naar <span class="channel-name" id="preview-standard-channel"></span></small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="embed-content" class="tab-content">
            <div class="step-pages">
                {{-- Embed Page 1: Channel & Tag --}}
                <div class="step-page active" data-page="1">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Stap 1: Kanaal & Tag Selectie</h3>
                    <div class="form-grid-3">
                        <div class="form-group">
                            <label for="embed-channel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecteer Kanaal:</label>
                            <select id="embed-channel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Selecteer Kanaal --</option>
                                <option value="general">#general</option>
                                <option value="announcements">#announcements</option>
                                <option value="support">#support</option>
                                <option value="off-topic">#off-topic</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="embed-tag" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecteer Tag:</label>
                            <select id="embed-tag" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">-- Selecteer Tag --</option>
                                <option value="everyone">@everyone</option>
                                <option value="here">@here</option>
                                <option value="role-dev">@Developer</option>
                                <option value="role-user">@User</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="embed-color" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Embed Kleur:</label>
                            <input type="color" id="embed-color" value="#3498db" class="bg-gray-50 border border-gray-300 rounded-lg w-16 h-10">
                        </div>
                    </div>
                </div>

                {{-- Embed Page 2: Author Info --}}
                <div class="step-page" data-page="2">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Stap 2: Auteur Informatie</h3>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="embed-author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Auteur Naam:</label>
                            <input type="text" id="embed-author" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="bijv. Bot Naam">
                        </div>

                        <div class="form-group">
                            <label for="embed-author-url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Auteur URL (optioneel):</label>
                            <input type="url" id="embed-author-url" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="bijv. https://uw-bot.nl">
                        </div>
                    </div>
                </div>

                {{-- Embed Page 3: Message Content --}}
                <div class="step-page" data-page="3">
                    <h3 class="text-xl font-semibold mb-4 dark:text-white">Stap 3: Bericht Inhoud</h3>
                    <div class="form-group">
                        <label for="embed-title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Embed Titel:</label>
                        <input type="text" id="embed-title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Voer embed titel in">
                    </div>

                    <div class="form-group">
                        <label for="embed-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Embed Tekst (met opmaak):</label>
                        <textarea id="embed-description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Gebruik **vet**, *cursief*, __onderstreept__, ~~doorgestreept~~ voor opmaak."></textarea>
                        <small class="text-gray-500 dark:text-gray-400">Markdown zoals **vet**, *cursief*, `code` wordt ondersteund.</small>
                    </div>
                </div>

                {{-- Embed Page 4: Preview & Send --}}
                <div class="step-page" data-page="4">
                    <form id="embed-form" onsubmit="return false;">
                        <h3 class="text-xl font-semibold mb-4 dark:text-white">Stap 4: Voorbeeld & Versturen</h3>
                        <div class="preview-content dark:bg-gray-700">
                            <h4 class="text-lg font-semibold mb-3 dark:text-white">Live Voorbeeld:</h4>
                            <div class="discord-message-card">
                                <div class="message-header">
                                    <img src="{{ asset('images/bot-avatar.png') }}" alt="Bot Avatar" class="bot-avatar">
                                    <span class="bot-name dark:text-white">Discord Bot</span>
                                    <span class="message-timestamp dark:text-gray-400">vandaag om {{ now()->format('H:i') }}</span>
                                </div>
                                <div class="message-content">
                                    <div class="message-tag dark:text-blue-400" id="preview-embed-tag"></div>
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
                                <div class="message-footer dark:text-gray-400">
                                    <small>Verzonden naar <span class="channel-name" id="preview-embed-channel"></span></small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button type="button" class="button left step-btn-prev" style="display: none;">Vorige</button>
            <button type="button" class="button right step-btn-next">Volgende</button>
            <button type="submit" class="action-button button right step-btn-submit" style="display: none;">Bericht Versturen</button>
        </div>
    </div>
</div>
