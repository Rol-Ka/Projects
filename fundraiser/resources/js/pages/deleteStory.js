let deleteForm = null;

document.addEventListener('submit', (e) => {

    const form = e.target.closest('.delete-story-form');
    if (!form) return;

    e.preventDefault();

    deleteForm = form;

    document.getElementById('delete-modal').classList.add('active');
});

document.getElementById('confirm-delete')?.addEventListener('click', async () => {

    if (!deleteForm) return;

    try {
        const res = await fetch(deleteForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(deleteForm)
        });

        const data = await res.json();

        document.getElementById('delete-confirm').style.display = 'none';
        document.getElementById('delete-success').style.display = 'block';

        startDeleteCountdown(data.redirect);

    } catch (err) {
        console.error(err);
    }
});

function startDeleteCountdown(url) {
    let seconds = 5;
    const btn = document.getElementById('delete-continue');

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

document.getElementById('cancel-delete')?.addEventListener('click', () => {
    document.getElementById('delete-modal').classList.remove('active');
    deleteForm = null;
});