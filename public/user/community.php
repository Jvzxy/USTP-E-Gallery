<?php
session_start();
// include '../../app/config/db_connection.php'; // Adjust path
// include '../../app/controllers/communityController.php'; // Adjust path

// $posts = getAllPosts($conn); 

// DUMMY DATA using 'username' as the ID number
$posts = [
    ['id' => 1, 'username' => '2024304880', 'title' => 'Alumini party', 'body' => 'When man ta mga party oyyy JAHAHAHSHAHSHAHSAHSHAHSHHAS', 'created_at' => '2026-05-11 10:30:00'],
    ['id' => 2, 'username' => '2024304990', 'title' => 'IT4R5 batch 2029', 'body' => 'HOOYYYYYYY musta naman moooo? kita ta guysss misss you allll', 'created_at' => '2026-05-10 14:15:00']
];
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
        .bg-navy { background-color: var(--navy-dark); }
        .text-navy { color: var(--navy-dark); }
        body { background-color: #F8F9FA; }
        .post-card { border: 1px solid #EAEAEA; border-radius: 8px; background: white; }
        .search-bar { background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 20px;}
        .search-bar::placeholder { color: #ccc; }
        .create-post-trigger { border: 1px solid #EAEAEA; border-radius: 20px; background: white; cursor: pointer; color: black; font-weight: bold;}
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-navy py-3 px-4 shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h5 class="text-white fw-bold mb-0">USTP-E-Gallery Community Hub</h5>
            <form class="d-flex w-25">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 text-white ms-2" style="position: absolute; z-index: 10;"><i class="bi bi-search"></i></span>
                    <input class="form-control search-bar ps-5 py-1 text-white" type="search" placeholder="Search for tittles...">
                </div>
            </form>
        </div>
    </nav>

    <div class="container-fluid px-5 py-4">
        <div class="row">
            <div class="col-md-2 pt-3">
                <a href="index.php" class="d-block text-dark text-decoration-none fw-bold mb-3"><i class="bi bi-house-door me-2"></i> Home</a>
                <a href="index.php" class="d-block text-dark text-decoration-none fw-bold mb-3"><i class="bi bi-arrow-left me-2"></i> Go back to gallery</a>
            </div>

            <div class="col-md-8 px-5">
                
                <div class="create-post-trigger w-100 py-2 px-4 mb-5 text-center" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    Create Post
                </div>
                
                <?php foreach ($posts as $post): ?>
                    <div class="post-card p-4 mb-4">
                        <div class="mb-3">
                            <span class="fw-bold fs-6"><?php echo htmlspecialchars($post['username']); ?></span>
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