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