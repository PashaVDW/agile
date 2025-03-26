document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const action = button.getAttribute('data-delete-action');
            deleteForm.setAttribute('action', action);
        });
    });

    const searchInput = document.getElementById('announcement-search');
    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#announcement-table tbody tr');
        rows.forEach(row => {
            const title = row.querySelector('.announcement-title')?.textContent.toLowerCase() || '';
            const date = row.querySelector('.announcement-date')?.textContent.toLowerCase() || '';
            const match = title.includes(query) || date.includes(query);
            row.style.display = match ? '' : 'none';
        });
    });
});
