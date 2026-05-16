<?php 
include_once("../../app/middleware/user.php");
include_once("../../app/config/config.php");


$maintQuery = "SELECT setting_value FROM `system_settings` WHERE setting_key = 'maintenance_mode' ORDER BY id DESC LIMIT 1";
$maintRes = $conn->query($maintQuery);
if ($maintRes && $maintRes->num_rows > 0) {
    $maintRow = $maintRes->fetch_assoc();
    if ($maintRow['setting_value'] === '1') {
        header("Location: ../maintenance");
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

    
    <script src="assets/js/app.js?v=<?php echo time(); ?>"></script>
</body>
</html>