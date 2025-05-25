document.addEventListener('DOMContentLoaded', function() {
  // --- DOM ELEMENTS ---
  const modal = document.getElementById('myModal');
  if (!modal) {
    console.error("Discord Modal (#myModal) not found.");
    return;
  }

  const openBtn = document.getElementById('openModalBtn');
  const closeButton = modal.querySelector('.close-button');
  const prevButton = modal.querySelector('.step-btn-prev');
  const nextButton = modal.querySelector('.step-btn-next');
  const submitButton = modal.querySelector('.step-btn-submit');
  const tabButtons = modal.querySelectorAll('.tab-button');

  const discordPreviewContainer = document.getElementById('discord-preview');
  const discordToggle = document.getElementById('discordToggle');
  const discordHint = document.getElementById('discord-hint');

  const mainDiscordEnabledInput = document.getElementById('discord_enabled');
  const mainDiscordTypeInput = document.getElementById('discord_type'); // CRITICAL
  const mainDiscordChannelInput = document.getElementById('discord_channel');
  const mainDiscordTagInput = document.getElementById('discord_tag');
  const mainDiscordTitleInput = document.getElementById('discord_title');
  const mainDiscordDescriptionInput = document.getElementById('discord_description');
  const mainDiscordEmbedColorInput = document.getElementById('discord_embed_color');
  const mainDiscordEmbedAuthorInput = document.getElementById('discord_embed_author');

  // --- CONFIGURATION (ensure window.discordConfig is set in Blade) ---
  const discordAppConfig = window.discordConfig || {
    channels: {},
    tags: {},
    defaultColor: '#3498db',
    botName: 'Discord Bot',
  };

  if (!openBtn) {
    console.error("Open Modal Button (#openModalBtn) not found.");
    return;
  }

  // --- EVENT LISTENERS ---
  openBtn.onclick = function(e) {
    e.preventDefault();
    populateModalFieldsFromMainHidden();
    modal.style.display = "flex";
    setTimeout(() => modal.classList.add("show-modal"), 10);
    updateNavButtons();
    updateFormControlsState();
  };

  if (closeButton) closeButton.onclick = closeModal;
  window.onclick = (e) => { if (e.target === modal) closeModal(); };
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && modal.classList.contains('show-modal')) {
      closeModal();
    }
  });

  if (submitButton) {
    submitButton.addEventListener('click', function(e) {
      e.preventDefault();
      saveModalConfigurationToMainHidden();
      updateMainPreview();
      closeModal();
    });
  }

  tabButtons.forEach(button => {
    button.onclick = () => {
      const tabId = button.getAttribute('data-tab');
      if (mainDiscordTypeInput) {
        mainDiscordTypeInput.value = tabId; // Update the MAIN hidden input
      } else {
        console.error("Main hidden input #discord_type not found!");
      }

      tabButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');

      modal.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
      const activeContent = modal.querySelector(`#${tabId}-content`);
      if (activeContent) activeContent.classList.add('active');

      // Reset steps and populate fields for the new tab
      if (activeContent) {
        activeContent.querySelectorAll('.step-page').forEach((sp, idx) => sp.classList.toggle('active', idx === 0));
      }
      populateModalFieldsFromMainHidden(); // Re-populate based on new active tab and main hidden values
      updateNavButtons();
      updateFormControlsState();
    };
  });

  if (nextButton) {
    nextButton.onclick = () => {
      const currentPage = getCurrentActiveStepInActiveTab();
      if (!currentPage) return;
      const nextPage = currentPage.nextElementSibling;
      if (nextPage && nextPage.classList.contains('step-page')) {
        currentPage.classList.remove('active');
        nextPage.classList.add('active');
        updateNavButtons();
        updateFormControlsState();
      }
    };
  }

  if (prevButton) {
    prevButton.onclick = () => {
      const currentPage = getCurrentActiveStepInActiveTab();
      if (!currentPage) return;
      const prevPage = currentPage.previousElementSibling;
      if (prevPage && prevPage.classList.contains('step-page')) {
        currentPage.classList.remove('active');
        prevPage.classList.add('active');
        updateNavButtons();
        updateFormControlsState();
      }
    };
  }

  if (discordToggle) {
    discordToggle.addEventListener('change', function() {
      const isChecked = this.checked;
      if (openBtn) openBtn.disabled = !isChecked;
      if (mainDiscordEnabledInput) mainDiscordEnabledInput.value = isChecked ? '1' : '0';
      if (discordHint) discordHint.style.display = isChecked ? 'none' : 'block';
      if (discordPreviewContainer) discordPreviewContainer.style.display = isChecked ? 'block' : 'none';

      if (!isChecked) {
        // Clear all main Discord hidden fields when disabled
        if (mainDiscordTypeInput) mainDiscordTypeInput.value = 'standard';
        if (mainDiscordChannelInput) mainDiscordChannelInput.value = '';
        if (mainDiscordTagInput) mainDiscordTagInput.value = '';
        if (mainDiscordTitleInput) mainDiscordTitleInput.value = '';
        if (mainDiscordDescriptionInput) mainDiscordDescriptionInput.value = '';
        if (mainDiscordEmbedColorInput) mainDiscordEmbedColorInput.value = discordAppConfig.defaultColor;
        if (mainDiscordEmbedAuthorInput) mainDiscordEmbedAuthorInput.value = '';
      }
      updateMainPreview();
    });
  }

  // --- FUNCTIONS ---
  function closeModal() {
    modal.classList.remove("show-modal");
    setTimeout(() => modal.style.display = "none", 300);
  }

  function toggleFormControls(container, shouldDisable) {
    container.querySelectorAll('input:not([type="hidden"]), select, textarea')
      .forEach(control => control.disabled = shouldDisable);
  }

  function updateFormControlsState() {
    modal.querySelectorAll('.tab-content').forEach(tab => {
      const isTabActive = tab.classList.contains('active');
      tab.querySelectorAll('.step-page').forEach(step => {
        const isStepActive = step.classList.contains('active');
        toggleFormControls(step, !(isTabActive && isStepActive));
      });
    });
  }

  function getCurrentActiveStepInActiveTab() {
    const activeTab = modal.querySelector('.tab-content.active');
    return activeTab ? activeTab.querySelector('.step-page.active') : null;
  }

  function updateNavButtons() {
    const currentPage = getCurrentActiveStepInActiveTab();
    if (!currentPage || !prevButton || !nextButton || !submitButton) {
      if(prevButton) prevButton.style.display = 'none';
      if(nextButton) nextButton.style.display = 'none';
      if(submitButton) submitButton.style.display = 'none';
      return;
    }
    const pageNum = parseInt(currentPage.getAttribute('data-page'));
    const totalPages = currentPage.parentElement.querySelectorAll('.step-page').length;

    prevButton.style.display = pageNum > 1 ? 'block' : 'none';
    nextButton.style.display = pageNum < totalPages ? 'block' : 'none';
    submitButton.style.display = pageNum === totalPages ? 'block' : 'none';
  }

  /**
   * Reads values from the currently active modal inputs
   * and saves them to the main hidden input fields.
   */
  function saveModalConfigurationToMainHidden() {
    if (!mainDiscordTypeInput) {
      console.error("#discord_type (main hidden input) not found during save.");
      return;
    }
    const currentType = mainDiscordTypeInput.value;
    const isEmbed = currentType === 'embed';

    // Determine IDs of modal inputs based on current type
    const channelInputId = `discord_channel${isEmbed ? '_embed' : ''}_modal`;
    const tagInputId = `discord_tag${isEmbed ? '_embed' : ''}_modal`;
    const titleInputId = `discord_title${isEmbed ? '_embed' : ''}_modal`;
    const descriptionInputId = `discord_description${isEmbed ? '_embed' : ''}_modal`;

    // Get values from modal fields
    const modalChannel = document.getElementById(channelInputId)?.value;
    const modalTag = document.getElementById(tagInputId)?.value;
    const modalTitle = document.getElementById(titleInputId)?.value;
    const modalDescription = document.getElementById(descriptionInputId)?.value;

    // Update main hidden input fields
    if (mainDiscordChannelInput) mainDiscordChannelInput.value = modalChannel || '';
    if (mainDiscordTagInput) mainDiscordTagInput.value = modalTag || '';
    if (mainDiscordTitleInput) mainDiscordTitleInput.value = modalTitle || ''; // Title comes from active tab
    if (mainDiscordDescriptionInput) mainDiscordDescriptionInput.value = modalDescription || ''; // Description from active tab

    if (isEmbed) {
      const modalColor = document.getElementById('discord_embed_color_modal')?.value;
      const modalAuthor = document.getElementById('discord_embed_author_modal')?.value;

      if (mainDiscordEmbedColorInput) mainDiscordEmbedColorInput.value = modalColor || discordAppConfig.defaultColor;
      if (mainDiscordEmbedAuthorInput) mainDiscordEmbedAuthorInput.value = modalAuthor || '';
    } else {
      // Clear embed-specific main hidden fields if type is standard
      if (mainDiscordEmbedColorInput) mainDiscordEmbedColorInput.value = discordAppConfig.defaultColor;
      if (mainDiscordEmbedAuthorInput) mainDiscordEmbedAuthorInput.value = '';
    }
  }

  /**
   * Populates the visible modal fields from the main hidden input fields.
   */
  function populateModalFieldsFromMainHidden() {
    if (!mainDiscordTypeInput) return;
    const currentType = mainDiscordTypeInput.value;
    const isEmbed = currentType === 'embed';

    const channelInputId = `discord_channel${isEmbed ? '_embed' : ''}_modal`;
    const tagInputId = `discord_tag${isEmbed ? '_embed' : ''}_modal`;
    const titleInputId = `discord_title${isEmbed ? '_embed' : ''}_modal`;
    const descriptionInputId = `discord_description${isEmbed ? '_embed' : ''}_modal`;

    const modalChannelEl = document.getElementById(channelInputId);
    const modalTagEl = document.getElementById(tagInputId);
    const modalTitleEl = document.getElementById(titleInputId);
    const modalDescriptionEl = document.getElementById(descriptionInputId);

    if (modalChannelEl && mainDiscordChannelInput) modalChannelEl.value = mainDiscordChannelInput.value;
    if (modalTagEl && mainDiscordTagInput) modalTagEl.value = mainDiscordTagInput.value;
    // Title and Description are shared by the main hidden inputs, so populate the active tab's version
    if (modalTitleEl && mainDiscordTitleInput) modalTitleEl.value = mainDiscordTitleInput.value;
    if (modalDescriptionEl && mainDiscordDescriptionInput) modalDescriptionEl.value = mainDiscordDescriptionInput.value;

    if (isEmbed) {
      const modalColorEl = document.getElementById('discord_embed_color_modal');
      const modalAuthorEl = document.getElementById('discord_embed_author_modal');

      if (modalColorEl && mainDiscordEmbedColorInput) modalColorEl.value = mainDiscordEmbedColorInput.value;
      if (modalAuthorEl && mainDiscordEmbedAuthorInput) modalAuthorEl.value = mainDiscordEmbedAuthorInput.value;
    }
  }

  /**
   * Updates the main page preview based on the main hidden input fields.
   */
  function updateMainPreview() {
    if (!mainDiscordTypeInput || !discordPreviewContainer) return;
    if (discordPreviewContainer.style.display === 'none' && discordToggle && !discordToggle.checked) return;

    const currentType = mainDiscordTypeInput.value;
    const isEmbed = currentType === 'embed';

    const channel = mainDiscordChannelInput ? mainDiscordChannelInput.value : '';
    const tag = mainDiscordTagInput ? mainDiscordTagInput.value : '';
    const title = mainDiscordTitleInput ? mainDiscordTitleInput.value : '';
    const description = mainDiscordDescriptionInput ? mainDiscordDescriptionInput.value : '';

    const previewTagEl = document.getElementById('preview-tag');
    if (previewTagEl) {
      const tagData = discordAppConfig.tags[tag];
      previewTagEl.textContent = tagData ? tagData.name : (tag ? `@${tag}` : '');
      previewTagEl.style.display = tag ? 'block' : 'none';
    }

    const channelNameEl = discordPreviewContainer.querySelector('.channel-name');
    if (channelNameEl) {
      const channelData = discordAppConfig.channels[channel];
      channelNameEl.textContent = channelData ? `#${channelData.name}` : (channel ? `#${channel}` : '(Geen kanaal)');
    }

    const previewStandardDiv = document.getElementById('preview-standard');
    const previewEmbedDiv = document.getElementById('preview-embed');

    if (isEmbed) {
      if (previewStandardDiv) previewStandardDiv.style.display = 'none';
      if (previewEmbedDiv) previewEmbedDiv.style.display = 'block';

      const color = mainDiscordEmbedColorInput ? mainDiscordEmbedColorInput.value : discordAppConfig.defaultColor;
      const author = mainDiscordEmbedAuthorInput ? mainDiscordEmbedAuthorInput.value : '';

      const colorBar = previewEmbedDiv.querySelector('.embed-color-bar');
      if (colorBar) colorBar.style.backgroundColor = color;

      const authorContainer = previewEmbedDiv.querySelector('.embed-author');
      const authorNameEl = previewEmbedDiv.querySelector('.embed-author-name');

      if (authorContainer && authorNameEl) {
        if (author) {
          authorContainer.style.display = 'block';
          authorNameEl.textContent = author;
        } else {
          authorContainer.style.display = 'none';
        }
      }

      const embedTitleEl = previewEmbedDiv.querySelector('.embed-title');
      if (embedTitleEl) embedTitleEl.textContent = title;

      const embedDescriptionEl = previewEmbedDiv.querySelector('.embed-description');
      if (embedDescriptionEl && typeof marked !== 'undefined') {
        embedDescriptionEl.innerHTML = description ? marked.parse(description) : '';
      } else if (embedDescriptionEl) {
        embedDescriptionEl.textContent = description;
      }
    } else { // Standard preview
      if (previewStandardDiv) previewStandardDiv.style.display = 'block';
      if (previewEmbedDiv) previewEmbedDiv.style.display = 'none';

      const messageTitleEl = document.getElementById('preview-title'); // Use ID from your preview structure
      const messageDescriptionEl = document.getElementById('preview-description'); // Use ID

      if (messageTitleEl) messageTitleEl.textContent = title;
      if (messageDescriptionEl && typeof marked !== 'undefined') {
        messageDescriptionEl.innerHTML = description ? marked.parse(description) : '';
      } else if (messageDescriptionEl) {
        messageDescriptionEl.textContent = description;
      }
    }
    if(discordPreviewContainer && discordToggle) {
      discordPreviewContainer.style.display = discordToggle.checked ? 'block' : 'none';
    }
  }

  // --- INITIALIZATION ---
  if (discordToggle && mainDiscordEnabledInput) {
    const isInitiallyEnabled = mainDiscordEnabledInput.value === '1';
    discordToggle.checked = isInitiallyEnabled;
    if (openBtn) openBtn.disabled = !isInitiallyEnabled;
    if (discordHint) discordHint.style.display = isInitiallyEnabled ? 'none' : 'block';
    if (discordPreviewContainer) discordPreviewContainer.style.display = isInitiallyEnabled ? 'block' : 'none';
  }

  if (mainDiscordTypeInput && tabButtons.length > 0) {
    const initialType = mainDiscordTypeInput.value || 'standard';
    let tabFoundAndClicked = false;
    tabButtons.forEach(btn => {
      if (btn.getAttribute('data-tab') === initialType) {
        btn.click();
        tabFoundAndClicked = true;
      }
    });
    if (!tabFoundAndClicked && tabButtons.length > 0) tabButtons[0].click();
  } else if (tabButtons.length > 0) {
    tabButtons[0].click();
  } else {
    updateNavButtons();
    updateFormControlsState();
  }
  updateMainPreview();
});
