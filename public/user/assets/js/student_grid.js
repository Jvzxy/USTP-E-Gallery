/**
 * student_grid.js
 * Fetches students for a selected section + year,
 * renders them in a paginated grid, and handles back navigation.
 */

const GRID_PER_PAGE  = 15;
let gridCurrentPage  = 1;
let gridTotalStudents = [];

function goBackToSections() {
    const gridView = document.getElementById('student-grid-view');
    gridView.style.display = 'none';
    gridView.classList.remove('fade-in-up');
    document.getElementById('section-view').style.display = 'block';
}

// ── Year select listener ─────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const gridYearSelect = document.getElementById('yearSelectGrid');
    if (gridYearSelect) {
        gridYearSelect.addEventListener('change', function () {
            const section = document.getElementById('current-section-title').innerText;
            generateSectionStudents(section, this.value);
        });
    }
});

// ── Pagination ───────────────────────────────────────────────────
function renderGridPagination(total) {
    const container  = document.getElementById('grid-pagination');
    container.innerHTML = '';
    const totalPages = Math.ceil(total / GRID_PER_PAGE);
    if (totalPages <= 1) return;

    const prev = gridCurrentPage === 1 ? 'disabled' : '';
    container.innerHTML += `<li class="page-item ${prev}"><a class="page-link prev-next" href="#" onclick="changeGridPage(event,${gridCurrentPage - 1})"><i class="bi bi-chevron-left"></i></a></li>`;

    for (let i = 1; i <= totalPages; i++) {
        const active = gridCurrentPage === i ? 'active' : '';
        container.innerHTML += `<li class="page-item ${active}"><a class="page-link" href="#" onclick="changeGridPage(event,${i})">${i}</a></li>`;
    }

    const next = gridCurrentPage === totalPages ? 'disabled' : '';
    container.innerHTML += `<li class="page-item ${next}"><a class="page-link prev-next" href="#" onclick="changeGridPage(event,${gridCurrentPage + 1})"><i class="bi bi-chevron-right"></i></a></li>`;
}

function displayGridPage() {
    const container = document.getElementById('student-container');
    container.innerHTML = '';

    const start = (gridCurrentPage - 1) * GRID_PER_PAGE;
    gridTotalStudents
        .slice(start, start + GRID_PER_PAGE)
        .forEach(html => container.innerHTML += html);

    renderGridPagination(gridTotalStudents.length);
}

window.changeGridPage = function (event, newPage) {
    event.preventDefault();
    gridCurrentPage = newPage;
    displayGridPage();
};

// ── Fetch students ───────────────────────────────────────────────
function generateSectionStudents(sectionCode, year) {
    if (!year) return;

    gridCurrentPage  = 1;
    gridTotalStudents = [];

    const container = document.getElementById('student-container');
    container.innerHTML = `
        <div class="text-center w-100 py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 fw-bold text-muted">Loading Class...</p>
        </div>`;

    fetch(`../../app/controllers/getGalleryData.php?action=students&section=${encodeURIComponent(sectionCode)}&year=${year}`)
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                container.innerHTML = `
                    <div class="text-center w-100 py-5 text-muted">
                        <i class="bi bi-people" style="font-size:3rem;"></i>
                        <p class="mt-3 fw-bold">No students found in this section yet.</p>
                    </div>`;
                document.getElementById('grid-pagination').innerHTML = '';
                return;
            }

            data.forEach(student => {
                const quote = student.quote ? `"${student.quote}"` : '';
                gridTotalStudents.push(`
                    <div class="col-6 col-md-2-4 mb-4 fade-in-up">
                        <div class="honor-profile text-center">
                            <img src="../admin/${student.photo_path}" class="mb-2 shadow-sm" alt="Student"
                                 onerror="this.src='assets/Img/Student/Durain.jpg'">
                            <div class="px-1">
                                <small class="fw-bold text-uppercase d-block text-truncate" style="font-size:0.7rem;" title="${student.full_name}">${student.full_name}</small>
                                <small class="d-block text-truncate text-muted" style="font-size:0.65rem;font-style:italic;" title="${quote}">${quote}</small>
                            </div>
                        </div>
                    </div>`);
            });

            displayGridPage();
        })
        .catch(err => console.error('Error loading students:', err));
}

// Called from section_view.js onclick
window.openClassYear = function (sectionCode) {
    ['home', 'latin-honor', 'departments', 'section-view'].forEach(id => {
        document.getElementById(id).style.display = 'none';
    });

    const gridView = document.getElementById('student-grid-view');
    gridView.style.display = 'block';
    gridView.classList.add('fade-in-up');

    document.getElementById('current-section-title').innerText = sectionCode;

    const yearEl  = document.getElementById('yearSelectGrid');
    const year    = yearEl ? yearEl.value : '';
    generateSectionStudents(sectionCode, year);
};