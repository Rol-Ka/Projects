let pendingEditForm = null;

// SUBMIT (tik edit)
document.addEventListener('submit', (e) => {

    const form = e.target.closest('.story-form-edit');
    if (!form) return;

    e.preventDefault();

    document.getElementById('edit-modal').classList.add('active');

    pendingEditForm = form;
});

// CONFIRM
document.getElementById('confirm-edit')?.addEventListener('click', async () => {

    if (!pendingEditForm) return;

    const form = pendingEditForm;

    try {
        const res = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(form)
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.message || 'Klaida');
            return;
        }

        document.getElementById('modal-confirm-edit').style.display = 'none';
        document.getElementById('modal-success-edit').style.display = 'block';

        startEditCountdown(data.redirect);

    } catch (err) {
        console.error(err);
        alert('Ryšio klaida');
    }
});

// COUNTDOWN
function startEditCountdown(url) {

    let seconds = 5;
    const btn = document.getElementById('continue-edit-btn');

    const interval = setInterval(() => {

        seconds--;
        btn.textContent = `Tęsti (${seconds})`;

        if (seconds <= 0) {
            clearInterval(interval);
            window.location.href = url;
        }

    }, 1000);

    btn.onclick = () => {
        window.location.href = url;
    };
}

// CANCEL
document.getElementById('cancel-edit')?.addEventListener('click', () => {
    document.getElementById('edit-modal')?.classList.remove('active');
    pendingEditForm = null;
});