<?php
include_once("../../app/middleware/admin.php");
include_once("../../app/config/config.php");

// Fetch ALL Sections so JavaScript can use them
$allSections = [];
if (isset($conn)) {
    $secRes = $conn->query("SELECT * FROM sections ORDER BY name ASC");
    if ($secRes && $secRes->num_rows > 0) {
        while($row = $secRes->fetch_assoc()) {
            $allSections[] = $row;
        }
    }
}

$allYears = [];
$yearRes = $conn->query("SELECT * FROM class_years ORDER BY year DESC");
if ($yearRes && $yearRes->num_rows > 0) {
    while($row = $yearRes->fetch_assoc()) {
        $allYears[] = $row;
    }
}

// Fetch the default year from settings
$defaultYear = '2029'; // Fallback
$setRes = $conn->query("SELECT setting_value FROM system_settings WHERE setting_key = 'default_class_year'");
if ($setRes && $setRes->num_rows > 0) {
    $defaultYear = $setRes->fetch_assoc()['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Upload - E-Gallery</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="assets/css/upload.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/upload_photo.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/settings_modal.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="assets/css/upload_user.css?v=<?php echo time(); ?>">

</head>

<body>
    <script>
        function applyGlobalTheme(mode) {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = mode === 'dark' || (mode === 'system' && prefersDark);
            document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
        }
        const savedTheme = localStorage.getItem('themeMode') || 'light';
        applyGlobalTheme(savedTheme);

        if (localStorage.getItem('sidebarState') === 'collapsed') {
            document.body.classList.add('sidebar-collapsed');
        }


    </script>

    <div class="d-flex">
        <?php include('includes/sidebar.php'); ?>

        <main class="content-area p-5" id="content-area">
            
            <div class="d-flex align-items-center mb-4 d-md-none">
                <button class="mobile-toggle-btn shadow-sm me-3" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h3 class="fw-bold m-0 text-dark">Upload Management</h3>
            </div>

            <?php include('includes/upload_photo.php'); ?>

        </main>
    </div> 

    <?php include('includes/upload_user.php'); ?>
    <?php include('includes/upload_section.php'); ?>
    <?php include('includes/settings_modal.php'); ?>

    <script>
        window.dbDepartments = <?php echo json_encode($allDepartments ?? []); ?>;
        window.dbPrograms = <?php echo json_encode($allPrograms ?? []); ?>;
        window.dbSections = <?php echo json_encode($allSections ?? []); ?>;
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/admin.js?v=<?php echo time(); ?>"></script>
    <script src="assets/js/upload.js?v=<?php echo time(); ?>"></script>
    <script src="assets/js/upload-photo.js?v=<?php echo time(); ?>"></script>
    <script src="assets/js/upload-user.js?v=<?php echo time(); ?>"></script>
    <script src="assets/js/settings.js?v=<?php echo time(); ?>"></script>
</body>
</html>