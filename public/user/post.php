<?php
session_start();
include '../../app/config/config.php'; // ACTIVATED
include '../../app/controllers/communityController.php'; // ACTIVATED

if (!isset($_GET['id'])) {
    header("Location: community.php");
    exit();
}

$postId = $_GET['id'];
$details = getPostDetails($conn, $postId);

if (!$details['post']) {
    header("Location: community.php");
    exit();
}

$post = $details['post'];
$commentsTree = $details['comments'];

// CHANGED: We created a reusable function to draw comments and their nested replies!
function renderComments($commentsList) {
    global $post; // We need access to the $post['id'] variable inside this function
    
    foreach ($commentsList as $comment) {
        ?>
        <div class="comment-thread mt-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="fw-bold small text-dark"><?php echo htmlspecialchars($comment['username']); ?></span>
                <span class="text-muted" style="font-size: 0.75rem;">
                    <?php echo timeAgo($comment['created_at']); ?> 
                </span>
            </div>
            
            <p class="mb-1 text-dark" style="font-size: 0.95rem;"><?php echo nl2br(htmlspecialchars($comment['body'])); ?></p>
            
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
                    <?php renderComments($comment['replies']); ?>
                </div>
            <?php endif; ?>
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
    <style>
        :root { --navy-dark: #1b1a40; }
        .bg-navy { background-color: var(--navy-dark); }
        body { background-color: #F8F9FA; }
        .post-card { border: 1px solid #EAEAEA; border-radius: 8px; background: white; }
        .search-bar { background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 20px;}
        .search-bar::placeholder { color: #ccc; }
        
        /* The magical CSS class that indents replies! */
        .comment-thread { border-left: 2px solid #EAEAEA; padding-left: 15px; margin-left: 5px; }
        
        .search-bar:focus, .search-bar:hover {
            background-color: rgba(255,255,255,0.1) !important;
            color: white !important;
            box-shadow: none !important;
            border-color: rgba(255,255,255,0.5) !important;
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
                    <input name="search" class="form-control search-bar ps-5 py-1 text-white w-100" type="search" placeholder="Search for titles..." style="border-radius: 20px !important; outline: none;">
                </div>
            </form>
        </div>
    </nav>

    <div class="container-fluid px-5 py-4">
        <div class="row">
            <div class="col-md-2 pt-3">
                <a href="index.php" class="d-block text-dark text-decoration-none fw-bold mb-3"><i class="bi bi-house-door me-2"></i> Home</a>
                <a href="community.php" class="d-block text-dark text-decoration-none fw-bold mb-3"><i class="bi bi-arrow-left me-2"></i> Go back to gallery</a>
            </div>

            <div class="col-md-8 px-5">
                <div class="post-card p-5 mb-4">
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold fs-6 d-block"><?php echo htmlspecialchars($post['username']); ?></span>
                            <small class="text-muted"><?php echo timeAgo($post['created_at']); ?></small>
                        </div>
                        <h3 class="fw-bold mb-4"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="mb-5 fs-5" style="color: #000;"><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
                        
                        <div class="d-flex gap-3 pb-3 border-bottom border-2">
                            <span class="text-dark fw-bold"><i class="bi bi-chat me-1"></i> Comments</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <?php if(empty($commentsTree)): ?>
                            <p class="text-muted">No comments yet. Be the first to reply!</p>
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

    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            if (form.classList.contains('d-none')) {
                form.classList.remove('d-none');
            } else {
                form.classList.add('d-none');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>