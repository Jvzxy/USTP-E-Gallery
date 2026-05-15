<section id="section-view" style="display:none; padding: 20px;">
    <div class="row mb-5">
        <div class="col-12 d-flex align-items-center">
            <button class="btn-back me-3" onclick="goBackToDepartments()">
                <i class="bi bi-arrow-left"></i>
            </button>
            <h5 id="section-view-title" class="fw-bold m-0 text-uppercase" style="letter-spacing: 2px; color: var(--navy-dark); border-left: 2px solid #dee2e6; padding-left: 15px;">
                AVAILABLE SECTIONS
            </h5>
        </div>
    </div>

    <div id="section-grid" class="row g-4 justify-content-center"></div>

    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination custom-pagination" id="section-pagination">
                </ul>
        </nav>
    </div>
<script src="assets/js/section_view.js"></script>
</section>