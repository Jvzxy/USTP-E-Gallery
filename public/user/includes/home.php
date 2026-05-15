<?php
$graduateCount = 0;
$collegeCount  = 0;
$programCount  = 0;

if (isset($conn)) {
    $graduateCount = (int) $conn->query("SELECT COUNT(*) FROM student_profiles")->fetch_row()[0];
    $collegeCount  = (int) $conn->query("SELECT COUNT(*) FROM departments")->fetch_row()[0];
    $programCount  = (int) $conn->query("SELECT COUNT(*) FROM programs")->fetch_row()[0];
}

// College cards data — icon, title, blurb, modal target
$colleges = [
    ['icon' => 'bi-gear-fill',        'name' => 'Engineering',                      'abbr' => 'CEA',  'blurb' => 'Building the foundations of tomorrow.',        'desc' => 'Dedicated to advancing technological solutions through rigorous engineering principles, innovation, and practical application. We shape the creators and builders of modern infrastructure and sustainable systems.'],
    ['icon' => 'bi-laptop',           'name' => 'Computer Science & Info Systems',  'abbr' => 'CSIS', 'blurb' => 'Innovating the digital landscape.',             'desc' => 'Focusing on software engineering, data analytics, artificial intelligence, and network systems to prepare students to be innovators in the rapidly evolving tech industry.'],
    ['icon' => 'bi-cpu-fill',         'name' => 'Technology',                       'abbr' => 'COT',  'blurb' => 'Applied technical expertise.',                  'desc' => 'Bridging the gap between theoretical science and practical application by equipping students with hands-on industrial, vocational, and advanced technological training for the modern workforce.'],
    ['icon' => 'bi-heart-pulse-fill', 'name' => 'Life Sciences',                   'abbr' => 'CST',  'blurb' => 'Exploring living systems and health.',          'desc' => 'Delving into the complex mechanisms of life, biological processes, and environmental ecosystems to foster sustainable practices, agricultural advancements, and healthier futures.'],
    ['icon' => 'bi-tree-fill',        'name' => 'Natural Sciences',                 'abbr' => 'CNS',  'blurb' => 'Discovering the physical universe.',            'desc' => 'Uncovering the fundamental laws of nature through rigorous research in chemistry, physics, mathematics, and earth sciences to continuously push the boundaries of human knowledge.'],
    ['icon' => 'bi-people-fill',      'name' => 'Social Sciences',                  'abbr' => 'CSS',  'blurb' => 'Understanding human society.',                  'desc' => 'Analyzing human behavior, historical trends, economic structures, and cultural dynamics to address and solve complex societal challenges in an interconnected modern world.'],
    ['icon' => 'bi-palette-fill',     'name' => 'Art and Humanities',               'abbr' => 'CAH',  'blurb' => 'Celebrating creativity and culture.',           'desc' => 'Nurturing critical thinking, cultural appreciation, and creative expression through deep explorations of literature, languages, history, philosophy, and the fine arts.'],
];
?>

<section id="home">
    <h5 class="fw-bold mb-4">Recently</h5>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="yearbook-card">
                <img src="assets/Img/Student/TABANIAG, J-VHONNE L IMG_4870.jpeg" alt="Valedictory Address">
                <div class="card-overlay">
                    <h6>VALEDICTORY ADDRESS</h6>
                    <p>As we enter the next chapter — don't forget that you've already conquered so much and endured even more.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="yearbook-card">
                <img src="assets/Img/Student/Cabanlit, Anika Jasmine.jpg" alt="Valedictory Address">
                <div class="card-overlay">
                    <h6>VALEDICTORY ADDRESS</h6>
                    <p>The version of you that the world needs is already within you.</p>
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

    <!-- Stats Row -->
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

    <!-- Featured Quote Carousel -->
    <div id="featuredCarousel" class="carousel slide quote-container mt-5 pt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="yearbook-card rounded-0" style="height: 400px;">
                            <img src="assets/Img/Student/TUBA, SHANE ABBY.png" alt="Featured student">
                            <div class="card-overlay"><h6 class="text-uppercase m-0">Valedictory Address</h6></div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-light-gray p-4 p-md-5">
                        <p class="fs-5 italic mb-4">"We did not survive – we created our own way forward. We turned every hardship into a stepping stone. Wherever we go next, may we continue making paths for ourselves and for those who come after us."</p>
                        <div class="fw-bold fs-5">Ms. Shane Abby Tuba</div>
                        <div class="text-secondary small">Class of 2029</div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="yearbook-card rounded-0" style="height: 400px;">
                            <img src="assets/Img/Student/Caboverde, Chanice.JPG" alt="Featured student">
                            <div class="card-overlay"><h6 class="text-uppercase m-0">Valedictory Address</h6></div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-light-gray p-4 p-md-5">
                        <p class="fs-5 italic mb-4">"The journey was never easy, but the view from the top makes every struggle worth it. To the Class of 2029, we made it."</p>
                        <div class="fw-bold fs-5">Ms. Chanice Caboverde</div>
                        <div class="text-secondary small">Class of 2029</div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="yearbook-card rounded-0" style="height: 400px;">
                            <img src="assets/Img/Student/Justiniani, Jonathan.jpg" alt="Featured student">
                            <div class="card-overlay"><h6 class="text-uppercase m-0">Valedictory Address</h6></div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-light-gray p-4 p-md-5">
                        <p class="fs-5 italic mb-4">"Education is the most powerful weapon which you can use to change the world. Let's go change it together."</p>
                        <div class="fw-bold fs-5">Mr. Jonathan Justiniani</div>
                        <div class="text-secondary small">Class of 2029</div>
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
                    <div class="dot-sm"        data-bs-target="#featuredCarousel" data-bs-slide-to="1"></div>
                    <div class="dot-sm"        data-bs-target="#featuredCarousel" data-bs-slide-to="2"></div>
                </div>
                <button class="btn btn-navy-small rounded-circle p-0" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next" style="width:35px; height:35px;">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Explore by College (DB-driven scroll) -->
    <div class="mt-5 pt-4">
        <h5 class="fw-bold mb-4">Explore by College</h5>
        <div class="college-carousel-wrapper">
            <button class="carousel-nav-btn carousel-btn-left" onclick="scrollColleges(-300)" aria-label="Scroll left">
                <i class="bi bi-chevron-left fs-5"></i>
            </button>
            <div class="college-scroll-container" id="collegeScrollContainer">
                <?php foreach ($colleges as $i => $col):
                    $modalId = 'modalCollege' . $i; ?>
                <div class="college-card-item">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 bg-light-gray rounded-4 d-flex flex-column">
                        <i class="bi <?php echo $col['icon']; ?> fs-1 mb-3" style="color: var(--navy-dark);"></i>
                        <h6 class="fw-bold"><?php echo $col['name']; ?></h6>
                        <p class="small text-secondary mb-3"><?php echo $col['blurb']; ?></p>
                        <button class="btn btn-link text-decoration-none small fw-bold p-0 mt-auto" style="color: var(--navy-dark);" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>">
                            Learn More &rarr;
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-nav-btn carousel-btn-right" onclick="scrollColleges(300)" aria-label="Scroll right">
                <i class="bi bi-chevron-right fs-5"></i>
            </button>
        </div>
    </div>

    <!-- University Legacy -->
    <div class="row mt-5 mb-4 align-items-center bg-light-gray rounded-4 overflow-hidden shadow-sm" style="min-height: 400px;">
        <div class="col-md-6 p-4 p-md-5">
            <h6 class="text-uppercase mb-3" style="color: var(--navy-dark); font-weight: bold; letter-spacing: 2px;">University Legacy</h6>
            <h2 class="fw-bold mb-4">Shaping Tomorrow's Leaders</h2>
            <p class="text-secondary" style="line-height: 1.8;">
                The E-Gallery is a living testament to the unwavering dedication of our student body. It encapsulates years of rigorous academic pursuit, groundbreaking research, and transformative community engagements that define the university experience.
            </p>
            <p class="text-secondary" style="line-height: 1.8;">
                As a premier institution of science and technology, we take immense pride in producing trailblazers equipped to navigate and innovate in a complex global landscape. Every profile here represents a unique journey of resilience, excellence, and the relentless pursuit of knowledge.
            </p>
        </div>
        <div class="col-md-6 p-0 d-flex" style="min-height: 280px;">
            <img src="../../storage/USTP_Main.jfif" alt="USTP Campus" class="w-100 object-fit-cover" style="min-height: 280px;">
        </div>
    </div>

    <!-- Community CTA -->
    <div class="row mt-5 mb-4 text-center rounded-4 p-4 p-md-5 shadow" style="background-color: var(--navy-dark); color: white;">
        <div class="col-12 py-4">
            <h2 class="fw-bold mb-3">Join the Alumni Community</h2>
            <p class="mb-4 mx-auto" style="max-width: 600px; color: #e0e0e0;">
                Engage in discussions, share career opportunities, ask questions, and stay connected with fellow graduates in our exclusive community forums.
            </p>
            <a href="community" class="btn btn-light fw-bold px-4 py-2 rounded-pill text-uppercase" style="color: var(--navy-dark); letter-spacing: 1px;">Join the Conversation</a>
        </div>
    </div>

    <!-- College modals — generated from the same $colleges array above -->
    <?php foreach ($colleges as $i => $col):
        $modalId = 'modalCollege' . $i; ?>
    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--navy-dark);">
                        <?php echo htmlspecialchars($col['name']); ?> (<?php echo $col['abbr']; ?>)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <p class="text-secondary mb-0"><?php echo htmlspecialchars($col['desc']); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<script src="assets/js/home.js"></script>
</section>