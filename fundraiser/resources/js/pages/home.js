document.addEventListener("DOMContentLoaded", () => {

    const page = document.body.dataset.page;

    if (page !== "home") return;

    console.log("Landing page loaded");
});