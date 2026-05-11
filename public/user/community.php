<?php
session_start();
// Changed from db_connection.php to config.php
require '../../app/config/config.php';
require '../../app/controllers/communityController.php';

// Check if there is a search term in the URL
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch REAL posts from the database using the controller
$posts = getAllPosts($conn, $searchTerm);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Gallery | Community Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --navy-dark: #1b1a40;
        }

        .bg-navy {
            background-color: var(--navy-dark);
        }

        .text-navy {
            color: var(--navy-dark);
        }

        body {
            background-color: #F8F9FA;
        }

        .post-card {
            border: 1px solid #EAEAEA;
            border-radius: 8px;
            background: white;
        }

        .search-bar {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 20px;
        }

        .search-bar::placeholder {
            color: #ccc;
        }

        /* Updated Create Post Button Styles */
        .create-post-trigger {
            border: 1px solid #EAEAEA;
            border-radius: 20px;
            background: white;
            cursor: pointer;
            color: black;
            font-weight: bold;
            transition: all 0.2s ease-in-out;
            user-select: none;
            /* Prevents text from turning blue when clicked */
        }

        .create-post-trigger:hover {
            background-color: #e9ecef;
            /* Smooth gray hover background */
            border-color: #ccc;
            color: var(--navy-dark);
        }

        /* Fix the white background when clicking the search bar */
        .search-bar:focus,
        .search-bar:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            box-shadow: none !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
        }

        /* Hide the default, ugly browser 'X' clear button */
        input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none;
            appearance: none;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-navy py-3 px-4 shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h5 class="text-white fw-bold mb-0">USTP-E-Gallery Community Hub</h5>

            <form action="community.php" method="GET" class="d-flex w-25">
                <div class="position-relative w-100">

                    <button type="submit" class="border-0 bg-transparent text-white" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); z-index: 10; outline: none; box-shadow: none; cursor: pointer;">
                        <i class="bi bi-search"></i>
                    </button>

                    <input name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" class="form-control search-bar ps-5 pe-5 py-1 text-white w-100" type="search" placeholder="Search for titles..." style="border-radius: 20px !important; outline: none;">

                    <?php if (!empty($searchTerm)): ?>
                        <a href="community.php" class="text-white" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); z-index: 10; text-decoration: none; cursor: pointer;">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    <?php endif; ?>

                </div>
            </form>

        </div>
    </nav>

    <div class="container-fluid px-5 py-4">
        <div class="row">
            <div class="col-md-2 pt-3">
                <a href="index.php" class="d-block text-dark text-decoration-none fw-bold mb-3"><i class="bi bi-house-door me-2"></i> Home</a>
            </div>

            <div class="col-md-8 px-5">
                <div class="create-post-trigger w-100 py-2 px-4 mb-4 text-center" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    Create Post
                </div>

                <?php if (!empty($searchTerm)): ?>
                    <div class="d-flex align-items-center justify-content-between bg-white p-3 mb-4 rounded border">
                        <span class="text-muted">Showing results for: <strong>"<?php echo htmlspecialchars($searchTerm); ?>"</strong></span>
                        <a href="community.php" class="btn btn-sm text-white fw-bold px-3 rounded-pill" style="background-color: var(--navy-dark);">
                            <i class="bi bi-arrow-left me-1"></i> Go back to Main Hub
                        </a>
                    </div>
                <?php endif; ?>

                <?php if (empty($posts)): ?>
                    <p class="text-center text-muted mt-5">No posts found. Be the first to create one!</p>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="post-card p-4 mb-4">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><?php echo htmlspecialchars($post['username']); ?></span>
                                <small class="text-muted"><?php echo timeAgo($post['created_at']); ?></small>
                            </div>

                            <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($post['title']); ?></h4>
                            <p class="mb-5" style="color: #333;"><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>

                            <div class="d-flex gap-3">
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="text-dark text-decoration-none fw-bold">
                                    <i class="bi bi-chat me-1"></i> comment
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createPostModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-3 border-0 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h4 class="modal-title fw-bold text-dark">Create Post</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../app/controllers/communityController.php" method="POST">
                        <input type="hidden" name="action" value="create_post">

                        <div class="mb-3">
                            <label class="form-label text-dark">Title:</label>
                            <input type="text" name="title" class="form-control rounded-1 border" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark">Main topic:</label>
                            <textarea name="body" class="form-control rounded-1 border" rows="6" required></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn text-white fw-bold px-4 rounded-2" style="background-color: var(--navy-dark);">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>