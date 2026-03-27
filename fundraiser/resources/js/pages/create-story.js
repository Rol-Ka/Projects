let pendingForm = null;

document.addEventListener('submit', (e) => {

    const form = e.target.closest('.story-form-create');
    if (!form) return;

    e.preventDefault();

    const title = form.querySelector('[name="title"]').value.trim();
    const content = form.querySelector('[name="content"]').value.trim();
    const goal = form.querySelector('[name="goal_amount"]').value.trim();
    const mainImage = form.querySelector('[name="main_image"]');

    document.querySelectorAll('.input-error').forEach(el => el.remove());
    document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));

    let hasError = false;

    if (!title) {
        showError('title', 'Įveskite pavadinimą');
        hasError = true;
    }

    if (!content) {
        showError('content', 'Įveskite aprašymą');
        hasError = true;
    }

    if (!goal) {
        showError('goal_amount', 'Įveskite tikslinę sumą');
        hasError = true;
    }
    if (!mainImage.files.length) {
        showError('main_image', 'Pasirinkite pagrindinę nuotrauką');
        hasError = true;
    }
    if (mainImage.files[0] && mainImage.files[0].size > 2 * 1024 * 1024) {
        showError('main_image', 'Nuotrauka per didelė (max 2MB)');
        hasError = true;
    }

    if (hasError) return;

    document.getElementById('create-modal')?.classList.add('active');

    pendingForm = form;
});

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

            form.submit();
            return;
        }

        document.getElementById('modal-confirm').style.display = 'none';
        const successBox = document.getElementById('modal-success');
        successBox.style.display = 'block';

        startCountdown();

    } catch (err) {
        console.error(err);
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

document.getElementById('cancel-create')?.addEventListener('click', () => {
    closeModal();
});


function closeModal() {
    document.getElementById('create-modal')?.classList.remove('active');
    pendingForm = null;
}

function showError(field, message) {

    const input = document.querySelector(`[name="${field}"]`);
    if (!input) return;

    input.classList.add('error');

    const errorDiv = document.createElement('div');
    errorDiv.classList.add('input-error');
    errorDiv.textContent = message;

    input.closest('.form-group')?.appendChild(errorDiv);
}

document.querySelectorAll('.story-form input, .story-form textarea').forEach(input => {

    input.addEventListener('input', () => {

        input.classList.remove('error');

        const error = input.closest('.form-group')?.querySelector('.input-error');
        if (error) error.remove();

    });

});