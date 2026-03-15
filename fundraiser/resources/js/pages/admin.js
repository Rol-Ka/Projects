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