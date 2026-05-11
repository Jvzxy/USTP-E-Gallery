<?php
// INCLUDE YOUR DATABASE CONNECTION HERE
// Example: include 'db_connection.php'; 
// Assuming your connection variable is $conn

$graduateCount = 0;
$collegeCount = 0;
$programCount = 0;

// Fetch Live Student/Graduate Count
$queryGrads = "SELECT COUNT(*) as count FROM student_profiles";
$resultGrads = mysqli_query($conn, $queryGrads);
if ($resultGrads && $row = mysqli_fetch_assoc($resultGrads)) {
    $graduateCount = $row['count'];
}

// Fetch Live Colleges/Departments Count
$queryDepts = "SELECT COUNT(*) as count FROM departments";
$resultDepts = mysqli_query($conn, $queryDepts);
if ($resultDepts && $row = mysqli_fetch_assoc($resultDepts)) {
    $collegeCount = $row['count'];
}

// Fetch Live Programs Count
$queryProgs = "SELECT COUNT(*) as count FROM programs";
$resultProgs = mysqli_query($conn, $queryProgs);
if ($resultProgs && $row = mysqli_fetch_assoc($resultProgs)) {
    $programCount = $row['count'];
}
?>

<section id="home">
    <h5 class="fw-bold mb-4">Recently</h5>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="yearbook-card">
                <img src="assets/Img/Student/TABANIAG, J-VHONNE L IMG_4870.jpeg" alt="Valedictory Address">
                <div class="card-overlay">
                    <h6>VALEDICTORY ADDRESS</h6>
                    <p>As we enter the next chapter, preparing for board exams or seeking jobs – and if the path <br> ahead seems impossible, don't forget that you've already conquered so much and endured even more.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="yearbook-card">
                <img src="assets/Img/Student/Cabanlit, Anika Jasmine.jpg" alt="Valedictory Address">
                <div class="card-overlay">
                    <h6>VALEDICTORY ADDRESS</h6>
                    <p>The version of you that the world needs already within you.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="yearbook-card">
                <img src="assets/Img/Student/Fugnit, Remiel Charles.jpg" alt="Valedictory Address">
                <div class="card-overlay">
                    <h6>VALEDICTORY ADDRESS</h6>
                    <p>Together, we have grown and now we help others grow.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-5 py-4 text-center border-top border-bottom">
        <div class="col-md-3 col-6">
            <h2 class="display-4 fw-bold mb-0" style="color: var(--navy-dark);"><?php echo number_format($graduateCount); ?></h2>
            <p class="text-uppercase text-secondary small fw-bold" style="letter-spacing: 2px;">Graduates</p>
        </div>
        <div class="col-md-3 col-6">
            <h2 class="display-4 fw-bold mb-0" style="color: var(--navy-dark);"><?php echo $collegeCount; ?></h2>
            <p class="text-uppercase text-secondary small fw-bold" style="letter-spacing: 2px;">Colleges</p>
        </div>
        <div class="col-md-3 col-6">
            <h2 class="display-4 fw-bold mb-0" style="color: var(--navy-dark);"><?php echo $programCount; ?></h2>
            <p class="text-uppercase text-secondary small fw-bold" style="letter-spacing: 2px;">Programs</p>
        </div>
        <div class="col-md-3 col-6">
            <h2 class="display-4 fw-bold mb-0" style="color: var(--navy-dark);">1</h2>
            <p class="text-uppercase text-secondary small fw-bold" style="letter-spacing: 2px;">Community</p>
        </div>
    </div>



    <div class="mt-5 pt-4">
        <h5 class="fw-bold mb-4">Explore by College</h5>

        <div class="college-carousel-wrapper">
            <button class="carousel-nav-btn carousel-btn-left" onclick="scrollColleges(-300)" aria-label="Scroll left">
                <i class="bi bi-chevron-left fs-5"></i>
            </button>

            <div class="college-scroll-container" id="collegeScrollContainer">

                <div class="college-card-item">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 bg-light-gray rounded-4 d-flex flex-column">
                        <i class="bi bi-gear-fill fs-1 mb-3" style="color: var(--navy-dark);"></i>
                        <h6 class="fw-bold">Engineering</h6>
                        <p class="small text-secondary mb-3">Building the foundations of tomorrow.</p>
                        <button class="btn btn-link text-decoration-none small fw-bold p-0 mt-auto" style="color: var(--navy-dark);" data-bs-toggle="modal" data-bs-target="#modalEngineering">
                            Learn More &rarr;
                        </button>
                    </div>
                </div>

                <div class="college-card-item">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 bg-light-gray rounded-4 d-flex flex-column">
                        <i class="bi bi-laptop fs-1 mb-3" style="color: var(--navy-dark);"></i>
                        <h6 class="fw-bold">Computer Science & Info Systems</h6>
                        <p class="small text-secondary mb-3">Innovating the digital landscape.</p>
                        <button class="btn btn-link text-decoration-none small fw-bold p-0 mt-auto" style="color: var(--navy-dark);" data-bs-toggle="modal" data-bs-target="#modalCSIS">
                            Learn More &rarr;
                        </button>
                    </div>
                </div>

                <div class="college-card-item">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 bg-light-gray rounded-4 d-flex flex-column">
                        <i class="bi bi-cpu-fill fs-1 mb-3" style="color: var(--navy-dark);"></i>
                        <h6 class="fw-bold">Technology</h6>
                        <p class="small text-secondary mb-3">Applied technical expertise.</p>
                        <button class="btn btn-link text-decoration-none small fw-bold p-0 mt-auto" style="color: var(--navy-dark);" data-bs-toggle="modal" data-bs-target="#modalTech">
                            Learn More &rarr;
                        </button>
                    </div>
                </div>

                <div class="college-card-item">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 bg-light-gray rounded-4 d-flex flex-column">
                        <i class="bi bi-heart-pulse-fill fs-1 mb-3" style="color: var(--navy-dark);"></i>
                        <h6 class="fw-bold">Life Sciences</h6>
                        <p class="small text-secondary mb-3">Exploring living systems and health.</p>
                        <button class="btn btn-link text-decoration-none small fw-bold p-0 mt-auto" style="color: var(--navy-dark);" data-bs-toggle="modal" data-bs-target="#modalLifeSci">
                            Learn More &rarr;
                        </button>
                    </div>
                </div>

                <div class="college-card-item">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 bg-light-gray rounded-4 d-flex flex-column">
                        <i class="bi bi-tree-fill fs-1 mb-3" style="color: var(--navy-dark);"></i>
                        <h6 class="fw-bold">Natural Sciences</h6>
                        <p class="small text-secondary mb-3">Discovering the physical universe.</p>
                        <button class="btn btn-link text-decoration-none small fw-bold p-0 mt-auto" style="color: var(--navy-dark);" data-bs-toggle="modal" data-bs-target="#modalNatSci">
                            Learn More &rarr;
                        </button>
                    </div>
                </div>

                <div class="college-card-item">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 bg-light-gray rounded-4 d-flex flex-column">
                        <i class="bi bi-people-fill fs-1 mb-3" style="color: var(--navy-dark);"></i>
                        <h6 class="fw-bold">Social Sciences</h6>
                        <p class="small text-secondary mb-3">Understanding human society.</p>
                        <button class="btn btn-link text-decoration-none small fw-bold p-0 mt-auto" style="color: var(--navy-dark);" data-bs-toggle="modal" data-bs-target="#modalSocSci">
                            Learn More &rarr;
                        </button>
                    </div>
                </div>

                <div class="college-card-item">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 bg-light-gray rounded-4 d-flex flex-column">
                        <i class="bi bi-palette-fill fs-1 mb-3" style="color: var(--navy-dark);"></i>
                        <h6 class="fw-bold">Art and Humanities</h6>
                        <p class="small text-secondary mb-3">Celebrating creativity and culture.</p>
                        <button class="btn btn-link text-decoration-none small fw-bold p-0 mt-auto" style="color: var(--navy-dark);" data-bs-toggle="modal" data-bs-target="#modalArtHum">
                            Learn More &rarr;
                        </button>
                    </div>
                </div>

            </div>

            <button class="carousel-nav-btn carousel-btn-right" onclick="scrollColleges(300)" aria-label="Scroll right">
                <i class="bi bi-chevron-right fs-5"></i>
            </button>
        </div>
    </div>

    <div id="featuredCarousel" class="carousel slide quote-container mt-5 pt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="yearbook-card rounded-0" style="height: 400px;">
                            <img src="assets/Img/Student/TUBA, SHANE ABBY.png" alt="Featured student">
                            <div class="card-overlay">
                                <h6 class="text-uppercase m-0">Valedictory Address</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-light-gray p-5">
                        <p class="fs-5 italic mb-4">"We did not survive – we created our own way forward. We turned every hardship into a stepping stone. And wherever we go next, may continue making paths for ourselves and for those who will come after us."</p>
                        <div class="mt-2">
                            <div class="fw-bold fs-5">Ms. Shane Abby Tuba</div>
                            <div class="text-secondary small">Class of 2029</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="yearbook-card rounded-0" style="height: 400px;">
                            <img src="assets/Img/Student/Caboverde, Chanice.JPG" alt="Featured student">
                            <div class="card-overlay">
                                <h6 class="text-uppercase m-0">Valedictory Address</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-light-gray p-5">
                        <p class="fs-5 italic mb-4">"The journey was never easy, but the view from the top makes every struggle worth it. To the Class of 2029, we made it."</p>
                        <div class="mt-2">
                            <div class="fw-bold fs-5">Ms. Chanice Caboverde</div>
                            <div class="text-secondary small">Class of 2029</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="yearbook-card rounded-0" style="height: 400px;">
                            <img src="assets/Img/Student/Justiniani, Jonathan.jpg" alt="Featured student">
                            <div class="card-overlay">
                                <h6 class="text-uppercase m-0">Valedictory Address</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-light-gray p-5">
                        <p class="fs-5 italic mb-4">"Education is the most powerful weapon which you can use to change the world. Let's go change it together."</p>
                        <div class="mt-2">
                            <div class="fw-bold fs-5">Mr. Jonathan Justiniani</div>
                            <div class="text-secondary small">Class of 2029</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-controls-container">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-navy-small rounded-circle p-0" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev" style="width:35px; height:35px;">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="carousel-indicators-custom d-flex gap-1">
                    <div class="dot-sm active" data-bs-target="#featuredCarousel" data-bs-slide-to="0"></div>
                    <div class="dot-sm" data-bs-target="#featuredCarousel" data-bs-slide-to="1"></div>
                    <div class="dot-sm" data-bs-target="#featuredCarousel" data-bs-slide-to="2"></div>
                </div>

                <button class="btn btn-navy-small rounded-circle p-0" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next" style="width:35px; height:35px;">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-5 mb-4 align-items-center bg-light-gray rounded-4 overflow-hidden shadow-sm" style="min-height: 400px;">
        <div class="col-md-6 p-5">
            <h6 class="text-uppercase mb-3" style="color: var(--navy-dark); font-weight: bold; letter-spacing: 2px;">University Legacy</h6>
            <h2 class="fw-bold mb-4">Shaping Tomorrow's Leaders</h2>
            <p class="text-secondary" style="line-height: 1.8;">
                The E-Gallery is a living testament to the unwavering dedication of our student body. It encapsulates years of rigorous academic pursuit, groundbreaking research, and transformative community engagements that define the university experience.
            </p>
            <p class="text-secondary" style="line-height: 1.8;">
                As a premier institution of science and technology, we take immense pride in producing trailblazers equipped to navigate and innovate in a complex global landscape. Every profile here represents a unique journey of resilience, excellence, and the relentless pursuit of knowledge.
            </p>
        </div>
        <div class="col-md-6 p-0 h-100 d-flex">
            <img src="../../storage/USTP_Main.jfif" alt="USTP Campus" class="w-100 object-fit-cover" style="min-height: 400px;">
        </div>
    </div>

    <div class="row mt-5 mb-4 text-center rounded-4 p-5 shadow" style="background-color: var(--navy-dark); color: white;">
        <div class="col-12 py-4">
            <h2 class="fw-bold mb-3">Join the Alumni Community</h2>
            <p class="mb-4 mx-auto" style="max-width: 600px; color: #e0e0e0;">
                Engage in discussions, share career opportunities, ask questions, and stay connected with fellow graduates in our exclusive community forums.
            </p>
            <a href="community.php" class="btn btn-light fw-bold px-4 py-2 rounded-pill text-uppercase" style="color: var(--navy-dark); letter-spacing: 1px;">Join the Conversation</a>
        </div>
    </div>

    <div class="modal fade" id="modalEngineering" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--navy-dark);">Engineering (CEA)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <p class="text-secondary mb-0">Dedicated to advancing technological solutions through rigorous engineering principles, innovation, and practical application. We shape the creators and builders of modern infrastructure and sustainable systems.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCSIS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--navy-dark);">Computer Science & Info Systems (CSIS)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <p class="text-secondary mb-0">Focusing on software engineering, data analytics, artificial intelligence, and network systems to prepare students to be innovators in the rapidly evolving tech industry and the digital future.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTech" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--navy-dark);">Technology (COT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <p class="text-secondary mb-0">Bridging the gap between theoretical science and practical application by equipping students with hands-on industrial, vocational, and advanced technological training for the modern workforce.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLifeSci" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--navy-dark);">Life Sciences (CST)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <p class="text-secondary mb-0">Delving into the complex mechanisms of life, biological processes, and environmental ecosystems to foster sustainable practices, agricultural advancements, and healthier futures for our communities.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNatSci" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--navy-dark);">Natural Sciences (CNS)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <p class="text-secondary mb-0">Uncovering the fundamental laws of nature through rigorous advanced research in chemistry, physics, mathematics, and earth sciences to continuously push the boundaries of human knowledge.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSocSci" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--navy-dark);">Social Sciences (CSS)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <p class="text-secondary mb-0">Analyzing human behavior, historical trends, economic structures, and cultural dynamics to address, understand, and solve complex societal challenges in an interconnected modern world.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalArtHum" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--navy-dark);">Art and Humanities (CAH)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <p class="text-secondary mb-0">Nurturing critical thinking, cultural appreciation, and creative expression through deep, meaningful explorations of literature, languages, history, philosophy, and the fine arts.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Run after the DOM loads to ensure the carousel element exists
    document.addEventListener('DOMContentLoaded', () => {
        var myCarousel = document.getElementById('featuredCarousel');
        if (myCarousel) {
            myCarousel.addEventListener('slide.bs.carousel', function(e) {
                let dots = document.querySelectorAll('.carousel-indicators-custom .dot-sm');
                dots.forEach(dot => dot.classList.remove('active'));
                dots[e.to].classList.add('active');
            });
        }
    });

    function scrollColleges(scrollOffset) {
        const container = document.getElementById('collegeScrollContainer');
        // Scrolls the container by the specified offset (300px right or left)
        container.scrollBy({
            left: scrollOffset,
            behavior: 'smooth'
        });
    }
</script>