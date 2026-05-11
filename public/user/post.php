<?php
session_start();
// include '../../app/config/db_connection.php'; 
// include '../../app/controllers/communityController.php'; 

// $postId = isset($_GET['id']) ? $_GET['id'] : 1;
// $details = getPostDetails($conn, $postId);
// $post = $details['post'];
// $comments = $details['comments'];

// DUMMY DATA FOR SPECIFIC POST (Remove once connected)
$post = ['id' => 1, 'username' => '2024304880', 'title' => 'Alumini party', 'body' => 'When man ta mga party oyyy unta ma dayonnn HAHAHAHHAHAHAHAHAHAHHAHJAHAHASHAHSHAHS', 'created_at' => '2026-05-11 10:30:00'];
$comments = [
    ['id' => 1, 'username' => '2024304770', 'body' => 'Taraaaaa mingaw na pd ko ninyooooo', 'created_at' => '2026-05-12 00:23:00'],
    ['id' => 2, 'username' => '2024304770', 'body' => 'Sige daii set na ug date', 'created_at' => '2026-05-12 03:49:00', 'is_reply' => true] // Simulating a threaded reply
];
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
        .comment-thread { border-left: 2px solid #EAEAEA; padding-left: 15px; margin-left: 5px; }
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
                <a href="community.php" class="d-block text-dark text-decoration-none fw-bold mb-3"><i class="bi bi-arrow-left me-2"></i> Go back to gallery</a>
            </div>

            <div class="col-md-8 px-5">
                <div class="post-card p-5 mb-4">
                    
                    <div class="mb-4">
                        <span class="fw-bold fs-6 mb-3 d-block"><?php echo htmlspecialchars($post['username']); ?></span>
                        <h3 class="fw-bold mb-4"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="mb-5 fs-5" style="color: #000;"><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
                        
                        <div class="d-flex gap-3 pb-3 border-bottom border-2">
                            <span class="text-dark fw-bold"><i class="bi bi-chat me-1"></i> comment</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <?php foreach ($comments as $index => $comment): ?>
                            
                            <div class="mb-4 <?php echo isset($comment['is_reply']) ? 'comment-thread mt-3' : ''; ?>">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <span class="fw-bold small"><?php echo htmlspecialchars($comment['username']); ?></span>
                                    <span class="text-muted" style="font-size: 0.75rem;">
                                        <?php echo $index == 0 ? '4hrs ago' : '34mins ago'; ?> 
                                    </span>
                                </div>
                                <p class="mb-1 text-dark fw-bold"><?php echo nl2br(htmlspecialchars($comment['body'])); ?></p>
                                <a href="#" class="text-dark text-decoration-none fw-bold" style="font-size: 0.8rem;">Reply</a>
                            </div>

                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>