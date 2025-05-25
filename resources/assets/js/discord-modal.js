import { marked } from 'marked';

// Get the modal elements
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('myModal');
  const openBtn = document.getElementById('openModalBtn');
  const closeButton = modal.querySelector('.close-button');
  const prevButton = modal.querySelector('.step-btn-prev');
  const nextButton = modal.querySelector('.step-btn-next');
  const submitButton = modal.querySelector('.step-btn-submit');
  const tabButtons = modal.querySelectorAll('.tab-button');
  const discordPreview = document.getElementById('discord-preview');

  // Open modal
  if (openBtn) {
    openBtn.onclick = function(e) {
      e.preventDefault();
      modal.style.display = "flex";
      setTimeout(() => {
        modal.classList.add("show-modal");
      }, 10);
    }
  }

  // Close modal
  function closeModal() {
    modal.classList.remove("show-modal");
    setTimeout(() => {
      modal.style.display = "none";
    }, 300);
  }

  closeButton.onclick = () => closeModal();
  window.onclick = (e) => {
    if (e.target === modal) closeModal();
  };

  // Close with Escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && modal.classList.contains('show-modal')) {
      closeModal();
    }
  });

  // Tab switching
  tabButtons.forEach(button => {
    button.onclick = () => {
      tabButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');

      const tabContents = modal.querySelectorAll('.tab-content');
      tabContents.forEach(content => content.classList.remove('active'));

      const tabId = button.getAttribute('data-tab');
      const activeContent = modal.querySelector(`#${tabId}-content`);
      activeContent.classList.add('active');

      // Reset to first page
      const pages = activeContent.querySelectorAll('.step-page');
      pages.forEach(page => page.classList.remove('active'));
      pages[0].classList.add('active');

      updateNavButtons();
    };
  });

  // Navigation functions
  function getCurrentPage() {
    const activeTab = modal.querySelector('.tab-content.active');
    return activeTab.querySelector('.step-page.active');
  }

  function updateNavButtons() {
    const activeTab = modal.querySelector('.tab-content.active');
    const currentPage = getCurrentPage();
    const pageNum = parseInt(currentPage.getAttribute('data-page'));
    const totalPages = activeTab.querySelectorAll('.step-page').length;

    prevButton.style.display = pageNum > 1 ? 'block' : 'none';
    nextButton.style.display = pageNum < totalPages ? 'block' : 'none';
    submitButton.style.display = pageNum === totalPages ? 'block' : 'none';
  }

  // Preview updates
  function updateStandardPreview(isModalPreview = true) {
    const channel = document.getElementById('standard-channel').value;
    const tag = document.getElementById('standard-tag').value;
    const title = document.getElementById('standard-title').value;
    const description = document.getElementById('standard-description').value;

    // Update channel
    const channelElements = document.querySelectorAll('.channel-name');
    channelElements.forEach(el => {
      el.textContent = channel ? `#${channel}` : '(Geen kanaal geselecteerd)';
    });

    // Update tag
    const tagElements = document.querySelectorAll('.message-tag');
    tagElements.forEach(el => {
      el.textContent = tag ? `@${tag}` : '';
      el.style.display = tag ? 'block' : 'none';
    });

    // Show standard preview, hide embed preview
    const standardPreviews = document.querySelectorAll('#preview-standard, #preview-standard-content');
    const embedPreviews = document.querySelectorAll('#preview-embed, #preview-embed-content');
    
    standardPreviews.forEach(el => el.style.display = 'block');
    embedPreviews.forEach(el => el.style.display = 'none');

    // Update title and description
    const titleElements = document.querySelectorAll('.message-title');
    const descriptionElements = document.querySelectorAll('.message-description');

    titleElements.forEach(el => {
      el.textContent = title || '';
    });

    descriptionElements.forEach(el => {
      el.innerHTML = description ? marked.parse(description) : '(Geen bericht inhoud)';
    });

    // Only show the outside preview when not in modal
    if (!isModalPreview) {
      discordPreview.style.display = 'block';
    }
  }

  function updateEmbedPreview(isModalPreview = true) {
    const channel = document.getElementById('embed-channel').value;
    const tag = document.getElementById('embed-tag').value;
    const color = document.getElementById('embed-color').value;
    const author = document.getElementById('embed-author').value;
    const authorUrl = document.getElementById('embed-author-url').value;
    const title = document.getElementById('embed-title').value;
    const description = document.getElementById('embed-description').value;

    // Update channel
    const channelElements = document.querySelectorAll('.channel-name');
    channelElements.forEach(el => {
      el.textContent = channel ? `#${channel}` : '(Geen kanaal geselecteerd)';
    });

    // Update tag
    const tagElements = document.querySelectorAll('.message-tag');
    tagElements.forEach(el => {
      el.textContent = tag ? `@${tag}` : '';
      el.style.display = tag ? 'block' : 'none';
    });

    // Show embed preview, hide standard preview
    const standardPreviews = document.querySelectorAll('#preview-standard, #preview-standard-content');
    const embedPreviews = document.querySelectorAll('#preview-embed, #preview-embed-content');
    
    standardPreviews.forEach(el => el.style.display = 'none');
    embedPreviews.forEach(el => el.style.display = 'block');

    // Update embed color
    const colorBars = document.querySelectorAll('.embed-color-bar');
    colorBars.forEach(bar => bar.style.backgroundColor = color);

    // Update author
    const authorContainers = document.querySelectorAll('.embed-author');
    const authorNames = document.querySelectorAll('.embed-author-name');
    const authorLinks = document.querySelectorAll('.embed-author-link');

    if (author) {
      authorNames.forEach(el => el.textContent = author);
      if (authorUrl) {
        authorLinks.forEach(el => {
          el.href = authorUrl;
          el.textContent = authorUrl;
          el.style.display = 'inline';
        });
      } else {
        authorLinks.forEach(el => el.style.display = 'none');
      }
      authorContainers.forEach(el => el.style.display = 'flex');
    } else {
      authorContainers.forEach(el => el.style.display = 'none');
    }

    // Update title and description
    const titleElements = document.querySelectorAll('.embed-title');
    const descriptionElements = document.querySelectorAll('.embed-description');

    titleElements.forEach(el => {
      el.textContent = title || '';
    });

    descriptionElements.forEach(el => {
      el.innerHTML = description ? marked.parse(description) : '(Geen embed inhoud)';
    });

    // Only show the outside preview when not in modal
    if (!isModalPreview) {
      discordPreview.style.display = 'block';
    }
  }

  // Navigation event listeners
  nextButton.onclick = (e) => {
    e.preventDefault();
    const currentPage = getCurrentPage();
    const nextPage = currentPage.nextElementSibling;
    if (nextPage) {
      currentPage.classList.remove('active');
      nextPage.classList.add('active');
      updateNavButtons();

      // Update preview in final step
      const activeTab = modal.querySelector('.tab-content.active');
      const isLastPage = nextPage.getAttribute('data-page') === activeTab.querySelectorAll('.step-page').length.toString();
      const isEmbed = activeTab.id === 'embed-content';

      if (isLastPage) {
        if (isEmbed) {
          updateEmbedPreview(true);
        } else {
          updateStandardPreview(true);
        }
      }
    }
  };

  prevButton.onclick = (e) => {
    e.preventDefault();
    const currentPage = getCurrentPage();
    const prevPage = currentPage.previousElementSibling;
    if (prevPage) {
      currentPage.classList.remove('active');
      prevPage.classList.add('active');
      updateNavButtons();
    }
  };

  // Add input event listeners for real-time preview updates in final step only
  const standardInputs = ['standard-channel', 'standard-tag', 'standard-title', 'standard-description'];
  standardInputs.forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', () => {
        const currentPage = getCurrentPage();
        if (currentPage && currentPage.getAttribute('data-page') === '3') {
          updateStandardPreview(true);
        }
      });
    }
  });

  const embedInputs = ['embed-channel', 'embed-tag', 'embed-color', 'embed-author', 'embed-author-url', 'embed-title', 'embed-description'];
  embedInputs.forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', () => {
        const currentPage = getCurrentPage();
        if (currentPage && currentPage.getAttribute('data-page') === '4') {
          updateEmbedPreview(true);
        }
      });
    }
  });

  // Submit handler
  if (submitButton) {
    submitButton.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      
      const activeTab = modal.querySelector('.tab-content.active');
      const isEmbed = activeTab.id === 'embed-content';

      // Update the outside preview
      if (isEmbed) {
        updateEmbedPreview(false);
      } else {
        updateStandardPreview(false);
      }

      closeModal();
    });
  }

  // Initialize navigation buttons
  updateNavButtons();

  // Checkbox toggle functionality
  const checkbox = document.getElementById('discordToggle');
  const configButton = document.getElementById('openModalBtn');
  const hint = document.getElementById('discord-hint');

  function updateButtonState() {
    configButton.disabled = !checkbox.checked;
    hint.classList.toggle('hidden', checkbox.checked);
    
    // Hide preview if unchecked
    if (!checkbox.checked) {
      discordPreview.style.display = 'none';
    }
  }

  if (checkbox) {
    checkbox.addEventListener('change', updateButtonState);
    updateButtonState(); // Initial state
  }
}); 