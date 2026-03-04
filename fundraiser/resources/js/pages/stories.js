document.addEventListener("DOMContentLoaded", () => {

    const page = document.body.dataset.page;

    if (page !== "stories") return;

    console.log("stories loaded");
});