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
  function updateStandardPreview() {
    const channel = document.getElementById('standard-channel').value;
    const tag = document.getElementById('standard-tag').value;
    const title = document.getElementById('standard-title').value;
    const description = document.getElementById('standard-description').value;

    // Update channel
    document.getElementById('preview-channel').textContent = channel ? `#${channel}` : '(Geen kanaal geselecteerd)';

    // Update tag
    const tagPreview = document.getElementById('preview-tag');
    tagPreview.textContent = tag ? `@${tag}` : '';
    tagPreview.style.display = tag ? 'block' : 'none';

    // Show standard preview, hide embed preview
    document.getElementById('preview-standard').style.display = 'block';
    document.getElementById('preview-embed').style.display = 'none';

    // Update title and description
    document.getElementById('preview-title').textContent = title || '';
    document.getElementById('preview-description').innerHTML = description ? marked.parse(description) : '(Geen bericht inhoud)';

    // Show the preview section
    discordPreview.style.display = 'block';
  }

  function updateEmbedPreview() {
    const channel = document.getElementById('embed-channel').value;
    const tag = document.getElementById('embed-tag').value;
    const color = document.getElementById('embed-color').value;
    const author = document.getElementById('embed-author').value;
    const authorUrl = document.getElementById('embed-author-url').value;
    const title = document.getElementById('embed-title').value;
    const description = document.getElementById('embed-description').value;

    // Update channel
    document.getElementById('preview-channel').textContent = channel ? `#${channel}` : '(Geen kanaal geselecteerd)';

    // Update tag
    const tagPreview = document.getElementById('preview-tag');
    tagPreview.textContent = tag ? `@${tag}` : '';
    tagPreview.style.display = tag ? 'block' : 'none';

    // Show embed preview, hide standard preview
    document.getElementById('preview-standard').style.display = 'none';
    document.getElementById('preview-embed').style.display = 'block';

    // Update embed color
    document.querySelector('.embed-color-bar').style.backgroundColor = color;

    // Update author
    const authorNamePreview = document.getElementById('preview-embed-author');
    const authorLinkPreview = document.getElementById('preview-embed-author-url');
    const authorContainer = document.querySelector('.embed-author');

    if (author) {
      authorNamePreview.textContent = author;
      if (authorUrl) {
        authorLinkPreview.href = authorUrl;
        authorLinkPreview.textContent = authorUrl;
        authorLinkPreview.style.display = 'inline';
      } else {
        authorLinkPreview.style.display = 'none';
      }
      authorContainer.style.display = 'flex';
    } else {
      authorContainer.style.display = 'none';
    }

    // Update title and description
    document.getElementById('preview-embed-title').textContent = title || '';
    document.getElementById('preview-embed-description').innerHTML = description ? marked.parse(description) : '(Geen embed inhoud)';

    // Show the preview section
    discordPreview.style.display = 'block';
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

  // Add input event listeners for real-time preview updates
  const standardInputs = ['standard-channel', 'standard-tag', 'standard-title', 'standard-description'];
  standardInputs.forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', updateStandardPreview);
    }
  });

  const embedInputs = ['embed-channel', 'embed-tag', 'embed-color', 'embed-author', 'embed-author-url', 'embed-title', 'embed-description'];
  embedInputs.forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', updateEmbedPreview);
    }
  });

  // Submit handler
  submitButton.onclick = (e) => {
    e.preventDefault();
    const activeTab = modal.querySelector('.tab-content.active');
    const isEmbed = activeTab.id === 'embed-content';

    if (isEmbed) {
      updateEmbedPreview();
    } else {
      updateStandardPreview();
    }

    closeModal();
  };

  // Initialize navigation buttons
  updateNavButtons();

  // Checkbox toggle functionality
  const checkbox = document.getElementById('discordToggle');
  const configButton = document.getElementById('openModalBtn');
  const hint = document.getElementById('discord-hint');
  const preview = document.getElementById('discord-preview');

  function updateButtonState() {
      configButton.disabled = !checkbox.checked;
      hint.classList.toggle('hidden', checkbox.checked);
      
      // Hide preview if unchecked
      if (!checkbox.checked) {
          preview.style.display = 'none';
      }
  }

  if (checkbox) {
      checkbox.addEventListener('change', updateButtonState);
      updateButtonState(); // Initial state
  }
});
