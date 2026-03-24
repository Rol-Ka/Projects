document.addEventListener('click', async (e) => {

    const btn = e.target.closest('.like-btn');
    if (!btn) return;

    // 🔥 jei neprisijungęs
    if (!window.isLoggedIn) {
        showToast('Norint uždėti širdutę, turite būti prisijungęs', 'warning');
        return;
    }
    if (btn.dataset.allowed === "0") {
        showToast("Negalite pamėgti šios istorijos", "error");
        return;
    }

    const id = btn.dataset.id;

    try {
        const res = await fetch(`/like/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .content,
                'Accept': 'application/json'
            }
        });

        if (!res.ok) {
            const data = await res.json().catch(() => null);

            showToast(
                data?.message || 'Serverio klaida',
                'error'
            );
            return;
        }

        const data = await res.json();

        btn.querySelector('.like-count').textContent = data.likes;

        const heart = btn.querySelector('.heart');
        heart.classList.toggle('liked', data.liked);

    } catch (err) {
        console.error(err);
        showToast('Ryšio klaida', 'error');
    }

});