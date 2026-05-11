<?php
// app/controllers/communityController.php

// Handle form submission for a new post DIRECTLY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'create_post') {
    session_start();
    require_once '../config/config.php'; 
    
    if (!isset($_SESSION['user_id'])) {
        die("Error: You must be logged in to post.");
    }

    $userId = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);

    $insertQuery = "INSERT INTO community_posts (user_id, title, body) VALUES ('$userId', '$title', '$body')";
    
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: ../../public/user/community.php"); 
        exit();
    } else {
        echo "Error posting: " . mysqli_error($conn);
        exit();
    }
}

// Handle form submission for a new COMMENT / REPLY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'create_comment') {
    session_start();
    require_once '../config/config.php'; 
    
    if (!isset($_SESSION['user_id'])) {
        die("Error: You must be logged in to comment.");
    }

    $userId = $_SESSION['user_id'];
    $postId = mysqli_real_escape_string($conn, $_POST['post_id']); 
    $body = mysqli_real_escape_string($conn, $_POST['body']);
    
    // CHANGED: Check if this is a reply by looking for parent_id
    $parentId = "NULL";
    if (isset($_POST['parent_id']) && !empty($_POST['parent_id'])) {
        $parentId = "'" . mysqli_real_escape_string($conn, $_POST['parent_id']) . "'";
    }

    // CHANGED: Included parent_id in the insert query
    $insertQuery = "INSERT INTO community_comments (post_id, user_id, parent_id, body) VALUES ('$postId', '$userId', $parentId, '$body')";
    
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: ../../public/user/post.php?id=" . $postId); 
        exit();
    } else {
        echo "Error posting comment: " . mysqli_error($conn);
        exit();
    }
}

// Function to get all posts (Unchanged)
function getAllPosts($conn, $search = '') {
    $searchCondition = "";
    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $searchCondition = " WHERE p.title LIKE '%$search%' OR p.body LIKE '%$search%' ";
    }

    $query = "SELECT p.*, u.username 
              FROM community_posts p 
              JOIN user u ON p.user_id = u.id 
              $searchCondition
              ORDER BY p.created_at DESC";
              
    $result = mysqli_query($conn, $query);
    
    $posts = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }
    return $posts;
}

// Function to get a single post with nested comments
function getPostDetails($conn, $postId) {
    $postId = mysqli_real_escape_string($conn, $postId);
    
    $postQuery = "SELECT p.*, u.username FROM community_posts p JOIN user u ON p.user_id = u.id WHERE p.id = '$postId'";
    $postResult = mysqli_query($conn, $postQuery);
    $post = mysqli_fetch_assoc($postResult);
    
    $commentsQuery = "SELECT c.*, u.username FROM community_comments c JOIN user u ON c.user_id = u.id WHERE c.post_id = '$postId' ORDER BY c.created_at ASC";
    $commentsResult = mysqli_query($conn, $commentsQuery);
    
    // CHANGED: This block organizes the flat comments into a nested "Tree" structure
    $allComments = [];
    while ($row = mysqli_fetch_assoc($commentsResult)) {
        $row['replies'] = []; // Create an empty bucket for replies on every comment
        $allComments[$row['id']] = $row; 
    }
    
    $nestedComments = [];
    foreach ($allComments as $id => &$comment) {
        if (!empty($comment['parent_id']) && isset($allComments[$comment['parent_id']])) {
            // It's a reply! Put it inside its parent's bucket
            $allComments[$comment['parent_id']]['replies'][] = &$comment;
        } else {
            // It's a top-level comment
            $nestedComments[] = &$comment;
        }
    }
    
    return ['post' => $post, 'comments' => $nestedComments];
}

// Helper function to calculate "Time Ago" (Unchanged)
function timeAgo($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->y > 0) return $diff->y . ' yr' . ($diff->y > 1 ? 's' : '') . ' ago';
    if ($diff->m > 0) return $diff->m . ' mo' . ($diff->m > 1 ? 's' : '') . ' ago';
    if ($diff->d > 0) return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
    if ($diff->h > 0) return $diff->h . ' hr' . ($diff->h > 1 ? 's' : '') . ' ago';
    if ($diff->i > 0) return $diff->i . ' min' . ($diff->i > 1 ? 's' : '') . ' ago';
    return 'just now';
}
?>