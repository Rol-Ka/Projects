window.showToast = function (message, type = 'success') {
    const container = document.getElementById('toast-container');

    if (!container) return;

    const toast = document.createElement('div');
    toast.classList.add('toast', type);
    toast.innerText = message;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-10px)';
    }, 2500);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}