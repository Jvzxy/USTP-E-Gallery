/**
 * latin_honor.js
 * Handles fetching Latin Honours students by year,
 * client-side name search, and paginated card display.
 */

document.addEventListener('DOMContentLoaded', () => {
    const ITEMS_PER_PAGE = 15;
    let currentPage = 1;
    let allCards    = [];

    const grid                = document.getElementById('latin-grid');
    const paginationContainer = document.getElementById('latin-pagination');
    const yearSelect          = document.getElementById('yearSelectLatin');
    const searchInput         = document.getElementById('search-latin');
    const noResults           = document.getElementById('no-results');

    // ── Fetch ────────────────────────────────────────────────────
    function loadStudentsForYear(year) {
        if (!year) return;

        grid.innerHTML = `
            <div class="text-center w-100 py-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted fw-bold">Loading Honors...</p>
            </div>`;
        allCards = [];

        fetch(`../../app/controllers/getGalleryData.php?action=latin&year=${year}`)
            .then(res => res.json())
            .then(data => {
                grid.innerHTML = '';

                if (data.length === 0) {
                    noResults.style.display = 'block';
                    noResults.innerHTML = `
                        <i class="bi bi-award text-muted" style="font-size:3rem;"></i>
                        <p class="mt-3 text-muted">No Latin Honors recorded for this year.</p>`;
                    paginationContainer.innerHTML = '';
                    return;
                }

                noResults.style.display = 'none';

                data.forEach(student => {
                    const card = document.createElement('div');
                    card.className = 'col-6 col-md-2-4 mb-4 latin-card-item fade-in-up';
                    card.innerHTML = `
                        <div class="honor-profile text-center">
                            <img src="../admin/${student.photo_path}" class="mb-2 shadow-sm" alt="Student"
                                 onerror="this.src='assets/Img/Student/Durain.jpg'">
                            <div class="px-1">
                                <small class="fw-bold text-uppercase d-block text-truncate" title="${student.full_name}">${student.full_name}</small>
                                <small class="text-muted d-block" style="font-size:0.65rem;color:#FFB11B!important;font-weight:bold;">${student.latin_honor.toUpperCase()}</small>
                                <small class="fw-bold">${student.prog_abbr || 'N/A'}</small>
                            </div>
                        </div>`;
                    allCards.push(card);
                    grid.appendChild(card);
                });

                currentPage = 1;
                displayItems(allCards);
            })
            .catch(err => console.error('Error loading latin honors:', err));
    }

    // ── Display & Pagination ─────────────────────────────────────
    function displayItems(cards) {
        allCards.forEach(c => c.style.display = 'none');
        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        cards.slice(start, start + ITEMS_PER_PAGE).forEach(c => c.style.display = 'block');
        renderPagination(cards.length);
    }

    function renderPagination(total) {
        paginationContainer.innerHTML = '';
        const totalPages = Math.ceil(total / ITEMS_PER_PAGE);
        if (totalPages <= 1) return;

        const prev = currentPage === 1 ? 'disabled' : '';
        paginationContainer.innerHTML += `<li class="page-item ${prev}"><a class="page-link prev-next" href="#" onclick="changeLatinPage(event,${currentPage - 1})"><i class="bi bi-chevron-left"></i></a></li>`;

        for (let i = 1; i <= totalPages; i++) {
            const active = currentPage === i ? 'active' : '';
            paginationContainer.innerHTML += `<li class="page-item ${active}"><a class="page-link" href="#" onclick="changeLatinPage(event,${i})">${i}</a></li>`;
        }

        const next = currentPage === totalPages ? 'disabled' : '';
        paginationContainer.innerHTML += `<li class="page-item ${next}"><a class="page-link prev-next" href="#" onclick="changeLatinPage(event,${currentPage + 1})"><i class="bi bi-chevron-right"></i></a></li>`;
    }

    window.changeLatinPage = function (event, newPage) {
        event.preventDefault();
        currentPage = newPage;
        triggerLatinSearch();
    };

    // ── Search ───────────────────────────────────────────────────
    function triggerLatinSearch() {
        const term    = searchInput.value.toLowerCase();
        const matches = allCards.filter(card => {
            const el = card.querySelector('.fw-bold.text-uppercase');
            return el && el.innerText.toLowerCase().includes(term);
        });

        if (matches.length === 0) {
            noResults.style.display = 'block';
            noResults.innerHTML = `<i class="bi bi-person-x" style="font-size:3rem;color:#ccc;"></i><p class="mt-3 text-muted">No students found matching that name.</p>`;
            grid.style.display = 'none';
            paginationContainer.innerHTML = '';
        } else {
            noResults.style.display = 'none';
            grid.style.display = 'flex';
            displayItems(matches);
        }
    }

    // ── Event Listeners ──────────────────────────────────────────
    if (yearSelect) {
        yearSelect.addEventListener('change', () => loadStudentsForYear(yearSelect.value));
        if (yearSelect.value) loadStudentsForYear(yearSelect.value);
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            currentPage = 1;
            triggerLatinSearch();
        });
    }
});