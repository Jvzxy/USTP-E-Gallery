/**
 * section_view.js
 * Fetches available sections for a selected program,
 * renders them in a paginated grid, and handles back navigation.
 */

const SECTION_PER_PAGE = 9;
let sectionCurrentPage = 1;
let sectionTotalItems  = [];

function goBackToDepartments() {
    document.getElementById('section-view').style.display  = 'none';
    document.getElementById('departments').style.display   = 'block';
}

window.renderSections = function (programName) {
    // Close any open Bootstrap modal
    const activeModal = document.querySelector('.modal.show');
    if (activeModal) bootstrap.Modal.getInstance(activeModal).hide();

    // Switch view
    document.getElementById('departments').style.display        = 'none';
    document.getElementById('section-view').style.display       = 'block';
    document.getElementById('section-view-title').innerText     = programName.toUpperCase();

    const grid = document.getElementById('section-grid');
    grid.innerHTML = '<div class="text-center w-100 py-5"><div class="spinner-border text-primary" role="status"></div></div>';

    fetch(`../../app/controllers/getGalleryData.php?action=sections&program=${encodeURIComponent(programName)}`)
        .then(res => res.json())
        .then(data => {
            sectionCurrentPage = 1;
            sectionTotalItems  = [];

            if (data.length === 0) {
                grid.innerHTML = '<div class="text-center w-100 py-5 text-muted fw-bold">No sections available for this program yet.</div>';
                document.getElementById('section-pagination').innerHTML = '';
                return;
            }

            data.forEach(sec => {
                sectionTotalItems.push(`
                    <div class="col-md-4 col-sm-6 fade-in-up">
                        <div class="section-card shadow-sm" onclick="openClassYear('${sec.name}')">
                            <div class="section-blur-overlay">
                                <h4 class="fw-bold m-0 text-center px-2">${sec.name}</h4>
                            </div>
                        </div>
                    </div>`);
            });

            displaySectionPage();
        })
        .catch(err => console.error(err));
};

function displaySectionPage() {
    const container = document.getElementById('section-grid');
    container.innerHTML = '';

    const start = (sectionCurrentPage - 1) * SECTION_PER_PAGE;
    sectionTotalItems
        .slice(start, start + SECTION_PER_PAGE)
        .forEach(html => container.innerHTML += html);

    renderSectionPagination(sectionTotalItems.length);
}

function renderSectionPagination(total) {
    const container = document.getElementById('section-pagination');
    container.innerHTML = '';
    const totalPages = Math.ceil(total / SECTION_PER_PAGE);
    if (totalPages <= 1) return;

    const prev = sectionCurrentPage === 1 ? 'disabled' : '';
    container.innerHTML += `<li class="page-item ${prev}"><a class="page-link prev-next" href="#" onclick="changeSectionPage(event,${sectionCurrentPage - 1})"><i class="bi bi-chevron-left"></i></a></li>`;

    for (let i = 1; i <= totalPages; i++) {
        const active = sectionCurrentPage === i ? 'active' : '';
        container.innerHTML += `<li class="page-item ${active}"><a class="page-link" href="#" onclick="changeSectionPage(event,${i})">${i}</a></li>`;
    }

    const next = sectionCurrentPage === totalPages ? 'disabled' : '';
    container.innerHTML += `<li class="page-item ${next}"><a class="page-link prev-next" href="#" onclick="changeSectionPage(event,${sectionCurrentPage + 1})"><i class="bi bi-chevron-right"></i></a></li>`;
}

window.changeSectionPage = function (event, newPage) {
    event.preventDefault();
    sectionCurrentPage = newPage;
    displaySectionPage();
};