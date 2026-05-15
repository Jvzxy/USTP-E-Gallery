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

<nav class="navbar navbar-expand-md navbar-dark dashboard-nav px-4">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="#"><?php echo htmlspecialchars($sysNameDisplay); ?></a>

        <!-- Hamburger toggler (mobile only) -->
        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNavCollapse"
                aria-controls="mainNavCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="mainNavCollapse">

            <!-- Center nav pills -->
            <div class="navbar-nav bg-navy-pill p-1 mx-auto mt-3 mt-md-0">
                <a class="nav-link active px-4" href="#" onclick="showSection('home', this)">Home</a>
                <a class="nav-link px-4" href="#" onclick="showSection('latin-honor', this)">Latin Honor</a>
                <a class="nav-link px-4" href="#" onclick="showSection('departments', this)">Department</a>
            </div>

            <!-- Right logout pill -->
            <div class="navbar-nav bg-navy-pill p-1 mt-2 mt-md-0">
                <a class="nav-link px-4 text-danger fw-bold" href="#" onclick="confirmUserLogout(event)">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>

        </div>
    </div>
</nav>