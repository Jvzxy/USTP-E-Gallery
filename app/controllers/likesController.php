<?php
// app/controllers/likesController.php

// Handle like/unlike toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    session_start();
    require_once '../config/config.php';
    
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Not logged in']);
        exit();
    }

    $action = $_POST['action'];
    $postId = intval($_POST['post_id']);
    $userId = $_SESSION['user_id'];

    if ($action === 'toggle_like') {
        $postId = mysqli_real_escape_string($conn, $postId);
        $userId = mysqli_real_escape_string($conn, $userId);

        // Check if post exists
        $postCheck = "SELECT id FROM community_posts WHERE id = '$postId'";
        if (!mysqli_query($conn, $postCheck)) {
            http_response_code(404);
            echo json_encode(['error' => 'Post not found']);
            exit();
        }

        // Check if like already exists
        $checkLike = "SELECT id FROM post_likes WHERE post_id = '$postId' AND user_id = '$userId'";
        $likeResult = mysqli_query($conn, $checkLike);
        $likeExists = mysqli_num_rows($likeResult) > 0;

        if ($likeExists) {
            // Unlike: delete the like
            $deleteQuery = "DELETE FROM post_likes WHERE post_id = '$postId' AND user_id = '$userId'";
            mysqli_query($conn, $deleteQuery);
            $isLiked = false;
        } else {
            // Like: insert new like
            $insertQuery = "INSERT INTO post_likes (post_id, user_id) VALUES ('$postId', '$userId')";
            mysqli_query($conn, $insertQuery);
            $isLiked = true;
        }

        // Get updated like count
        $countQuery = "SELECT COUNT(*) as count FROM post_likes WHERE post_id = '$postId'";
        $countResult = mysqli_query($conn, $countQuery);
        $countRow = mysqli_fetch_assoc($countResult);
        $likeCount = $countRow['count'];

        echo json_encode([
            'success' => true,
            'isLiked' => $isLiked,
            'likeCount' => $likeCount
        ]);
        exit();
    }
}

http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
?>
