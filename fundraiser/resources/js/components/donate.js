
let pendingForm = null;

document.addEventListener('submit', (e) => {

    const form = e.target.closest('.donate-box');
    if (!form) return;

    e.preventDefault();

    const input = form.querySelector('.donate-input');
    const amount = input.value;
    const left = parseFloat(form.dataset.left);


    const errorBox = form.querySelector('.input-error');

    // reset
    if (input) input.classList.remove('error');
    if (errorBox) errorBox.textContent = '';

    if (!amount || amount <= 0) {
        if (input) input.classList.add('error');
        if (errorBox) errorBox.textContent = 'Įveskite sumą';

        return;
    }

    if (amount > left) {
        if (input) input.classList.add('error');
        if (errorBox) errorBox.textContent = `Maksimali suma: €${left}`;

        return;
    }

    // 🔥 parodyti modalą
    const modal = document.getElementById('donate-modal');
    const text = document.getElementById('donate-modal-text');

    text.textContent = `Ar tikrai norite paaukoti ${amount}€?`;

    modal.classList.add('active');

    pendingForm = form;
});


document.getElementById('confirm-donate')?.addEventListener('click', async () => {

    if (!pendingForm) return;

    const form = pendingForm;
    const input = form.querySelector('.donate-input');
    const amount = input.value;

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
            showToast(data.message || 'Klaida', 'error');
            return;
        }

        // 🔥 PASLEPIAM CONFIRM
        document.getElementById('modal-confirm').style.display = 'none';

        // 🔥 PARODOM SUCCESS
        const successBox = document.getElementById('modal-success');
        successBox.style.display = 'block';

        document.getElementById('success-text').textContent = `Paaukojote ${amount}€`;

        startCountdown();

    } catch (err) {
        console.error(err);
        showToast('Ryšio klaida', 'error');
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
            location.reload();
        }

    }, 1000);

    // manual click
    btn.onclick = () => {
        location.reload();
    };
}

document.getElementById('cancel-donate')?.addEventListener('click', () => {
    closeModal();
});

function closeModal() {
    document.getElementById('donate-modal')?.classList.remove('active');
    pendingForm = null;
}