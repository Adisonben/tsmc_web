import './bootstrap';
import './prefix';
import './organization';

const toggler = document.querySelector("#nav-toggle-btn");
const toggler2 = document.querySelector("#nav-toggle-btn2");
const sidebar = document.querySelector("#sidebar");
const main = document.querySelector(".main");

function toggleSidebar() {
    if (window.innerWidth <= 767) {
        // Mobile: slide sidebar in/out
        sidebar.classList.toggle("show");
    } else {
        // Desktop: toggle between full and icon-only mode
        sidebar.classList.toggle("sidebar-icon-only");
        main.classList.toggle("sidebar-icon-only-active");
        main.classList.toggle("main-collapsed");
    }
}

toggler.addEventListener("click", toggleSidebar);
toggler2.addEventListener("click", toggleSidebar);


// Check screen size on page load and adjust sidebar accordingly
function checkScreenSize() {
    if (window.innerWidth <= 767) {
        sidebar.classList.remove("sidebar-icon-only");
        sidebar.classList.remove("show");
        main.classList.remove("main-collapsed");
        main.classList.remove("sidebar-icon-only-active");
    } else {
        sidebar.classList.remove("show");
        if (!sidebar.classList.contains("sidebar-icon-only")) {
            main.classList.add("main-collapsed");
            main.classList.remove("sidebar-icon-only-active");
        }
    }
}
checkScreenSize(); // Initial check
window.addEventListener("resize", checkScreenSize);


// initialize bootstrap tooltips
const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
