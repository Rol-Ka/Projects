let pendingForm = null;

document.addEventListener('submit', (e) => {

    const form = e.target.closest('.story-form');
    if (!form) return;

    e.preventDefault();

    // 🔥 parodyti modalą
    const modal = document.getElementById('create-modal');
    modal.classList.add('active');

    pendingForm = form;
});


// CONFIRM
document.getElementById('confirm-create')?.addEventListener('click', async () => {

    if (!pendingForm) return;

    const form = pendingForm;

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

            // 🔥 fallback į normal submit (kad rodytų validation)
            form.submit();
            return;
        }

        // 🔥 hide confirm
        document.getElementById('modal-confirm').style.display = 'none';

        // 🔥 show success
        const successBox = document.getElementById('modal-success');
        successBox.style.display = 'block';

        startCountdown();

    } catch (err) {
        console.error(err);

        // fallback
        form.submit();
    }

});


function startCountdown() {
    let seconds = 5;

    const btn = document.getElementById('continue-btn');

    const interval = setInterval(() => {
        seconds--;

        btn.textContent = `Tęsti (${seconds})`;

        if (seconds <= 0) {
            clearInterval(interval);
            window.location.href = "/dashboard";
        }

    }, 1000);

    btn.onclick = () => {
        window.location.href = "/dashboard";
    };
}


// CANCEL
document.getElementById('cancel-create')?.addEventListener('click', () => {
    closeModal();
});


function closeModal() {
    document.getElementById('create-modal')?.classList.remove('active');
    pendingForm = null;
}