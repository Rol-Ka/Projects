

document.addEventListener("DOMContentLoaded", () => {

    const toggle = document.getElementById("navToggle");
    const links = document.getElementById("navLinks");

    toggle.addEventListener("click", () => {
        links.classList.toggle("active");
        toggle.classList.toggle("open");
    });

});