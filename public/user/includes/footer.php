<?php
$sysNameDisplay = 'E-Gallery'; // Fallback
if (isset($conn)) {
    $sysNameQuery = $conn->query("SELECT setting_value FROM system_settings WHERE setting_key = 'system_name'");
    if ($sysNameQuery && $sysNameQuery->num_rows > 0) {
        $row = $sysNameQuery->fetch_assoc();
        $sysNameDisplay = $row['setting_value'];
    }
}
?>

<body>
    <footer class="user-footer py-5">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h4 class="fw-bold text-white mb-3"><?php echo htmlspecialchars($sysNameDisplay); ?></h4>
                    <p class="footer-text mb-4">The <?php echo htmlspecialchars($sysNameDisplay); ?> is the digital version of the physical yearbook.</p>

                    <div class="d-flex flex-column align-items-start">
                        <a href="https://www.linkedin.com/in/jussy-jay-durain-218739373/" class="linkedin-icon">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <span class="linkedin-label">LinkedIn</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <h4 class="fw-bold text-white mb-3">Contact</h4>
                    <ul class="list-unstyled">
                        <li><a href="mailto:durain.jussyjay@gmail.com" class="footer-link">durain.jussyjay@gmail.com</a>
                        </li>
                        <li><a href="mailto:molo.kairos@gmail.com" class="footer-link">molo.kairos@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>