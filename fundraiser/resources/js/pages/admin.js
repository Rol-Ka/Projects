document.addEventListener("DOMContentLoaded", () => {

    const input = document.getElementById('admin-search');

    input.addEventListener('input', function () {

        const value = this.value;

        fetch(`/admin/stories?search=${value}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(res => res.text())
            .then(html => {
                document.getElementById('stories-container').innerHTML = html;
            });

    });

});