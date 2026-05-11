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

<header id="heroCarousel" class="carousel slide hero-section" data-bs-ride="carousel">
    <div class="carousel-indicators mb-4" style="z-index: 10;">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active dot"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" class="dot"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" class="dot"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" class="dot"></button>
    </div>

    <div class="carousel-inner h-100">
        
        <div class="carousel-item active h-100 position-relative">
            <video autoplay loop muted playsinline class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; opacity: 0.4;">
                <source src="../../storage/YTDown_YouTube_USTP-Cagayan-de-Oro_Media_4FiSZ9aohpU_001_1080p.mp4" type="video/mp4">
            </video>
            <div class="d-flex flex-column justify-content-center align-items-center h-100 text-white position-relative" style="z-index: 2;">
                <h1 class="display-3 serif-font text-uppercase">Experience</h1>
                <h5 class="fw-bold mt-2">The USTP Journey</h5>
                <p class="fst-italic opacity-75 mt-3">A glimpse into university life and beyond.</p>
            </div>
        </div>

        <div class="carousel-item h-100">
            <div class="d-flex flex-column justify-content-center align-items-center h-100 text-white">
                <h1 class="display-3 serif-font text-uppercase">Welcome to</h1>
                <h5 class="fw-bold mt-2"><?php echo htmlspecialchars($sysNameDisplay); ?></h5>
                <p class="fst-italic opacity-75 mt-3">The <?php echo htmlspecialchars($sysNameDisplay); ?> is the digital version of the physical yearbook.</p>
            </div>
        </div>

        <div class="carousel-item h-100">
            <div class="d-flex flex-column justify-content-center align-items-center h-100 text-white">
                <h1 class="display-3 serif-font text-uppercase">Congratulations</h1>
                <h5 class="fw-bold mt-2">Class of 2029</h5>
                <p class="fst-italic opacity-75 mt-3">"The future belongs to those who believe in the beauty of their dreams."</p>
            </div>
        </div>

        <div class="carousel-item h-100">
            <div class="d-flex flex-column justify-content-center align-items-center h-100 text-white px-3 text-center">
                <h1 class="display-4 serif-font text-uppercase">Preserving Memories</h1>
                <h5 class="fw-bold mt-2">A Digital Legacy</h5>
                <p class="fst-italic opacity-75 mt-3 mx-auto" style="max-width: 800px; line-height: 1.6;">
                    More than just a collection of photos, this platform serves as a living archive honoring the hard work, resilience, and shared experiences of our university community. Explore the gallery to celebrate the achievements of tomorrow's leaders and innovators.
                </p>
            </div>
        </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="z-index: 10;">
        <span class="btn-side-arrow"><i class="bi bi-chevron-left"></i></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="z-index: 10;">
        <span class="btn-side-arrow"><i class="bi bi-chevron-right"></i></span>
    </button>
</header>