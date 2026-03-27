

document.addEventListener("DOMContentLoaded", () => {

    const toggle = document.getElementById("navToggle");
    const links = document.getElementById("navLinks");
    const overlay = document.getElementById("navOverlay");

    if (!toggle || !links || !overlay) return;

    toggle.addEventListener("click", () => {
        links.classList.toggle("active");
        toggle.classList.toggle("open");
        overlay.classList.toggle("active");
    });

    overlay.addEventListener("click", () => {
        links.classList.remove("active");
        toggle.classList.remove("open");
        overlay.classList.remove("active");
    });

});