/**
 * home.js
 * Featured quote carousel dot indicator sync
 * and college horizontal scroll helper.
 */

document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('featuredCarousel');
    if (carousel) {
        carousel.addEventListener('slide.bs.carousel', function (e) {
            document.querySelectorAll('.carousel-indicators-custom .dot-sm')
                .forEach((dot, idx) => dot.classList.toggle('active', idx === e.to));
        });
    }
});

function scrollColleges(offset) {
    document.getElementById('collegeScrollContainer').scrollBy({ left: offset, behavior: 'smooth' });
}