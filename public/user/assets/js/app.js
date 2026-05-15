/**
 * app.js
 * Global utilities for the user-side gallery index page.
 * Handles section switching, logout confirmation, and scroll-to-top.
 */

function showSection(sectionId, navElement) {
    const sections = ['home', 'latin-honor', 'departments', 'section-view', 'student-grid-view'];
    sections.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });

    const target = document.getElementById(sectionId);
    if (target) target.style.display = 'block';

    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    if (navElement) navElement.classList.add('active');

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function confirmUserLogout(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Ready to leave?',
        text: 'You will be logged out of E-Gallery.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ff4d4d',
        cancelButtonColor: '#1A1851',
        confirmButtonText: 'Yes, log me out!'
    }).then(result => {
        if (result.isConfirmed) {
            window.location.href = '../../app/controllers/logoutController.php';
        }
    });
}

// Scroll-to-top button visibility
const scrollTopBtn = document.getElementById('scrollTopBtn');
window.addEventListener('scroll', function () {
    scrollTopBtn.classList.toggle('show', window.scrollY > 300);
});

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}