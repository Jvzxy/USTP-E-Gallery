<?php
session_start();
include '../../app/config/config.php'; // ACTIVATED
include '../../app/controllers/communityController.php'; // ACTIVATED

if (!isset($_GET['id'])) {
    header("Location: community");
    exit();
}

$postId = $_GET['id'];
$details = getPostDetails($conn, $postId);

if (!$details['post']) {
    header("Location: community");
    exit();
}

$post = $details['post'];
$commentsTree = $details['comments'];
$commentCount = countPostComments($conn, $postId);

function renderComments($commentsList) {
    global $post; 
    
    foreach ($commentsList as $comment) {
        $canDelete = isset($_SESSION['user_id']) && 
                    ($_SESSION['user_id'] == $comment['user_id'] || $_SESSION['user_id'] == $post['user_id']);
        ?>
        <div class="comment-thread mt-3">
            <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold small" style="color: var(--text-dark);"><?php echo htmlspecialchars($comment['username']); ?></span>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">
                        <?php echo timeAgo($comment['created_at']); ?> 
                    </span>
                </div>
                <div class="d-flex gap-1 align-items-center">
                    <?php if ($canDelete): ?>
                        <form action="../../app/controllers/communityController.php" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                            <input type="hidden" name="action" value="delete_comment">
                            <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                            <button type="submit" class="btn-icon text-danger border-0 bg-transparent" title="Delete comment">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    <?php endif; ?>
                    <button onclick="toggleCommentDetails(<?php echo $comment['id']; ?>)" class="btn-icon text-secondary border-0 bg-transparent" title="Hide comment" id="hide-btn-<?php echo $comment['id']; ?>">
                        <i class="bi bi-chevron-up"></i>
                    </button>
                </div>
            </div>
            
            <div id="comment-details-<?php echo $comment['id']; ?>" class="comment-content">
                <p class="mb-1" style="font-size: 0.95rem; color: var(--text-dark); word-break: break-word;"><?php echo nl2br(htmlspecialchars($comment['body'])); ?></p>
                
                <a href="javascript:void(0);" onclick="toggleReplyForm(<?php echo $comment['id']; ?>)" class="text-secondary text-decoration-none fw-bold d-inline-block mb-2" style="font-size: 0.75rem;"><i class="bi bi-reply-fill"></i> Reply</a>

                <div id="reply-form-<?php echo $comment['id']; ?>" class="mt-2 d-none mb-3">
                    <form action="../../app/controllers/communityController.php" method="POST">
                        <input type="hidden" name="action" value="create_comment">
                        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                        <input type="hidden" name="parent_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                        
                        <div class="mb-2">
                            <textarea name="body" class="form-control rounded-1 border form-control-sm" rows="2" placeholder="Replying to <?php echo htmlspecialchars($comment['username']); ?>..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-sm text-white fw-bold px-3 rounded-2" style="background-color: var(--navy-dark);">Post Reply</button>
                            <button type="button" onclick="toggleReplyForm(<?php echo $comment['id']; ?>)" class="btn btn-sm btn-light border">Cancel</button>
                        </div>
                    </form>
                </div>

                <?php if (!empty($comment['replies'])): ?>
                    <div class="mt-2 ps-2">
                        <button onclick="toggleReplies(<?php echo $comment['id']; ?>)" class="btn-icon text-secondary fw-bold border-0 bg-transparent" style="font-size: 0.75rem; padding: 0;" id="replies-btn-<?php echo $comment['id']; ?>">
                            <i class="bi bi-chevron-down"></i> <span id="replies-toggle-<?php echo $comment['id']; ?>">Show <?php echo count($comment['replies']); ?> replies</span>
                        </button>
                        <div id="replies-section-<?php echo $comment['id']; ?>" class="mt-2 d-none">
                            <?php renderComments($comment['replies']); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Gallery | Post Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/post.css?v=<?php echo time(); ?>">
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
                        <input name="search" class="form-control search-bar ps-5 pe-5 py-1 text-white w-100" type="search" placeholder="Search for titles..." style="border-radius: 20px !important; outline: none;">
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
                <a href="community" class="d-block text-decoration-none fw-bold mb-3" style="color: var(--text-dark);"><i class="bi bi-arrow-left me-2"></i> Go back to main page</a>
            </div>

            <div class="col-12 col-lg-8 px-2 px-md-4">
                <div class="post-card p-3 p-md-5 mb-4">
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold fs-6 d-block"><?php echo htmlspecialchars($post['username']); ?></span>
                            <small class="text-muted"><?php echo timeAgo($post['created_at']); ?></small>
                        </div>
                        <h3 class="fw-bold mb-4"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="mb-5" style="color: var(--text-dark); font-size: 1.1rem; word-break: break-word;"><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
                        
                        <div class="d-flex gap-3 pb-3 border-bottom border-2">
                            <span class="text-dark fw-bold"><i class="bi bi-chat me-1"></i> Comments (<?php echo $commentCount; ?>)</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <?php if(empty($commentsTree)): ?>
                            <p style="color: var(--text-muted);">No comments yet. Be the first to reply!</p>
                        <?php else: ?>
                            <?php renderComments($commentsTree); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mt-5 pt-4 border-top">
                        <h6 class="fw-bold mb-3">Leave a top-level comment</h6>
                        <form action="../../app/controllers/communityController.php" method="POST">
                            <input type="hidden" name="action" value="create_comment">
                            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                            <div class="mb-3">
                                <textarea name="body" class="form-control rounded-1 border" rows="3" placeholder="Write your thoughts here..." required></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn text-white fw-bold px-4 rounded-2" style="background-color: var(--navy-dark);">Post Comment</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/darkmode.js"></script>
    <script src="assets/js/post.js"></script>
</body>
</html>