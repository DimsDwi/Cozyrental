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
