document.addEventListener('DOMContentLoaded', function() {
    openModal();
});

function openModal() {
    const eventDateInput = document.getElementsByName('start_date')[0];
    const openModalButton = document.getElementById('openModalButton');
    const openModalDeleteButton = document.getElementById('openModalDeleteButton');
    const submitButton = document.getElementById('submitButton');
    const today = new Date().toISOString().split('T')[0];
    const modals = document.getElementsByClassName('modal-wrapper');

    function checkDate() {
        const selectedDate = eventDateInput.value;
        if (selectedDate < today) {
            openModalButton.classList.remove('hidden');
            submitButton.classList.add('hidden');
        } else {
            openModalButton.classList.add('hidden');
            submitButton.classList.remove('hidden');
        }
    }

    function showModal(button) {
        for (let i = 0; i < modals.length; i++) {
            if (modals[i].id === button.getAttribute('data-modal-id')) {
                modals[i].classList.toggle('hidden');
            }
        }
    }
    openModalDeleteButton.addEventListener('click', function () {
        showModal(openModalDeleteButton);
    });

    eventDateInput.addEventListener('change', checkDate);
    openModalButton.addEventListener('click', function () {
        showModal(openModalButton);
    });

    checkDate();
}
