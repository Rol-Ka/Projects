const searchInput = document.getElementById('admin-search');

if (searchInput) {

    searchInput.addEventListener('input', function () {

        const params = new URLSearchParams(window.location.search);

        params.set('search', this.value);

        fetch(`/admin/stories?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(res => res.text())
            .then(html => {
                document.getElementById('stories-container').innerHTML = html;
            });

    });

}

window.editTag = function (id) {
    const el = document.getElementById(`edit-${id}`);
    if (el) {
        el.classList.add("active");
    }

}

window.cancelEdit = function (id) {
    const el = document.getElementById(`edit-${id}`);
    if (el) {
        el.classList.remove("active");
    }

}

document.querySelectorAll("textarea").forEach(textarea => {
    textarea.style.height = textarea.scrollHeight + "px";
    textarea.addEventListener("input", function () {
        this.style.height = "auto";
        this.style.height = this.scrollHeight + "px";

    });

});

let pendingForm = null;

function openConfirm(text, form) {

    document.getElementById('admin-confirm-text').textContent = text;
    document.getElementById('admin-confirm-modal').classList.add('active');

    pendingForm = form;
}

document.getElementById('admin-confirm-yes')?.addEventListener('click', () => {

    if (pendingForm) {
        pendingForm.submit();
    }

});

document.getElementById('admin-confirm-no')?.addEventListener('click', () => {

    document.getElementById('admin-confirm-modal')?.classList.remove('active');
    pendingForm = null;

});

const editForm = document.querySelector('.story-edit-form');

if (editForm) {

    editForm.addEventListener('submit', (e) => {

        e.preventDefault();

        openConfirm('Ar tikrai norite išsaugoti pakeitimus?', editForm);

    });

}

document.querySelectorAll('.admin-gallery form').forEach(form => {

    form.addEventListener('submit', (e) => {

        e.preventDefault();

        openConfirm('Ar tikrai norite ištrinti šią nuotrauką?', form);

    });

});

document.querySelectorAll('.tag-remove').forEach(btn => {

    btn.addEventListener('click', (e) => {

        e.preventDefault();

        const formId = btn.getAttribute('form');
        const form = document.getElementById(formId);

        openConfirm('Ar tikrai norite pašalinti šį tagą?', form);

    });

});

document.querySelectorAll('form[action*="approve"]').forEach(form => {

    form.addEventListener('submit', (e) => {

        e.preventDefault();

        openConfirm('Ar tikrai norite patvirtinti šią istoriją?', form);

    });

});


document.querySelectorAll('form[action*="stories"][method="POST"]').forEach(form => {

    if (!form.querySelector('input[name="_method"][value="DELETE"]')) return;

    form.addEventListener('submit', (e) => {

        e.preventDefault();

        openConfirm('Ar tikrai norite ištrinti šią istoriją?', form);

    });

});