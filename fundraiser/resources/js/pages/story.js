


document.addEventListener("DOMContentLoaded", () => {

    const page = document.body.dataset.page;

    if (page !== "story") return;

    let currentIndex = 0;

    const lightbox = document.getElementById('lightbox');
    const img = document.querySelector('.lightbox-img');

    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');

    const images = window.storyImages;

    // 🔥 jei nėra elementų – stop (extra safety)
    if (!lightbox || !img || !nextBtn || !prevBtn) return;

    // OPEN
    document.querySelectorAll('.gallery-open').forEach(el => {
        el.addEventListener('click', () => {
            currentIndex = parseInt(el.dataset.index);
            showImage();
            lightbox.classList.add('active');
        });
    });

    function showImage() {
        img.src = images[currentIndex];
    }

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        showImage();
    });

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage();
    });

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox || e.target.classList.contains('lightbox-close')) {
            lightbox.classList.remove('active');
        }
    });

    let startX = 0;

    lightbox.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
    });

    lightbox.addEventListener('touchend', e => {
        let endX = e.changedTouches[0].clientX;

        if (startX - endX > 50) {
            currentIndex = (currentIndex + 1) % images.length;
            showImage();
        }

        if (endX - startX > 50) {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showImage();
        }
    });

});