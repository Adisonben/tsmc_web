import './bootstrap';
import './prefix';
import './license_type';
import './carType';

const toggler = document.querySelector(".btn");
const sidebar = document.querySelector("#sidebar");

toggler.addEventListener("click",function(){
    sidebar.classList.toggle("collapsed");
});


// Check screen size on page load and adjust sidebar accordingly
function checkScreenSize() {
    if (window.innerWidth <= 767) {
        sidebar.classList.add("collapsed");
    } else {
        sidebar.classList.remove("collapsed");
    }
}
checkScreenSize(); // Initial check
window.addEventListener("resize", checkScreenSize);


// initialize bootstrap tooltips
const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
