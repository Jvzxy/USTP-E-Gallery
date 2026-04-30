<?php 
include_once("../../app/middleware/user.php");
// Ensure Database connection is available for the user side
include_once("../../app/config/config.php");

// --- MAINTENANCE MODE CHECK ---
$maintQuery = "SELECT setting_value FROM `system_settings` WHERE setting_key = 'maintenance_mode' ORDER BY id DESC LIMIT 1";
$maintRes = $conn->query($maintQuery);
if ($maintRes && $maintRes->num_rows > 0) {
    $maintRow = $maintRes->fetch_assoc();
    // If maintenance is ON, kick the standard user to the maintenance screen
    if ($maintRow['setting_value'] === '1') {
        header("Location: ../maintenance.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Gallery | Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/departments.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/student_grid.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/section_view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/modals.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/home.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/hero.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/footer.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/latin_honor.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/index.css?v=<?php echo time(); ?>">
    

</head>
<body>

    <?php include('includes/navbar.php'); ?>
    <?php include('includes/hero.php'); ?>

    <main class="container py-5">
        <?php include('includes/home.php'); ?>
        <?php include('includes/latin_honor.php'); ?>
        
        <?php include('includes/departments.php'); ?>
        <?php include('includes/section_view.php'); ?>
        <?php include('includes/student_grid.php'); ?>
    </main>

    <?php include('includes/footer.php'); ?>
    
    <?php include('includes/modals.php'); ?>

    <button id="scrollTopBtn" onclick="scrollToTop()" title="Go to top">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showSection(sectionId, navElement) {
            const sections = ['home', 'latin-honor', 'departments', 'section-view', 'student-grid-view'];
            sections.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });

            const target = document.getElementById(sectionId);
            if (target) target.style.display = 'block';

            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            if (navElement) navElement.classList.add('active');
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function confirmUserLogout(event) {
            event.preventDefault(); 
            Swal.fire({
                title: 'Ready to leave?', text: "You will be logged out of E-Gallery.", icon: 'question',
                showCancelButton: true, confirmButtonColor: '#ff4d4d', cancelButtonColor: '#1A1851', confirmButtonText: 'Yes, log me out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../../app/controllers/logoutController.php";
                }
            });
        }

        const scrollTopBtn = document.getElementById("scrollTopBtn");
        window.onscroll = function() {
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                scrollTopBtn.classList.add("show");
            } else {
                scrollTopBtn.classList.remove("show");
            }
        };

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>