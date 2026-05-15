<section id="latin-honor" style="display:none;">
    <div class="row mb-4 align-items-center">
        <div class="col-md-4 d-none d-md-block"></div>
        <div class="col-12 col-md-8 d-flex justify-content-center justify-content-md-end">
            <div class="input-group search-box search-box-responsive">
                <input type="text" id="search-latin" class="form-control rounded-pill" placeholder="Search Latin Honors..." autocomplete="off">
                <span class="position-absolute start-0 top-50 translate-middle-y ms-3" style="z-index: 5; color: #6c757d;">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center mb-4">
        <p class="fw-bold m-0 me-2">Class of</p>
        <select class="form-select form-select-sm w-auto fw-bold border-secondary cursor-pointer" id="yearSelectLatin">
            <?php
            // FETCH DYNAMIC YEARS FROM DB
            if (isset($conn)) {
                $latin_yRes = $conn->query("SELECT year FROM class_years ORDER BY year DESC");
                if ($latin_yRes && $latin_yRes->num_rows > 0) {
                    $latin_first = true;
                    while ($latin_row = $latin_yRes->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($latin_row['year']) . '" ' . ($latin_first ? 'selected' : '') . '>' . htmlspecialchars($latin_row['year']) . '</option>';
                        $latin_first = false;
                    }
                } else {
                    echo '<option value="">No years found</option>';
                }
            }
            ?>
        </select>
    </div>

    <div id="latin-grid" class="row g-3"></div>

    <div id="no-results" class="text-center py-5" style="display: none;">
        <i class="bi bi-person-x" style="font-size: 3rem; color: #ccc;"></i>
        <p class="mt-3 text-muted">No students found matching that name.</p>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination custom-pagination" id="latin-pagination"></ul>
        </nav>
    </div>
<script src="assets/js/latin_honor.js"></script>
</section>