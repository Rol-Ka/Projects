// let pendingEditForm = null;

// // SUBMIT (tik edit)
// document.addEventListener('submit', (e) => {

//     const form = e.target.closest('.story-form-edit');
//     if (!form) return;

//     // e.preventDefault();

//     document.getElementById('edit-modal').classList.add('active');

//     pendingEditForm = form;
// });

// // CONFIRM
// document.getElementById('confirm-edit')?.addEventListener('click', async () => {

//     if (!pendingEditForm) return;

//     const form = pendingEditForm;

//     try {
//         const res = await fetch(form.action, {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//                 'Accept': 'application/json'
//             },
//             body: new FormData(form)
//         });

//         const data = await res.json();

//         if (!res.ok) {
//             alert(data.message || 'Klaida');
//             return;
//         }

//         document.getElementById('modal-confirm-edit').style.display = 'none';
//         document.getElementById('modal-success-edit').style.display = 'block';

//         startEditCountdown(data.redirect);

//     } catch (err) {
//         console.error(err);
//         alert('Ryšio klaida');
//     }
// });

// // COUNTDOWN
// function startEditCountdown(url) {

//     let seconds = 5;
//     const btn = document.getElementById('continue-edit-btn');

//     const interval = setInterval(() => {

//         seconds--;
//         btn.textContent = `Tęsti (${seconds})`;

//         if (seconds <= 0) {
//             clearInterval(interval);
//             window.location.href = url;
//         }

//     }, 1000);

//     btn.onclick = () => {
//         window.location.href = url;
//     };
// }

// // CANCEL
// document.getElementById('cancel-edit')?.addEventListener('click', () => {
//     document.getElementById('edit-modal')?.classList.remove('active');
//     pendingEditForm = null;
// });


let pendingEditForm = null;

const editForm = document.querySelector('.story-form-edit');

if (editForm) {
    editForm.addEventListener('submit', (e) => {

        e.preventDefault();

        // 🔥 paprasta front validacija
        const title = editForm.querySelector('[name="title"]').value.trim();
        const content = editForm.querySelector('[name="content"]').value.trim();
        const goal = editForm.querySelector('[name="goal_amount"]').value.trim();

        // išvalom senas klaidas
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

        if (hasError) return;

        document.getElementById('edit-modal')?.classList.add('active');

        pendingEditForm = editForm;
    });
}

document.getElementById('confirm-edit')?.addEventListener('click', async () => {

    if (!pendingEditForm) return;

    const form = pendingEditForm;

    const formData = new FormData();

    // 🔥 TEXT INPUTAI
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    formData.append('_method', 'PUT');

    formData.append('title', form.querySelector('[name="title"]').value);
    formData.append('content', form.querySelector('[name="content"]').value);
    formData.append('goal_amount', form.querySelector('[name="goal_amount"]').value);
    formData.append('tags_text', document.getElementById('tags-hidden').value);

    // 🔥 MAIN IMAGE
    const mainInput = document.getElementById('main-image-input');
    if (mainInput.files[0]) {
        formData.append('main_image', mainInput.files[0]);
    }

    // 🔥 DELETE MAIN
    const deleteMain = document.getElementById('delete-main-image');
    if (deleteMain && deleteMain.value) {
        formData.append('delete_main_image', deleteMain.value);
    }

    // 🔥 DELETE GALLERY
    document.querySelectorAll('input[name="delete_images[]"]:checked')
        .forEach(input => {
            formData.append('delete_images[]', input.value);
        });

    // 🔥 GALLERY FILES (SVARBIAUSIA DALIS)
    const galleryInput = document.getElementById('gallery-input');

    if (galleryInput && galleryInput.files.length > 0) {
        for (let i = 0; i < galleryInput.files.length; i++) {
            formData.append('gallery_images[]', galleryInput.files[i]);
        }
    }

    // 🔥 DEBUG
    console.log([...formData.entries()]);

    try {

        const res = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await res.json();

        if (!res.ok) {

            // 🔥 išvalom senas klaidas
            document.querySelectorAll('.input-error').forEach(el => el.remove());
            document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));

            if (data.errors) {

                Object.entries(data.errors).forEach(([field, messages]) => {

                    const input = document.querySelector(`[name="${field}"]`);

                    if (!input) return;

                    // 🔥 PRIDEDAM RAUDONĄ BORDERĮ
                    input.classList.add('error');

                    const errorDiv = document.createElement('div');
                    errorDiv.classList.add('input-error');
                    errorDiv.textContent = messages[0];

                    input.closest('.form-group')?.appendChild(errorDiv);
                });

            }

            return;
        }

        document.getElementById('modal-confirm-edit').style.display = 'none';
        document.getElementById('modal-success-edit').style.display = 'block';

        startCountdown(data.redirect);

    } catch (err) {
        console.error(err);
        alert('Ryšio klaida');
    }
});

function startCountdown(url) {

    let seconds = 30;
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

document.getElementById('cancel-edit')?.addEventListener('click', () => {
    document.getElementById('edit-modal')?.classList.remove('active');
    pendingEditForm = null;
});
function showError(field, message) {

    const input = document.querySelector(`[name="${field}"]`);
    if (!input) return;

    input.classList.add('error');

    const errorDiv = document.createElement('div');
    errorDiv.classList.add('input-error');
    errorDiv.textContent = message;

    input.closest('.form-group')?.appendChild(errorDiv);
}