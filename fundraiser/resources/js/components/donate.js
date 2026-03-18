document.addEventListener('submit', async (e) => {

    const form = e.target.closest('.donate-box');
    if (!form) return;

    e.preventDefault();

    if (!window.isLoggedIn) {
        showToast('Norint aukoti, turite būti prisijungęs', 'warning');
        return;
    }

    const input = form.querySelector('.donate-input');
    const errorBox = form.querySelector('.input-error');

    // 🔥 reset
    input.classList.remove('error');
    errorBox.textContent = '';

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

            // 🔥 VALIDATION ERROR
            if (res.status === 422 && data.errors) {
                const msg = data.errors.amount?.[0];

                input.classList.add('error');
                errorBox.textContent = msg;

                return;
            }

            showToast(data.message || 'Klaida', 'error');
            return;
        }

        showToast(data.message || 'Auka sėkminga 🎉', 'success');

        form.reset();

        location.reload();

    } catch (err) {
        console.error(err);
        showToast('Ryšio klaida', 'error');
    }

});