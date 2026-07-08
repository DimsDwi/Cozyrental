import 'aos/dist/aos.css';
import AOS from 'aos';
import Swal from 'sweetalert2';

// Inisialisasi AOS (Animate on Scroll)
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        once: true,
        offset: 50,
    });
});

// Expose Swal globally
window.Swal = Swal;
