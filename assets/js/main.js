import 'aos/dist/aos.css';
import AOS from 'aos';
import Swal from 'sweetalert2';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/themes/dark.css';

// Inisialisasi AOS (Animate on Scroll)
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        once: true,
        offset: 50,
    });

    // Inisialisasi Flatpickr
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        minDate: "today",
        theme: "dark"
    });
});

// Expose Swal globally
window.Swal = Swal;

// Custom Cursor Logic
const cursorDot = document.querySelector('.cursor-dot');
const cursorOutline = document.querySelector('.cursor-outline');

if (cursorDot && cursorOutline) {
    window.addEventListener('mousemove', (e) => {
        const posX = e.clientX;
        const posY = e.clientY;
        
        cursorDot.style.left = posX + 'px';
        cursorDot.style.top = posY + 'px';
        
        cursorOutline.animate({
            left: posX + 'px',
            top: posY + 'px'
        }, { duration: 500, fill: 'forwards' });
    });
}

