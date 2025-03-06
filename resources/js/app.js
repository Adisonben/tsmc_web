import './bootstrap';
import './prefix';
import './organization';

const toggler = document.querySelector("#nav-toggle-btn");
const toggler2 = document.querySelector("#nav-toggle-btn2");
const sidebar = document.querySelector("#sidebar");
const main = document.querySelector(".main");

toggler.addEventListener("click",function(){
    sidebar.classList.toggle("collapsed");
    if (window.innerWidth > 767) {
        main.classList.toggle("collapsed");
    }
});

toggler2.addEventListener("click",function(){
    sidebar.classList.toggle("collapsed");
    if (window.innerWidth > 767) {
        main.classList.toggle("collapsed");
    }
});


// Check screen size on page load and adjust sidebar accordingly
function checkScreenSize() {
    if (window.innerWidth <= 767) {
        sidebar.classList.add("collapsed");
        main.classList.add("collapsed");
    } else {
        sidebar.classList.remove("collapsed");
        main.classList.add("main-collapsed");
    }
}
checkScreenSize(); // Initial check
window.addEventListener("resize", checkScreenSize);


// initialize bootstrap tooltips
const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
