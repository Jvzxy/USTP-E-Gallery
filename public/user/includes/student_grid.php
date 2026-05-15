<section id="student-grid-view" style="display:none; padding: 20px;">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center">
            <button class="btn-back me-3" onclick="goBackToSections()">
                <i class="bi bi-arrow-left"></i>
            </button>
            <h5 id="current-section-title" class="fw-bold m-0 text-uppercase" style="letter-spacing: 2px; color: var(--navy-dark);">
                SECTION NAME
            </h5>
        </div>
    </div>

    <div class="mb-4 d-flex align-items-center">
        <h6 class="fw-bold text-muted m-0 me-2" style="font-size: 0.9rem;">Class of</h6>
        <select class="form-select form-select-sm w-auto fw-bold text-muted border-secondary cursor-pointer" id="yearSelectGrid" style="font-size: 0.85rem;">
            <?php
            // FETCH DYNAMIC YEARS FROM DB (Using unique variables to prevent scope overlap if included together)
            if (isset($conn)) {
                $grid_yRes = $conn->query("SELECT year FROM class_years ORDER BY year DESC");
                if ($grid_yRes && $grid_yRes->num_rows > 0) {
                    $grid_first = true;
                    while ($grid_row = $grid_yRes->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($grid_row['year']) . '" ' . ($grid_first ? 'selected' : '') . '>' . htmlspecialchars($grid_row['year']) . '</option>';
                        $grid_first = false;
                    }
                } else {
                    echo '<option value="">No years found</option>';
                }
            }
            ?>
        </select>
    </div>

    <div id="student-container" class="row g-3"></div>

    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination custom-pagination" id="grid-pagination"></ul>
        </nav>
    </div>
<script src="assets/js/student_grid.js"></script>
</section>