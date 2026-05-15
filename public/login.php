<?php
session_start();
include_once("../app/config/config.php");

$customLogo     = "user/assets/Img/Logo/USTP-Web-Logo.webp";
$sysNameDisplay = "E-Gallery";

if (isset($conn)) {
    $logoRes = $conn->query("SELECT setting_value FROM system_settings WHERE setting_key = 'school_logo' ORDER BY id DESC LIMIT 1");
    if ($logoRes && $logoRes->num_rows > 0) {
        $val = $logoRes->fetch_assoc()['setting_value'];
        if (!empty($val)) $customLogo = $val;
    }

    $nameRes = $conn->query("SELECT setting_value FROM system_settings WHERE setting_key = 'system_name'");
    if ($nameRes && $nameRes->num_rows > 0) {
        $val = $nameRes->fetch_assoc()['setting_value'];
        if (!empty($val)) $sysNameDisplay = $val;
    }
}

// Capture and clear the error before HTML output
$loginError = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($sysNameDisplay); ?> | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="login-container">

        <img src="<?php echo htmlspecialchars($customLogo); ?>" alt="<?php echo htmlspecialchars($sysNameDisplay); ?> Logo" class="logo-img">

        <h2 class="welcome-text">Welcome back to <?php echo htmlspecialchars($sysNameDisplay); ?></h2>
        <p class="sub-text">Enter your username and password to continue.</p>

        <div class="login-card">
            <form id="loginForm" action="../app/controllers/loginController.php" method="POST" autocomplete="on" novalidate>
                <div class="mb-4">
                    <label class="form-label" for="username">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required autocomplete="username">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required autocomplete="current-password">
                </div>
                <div class="mb-4 form-check d-flex align-items-center">
                    <input type="checkbox" class="form-check-input me-2" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <button type="submit" class="btn btn-login w-100 mt-2" name="login">Sign in</button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const usernameInput = document.getElementById("username");
            const rmCheck       = document.getElementById("rememberMe");

            // Restore remembered username
            const remembered = localStorage.getItem("rememberedEGalleryUser");
            if (remembered) {
                usernameInput.value = remembered;
                rmCheck.checked = true;
            }

            document.getElementById("loginForm").addEventListener("submit", function (e) {
                const username = usernameInput.value.trim();
                const password = document.getElementById("password").value.trim();

                if (!username || !password) {
                    e.preventDefault();
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Information",
                        text: "Please enter both your Username and Password.",
                        confirmButtonColor: "#ffb11f",
                        customClass: { popup: "rounded-4", confirmButton: "px-4 py-2 fw-bold rounded-3" }
                    });
                    return;
                }

                // Save or clear remembered username
                if (rmCheck.checked) {
                    localStorage.setItem("rememberedEGalleryUser", username);
                } else {
                    localStorage.removeItem("rememberedEGalleryUser");
                }
            });

            <?php if ($loginError): ?>
            // Show server-side error after page load (Swal is now guaranteed to be loaded)
            Swal.fire({
                icon: "error",
                title: "Login Failed",
                text: <?php echo json_encode($loginError); ?>,
                confirmButtonColor: "#ffb11f",
                customClass: { popup: "rounded-4", confirmButton: "px-4 py-2 fw-bold rounded-3" }
            });
            <?php endif; ?>
        });
    </script>

</body>
</html>