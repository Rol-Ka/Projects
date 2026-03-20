const toggle = document.getElementById('filter-toggle');
const dropdown = document.getElementById('filter-dropdown');

if (toggle && dropdown) {

    toggle.addEventListener('click', () => {
        dropdown.style.display =
            dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
}