<section id="departments" style="display:none; padding: 20px;">
    <h4 class="text-center fw-bold mb-5" style="letter-spacing: 2px; color: var(--navy-dark);">DEPARTMENTS</h4>
    
    <div class="row g-4 justify-content-center">
        <?php
        if (isset($conn)) {
            $deptQuery = "SELECT * FROM departments ORDER BY name ASC";
            $deptResult = $conn->query($deptQuery);
            $count = 0;
            
            if ($deptResult && $deptResult->num_rows > 0) {
                while ($dept = $deptResult->fetch_assoc()) {
                    // Alternate colors matching Figma
                    $bgClass = ($count % 2 == 0) ? 'dept-navy' : 'dept-gold';
                    
                    echo '
                    <div class="col-md-4 col-sm-6 fade-in-up">
                        <div class="dept-btn ' . $bgClass . '" data-bs-toggle="modal" data-bs-target="#userDeptModal_' . $dept['id'] . '">
                            ' . htmlspecialchars($dept['name']) . '
                        </div>
                    </div>';
                    $count++;
                }
            } else {
                echo '<div class="text-center text-muted col-12 py-5">No departments added yet.</div>';
            }
        }
        ?>
    </div>
</section>