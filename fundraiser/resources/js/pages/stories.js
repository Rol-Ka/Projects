document.addEventListener("DOMContentLoaded", () => {

    const page = document.body.dataset.page;

    if (page !== "stories") return;

    console.log("stories loaded");
});

document.querySelectorAll('.like-btn').forEach(btn => {

    btn.addEventListener('click', async () => {

        const id = btn.dataset.id;

        const res = await fetch(`/like/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await res.json();

        // update count
        btn.querySelector('.like-count').innerText = data.likes;

        // toggle class
        btn.classList.toggle('liked', data.liked);

        // animation
        btn.classList.add('bounce');
        setTimeout(() => btn.classList.remove('bounce'), 300);

    });

});