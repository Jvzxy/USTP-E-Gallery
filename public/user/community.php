<?php
session_start();
require '../../app/config/config.php';
require '../../app/controllers/communityController.php';

// Check if there is a search term in the URL
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sortType = isset($_GET['sort']) ? $_GET['sort'] : 'new';

// Fetch REAL posts from the database based on sort type
if ($sortType === 'popular') {
    $posts = getPopularPosts($conn, $searchTerm);
} elseif ($sortType === 'commented') {
    $posts = getMostDiscussedPosts($conn, $searchTerm);
} else {
    $posts = getAllPosts($conn, $searchTerm);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Gallery | Community Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="assets/css/community.css?v=<?php echo time(); ?>">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-navy py-3 px-3 px-md-4 shadow-sm">
        <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h5 class="text-white fw-bold mb-0">USTP-E-Gallery Community Hub</h5>

            <div class="d-flex align-items-center gap-2 flex-grow-1 flex-md-grow-0 justify-content-end">
                <form action="community" method="GET" class="d-flex w-100" style="max-width: 300px;">
                    <div class="position-relative w-100">
                        <button type="submit" class="border-0 bg-transparent text-white" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); z-index: 10; outline: none; box-shadow: none; cursor: pointer;">
                            <i class="bi bi-search"></i>
                        </button>
                        <input name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" class="form-control search-bar ps-5 pe-5 py-1 text-white w-100" type="search" placeholder="Search for titles..." style="border-radius: 20px !important; outline: none;">
                        <?php if (!empty($searchTerm)): ?>
                            <a href="community" class="text-white" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); z-index: 10; text-decoration: none; cursor: pointer;">
                                <i class="bi bi-x-circle-fill"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

                <button id="darkModeToggle" class="dark-mode-toggle" title="Toggle dark mode">
                    <i class="bi bi-moon-fill"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-3 px-md-5 py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-2 pt-3 mb-4 mb-lg-0">
                <a href="index" class="d-block text-decoration-none fw-bold mb-3" style="color: var(--text-dark);"><i class="bi bi-house-door me-2"></i> Home</a>
            </div>

            <div class="col-12 col-lg-8 px-2 px-md-4">
                <div class="create-post-trigger w-100 py-3 px-3 px-md-4 mb-4 text-center" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    <i class="bi bi-plus-circle me-2"></i> Create Post
                </div>

                <?php if (!empty($searchTerm)): ?>
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between bg-white p-3 mb-4 rounded border gap-3">
                        <span class="text-muted">Showing results for: <strong>"<?php echo htmlspecialchars($searchTerm); ?>"</strong></span>
                        <a href="community" class="btn btn-sm text-white fw-bold px-3 rounded-pill" style="background-color: var(--navy-dark);">
                            <i class="bi bi-arrow-left me-1"></i> Go back to Main Hub
                        </a>
                    </div>
                <?php endif; ?>

                <div class="sort-section">
                    <a href="?sort=new<?php echo $searchTerm ? '&search=' . htmlspecialchars($searchTerm) : ''; ?>" class="sort-btn <?php echo $sortType === 'new' ? 'active' : ''; ?>">
                        <i class="bi bi-fire me-1"></i> Latest
                    </a>
                    <a href="?sort=popular<?php echo $searchTerm ? '&search=' . htmlspecialchars($searchTerm) : ''; ?>" class="sort-btn <?php echo $sortType === 'popular' ? 'active' : ''; ?>">
                        <i class="bi bi-trending-up me-1"></i> Popular
                    </a>
                    <a href="?sort=commented<?php echo $searchTerm ? '&search=' . htmlspecialchars($searchTerm) : ''; ?>" class="sort-btn <?php echo $sortType === 'commented' ? 'active' : ''; ?>">
                        <i class="bi bi-chat-dots me-1"></i> Most Discussed
                    </a>
                </div>

                <?php if (empty($posts)): ?>
                    <p class="text-center text-muted mt-5">No posts found. Be the first to create one!</p>
                <?php else: ?>
                    <?php foreach ($posts as $post): 
                        $postCommentCount = countPostComments($conn, $post['id']);
                        $postLikeCount = countPostLikes($conn, $post['id']);
                        $userLiked = isset($_SESSION['user_id']) ? hasUserLikedPost($conn, $post['id'], $_SESSION['user_id']) : false;
                    ?>
                        <div class="post-card p-3 p-md-4 mb-3" onclick="window.location.href='post?id=<?php echo $post['id']; ?>';">
                            <div class="mb-3 d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="fw-bold" style="color: var(--text-dark);"><?php echo htmlspecialchars($post['username']); ?></span>
                                    <span class="d-block d-sm-inline mt-1 mt-sm-0 ms-sm-2" style="font-size: 0.85rem; color: var(--text-muted);">
                                        <i class="bi bi-clock me-1"></i><?php echo timeAgo($post['created_at']); ?>
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn-icon text-secondary border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation();" title="Post options">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                                            <li>
                                                <form action="../../app/controllers/communityController.php" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                    <input type="hidden" name="action" value="delete_post">
                                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                                    <button type="submit" class="dropdown-item text-danger" onclick="event.stopPropagation();">
                                                        <i class="bi bi-trash me-2"></i>Delete Post
                                                    </button>
                                                </form>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>

                            <h4 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h4>
                            <p class="mb-3" style="color: var(--text-muted);"><?php echo substr(htmlspecialchars($post['body']), 0, 150); ?>...</p>

                            <div class="post-engagement">
                                <a href="post?id=<?php echo $post['id']; ?>" class="engagement-btn text-decoration-none" onclick="event.stopPropagation();">
                                    <i class="bi bi-chat"></i> <span><?php echo $postCommentCount; ?> Comments</span>
                                </a>
                                <button class="engagement-btn <?php echo $userLiked ? 'active' : ''; ?>" onclick="event.stopPropagation(); toggleLike(this, <?php echo $post['id']; ?>)" title="Like this post" data-post-id="<?php echo $post['id']; ?>">
                                    <i class="bi <?php echo $userLiked ? 'bi-heart-fill' : 'bi-heart'; ?>"></i> 
                                    <span class="like-count"><?php echo $postLikeCount; ?></span>
                                </button>
                                <button class="engagement-btn" onclick="event.stopPropagation(); sharePost(<?php echo $post['id']; ?>)" title="Share this post">
                                    <i class="bi bi-share"></i> <span>Share</span>
                                </button>
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
                            <input type="text" name="title" class="form-control rounded-1 border" placeholder="Enter post title..." required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark">Main topic:</label>
                            <textarea name="body" class="form-control rounded-1 border" rows="6" placeholder="Enter post content..." required></textarea>
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
    
    <script src="assets/js/darkmode.js"></script>
    <script src="assets/js/community.js"></script>
</body>

</html>