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

// Handle comment deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete_comment') {
    session_start();
    require_once '../config/config.php';
    
    if (!isset($_SESSION['user_id'])) {
        die("Error: You must be logged in to delete a comment.");
    }

    $commentId = mysqli_real_escape_string($conn, $_POST['comment_id']);
    $postId = mysqli_real_escape_string($conn, $_POST['post_id']);
    $currentUserId = $_SESSION['user_id'];

    // Get the comment details
    $commentQuery = "SELECT c.user_id, p.user_id as post_user_id FROM community_comments c JOIN community_posts p ON c.post_id = p.id WHERE c.id = '$commentId'";
    $commentResult = mysqli_query($conn, $commentQuery);
    $comment = mysqli_fetch_assoc($commentResult);

    // Check if comment exists
    if (!$comment) {
        die("Error: Comment not found.");
    }

    // Check permissions: user must be either the comment author or the post author
    if ($comment['user_id'] != $currentUserId && $comment['post_user_id'] != $currentUserId) {
        die("Error: You do not have permission to delete this comment.");
    }

    // Delete the comment and its replies
    $deleteQuery = "DELETE FROM community_comments WHERE id = '$commentId' OR parent_id = '$commentId'";
    
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: ../../public/user/post.php?id=" . $postId);
        exit();
    } else {
        echo "Error deleting comment: " . mysqli_error($conn);
        exit();
    }
}

// Handle post deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete_post') {
    session_start();
    require_once '../config/config.php';
    
    if (!isset($_SESSION['user_id'])) {
        die("Error: You must be logged in to delete a post.");
    }

    $postId = mysqli_real_escape_string($conn, $_POST['post_id']);
    $currentUserId = $_SESSION['user_id'];

    // Get the post details
    $postQuery = "SELECT user_id FROM community_posts WHERE id = '$postId'";
    $postResult = mysqli_query($conn, $postQuery);
    $post = mysqli_fetch_assoc($postResult);

    // Check if post exists
    if (!$post) {
        die("Error: Post not found.");
    }

    // Check permissions: user must be the post owner
    if ($post['user_id'] != $currentUserId) {
        die("Error: You do not have permission to delete this post.");
    }

    // Delete all comments and replies for this post first
    $deleteCommentsQuery = "DELETE FROM community_comments WHERE post_id = '$postId'";
    mysqli_query($conn, $deleteCommentsQuery);

    // Delete likes for this post
    $deleteLikesQuery = "DELETE FROM post_likes WHERE post_id = '$postId'";
    mysqli_query($conn, $deleteLikesQuery);

    // Delete the post
    $deletePostQuery = "DELETE FROM community_posts WHERE id = '$postId'";
    
    if (mysqli_query($conn, $deletePostQuery)) {
        header("Location: ../../public/user/community.php");
        exit();
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
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

// Function to count all comments for a post (including nested replies)
function countPostComments($conn, $postId) {
    $postId = mysqli_real_escape_string($conn, $postId);
    $query = "SELECT COUNT(*) as count FROM community_comments WHERE post_id = '$postId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Function to count likes for a post
function countPostLikes($conn, $postId) {
    $postId = mysqli_real_escape_string($conn, $postId);
    $query = "SELECT COUNT(*) as count FROM post_likes WHERE post_id = '$postId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Function to check if user liked a post
function hasUserLikedPost($conn, $postId, $userId) {
    if (!isset($userId)) return false;
    $postId = mysqli_real_escape_string($conn, $postId);
    $userId = mysqli_real_escape_string($conn, $userId);
    $query = "SELECT id FROM post_likes WHERE post_id = '$postId' AND user_id = '$userId'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// Function to get posts sorted by likes (Popular)
function getPopularPosts($conn, $search = '') {
    $searchCondition = "";
    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $searchCondition = " WHERE p.title LIKE '%$search%' OR p.body LIKE '%$search%' ";
    }

    $query = "SELECT p.*, u.username, COUNT(l.id) as like_count
              FROM community_posts p 
              LEFT JOIN post_likes l ON p.id = l.post_id
              JOIN user u ON p.user_id = u.id 
              $searchCondition
              GROUP BY p.id
              ORDER BY like_count DESC, p.created_at DESC";
              
    $result = mysqli_query($conn, $query);
    
    $posts = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }
    return $posts;
}

// Function to get posts sorted by comments (Most Discussed)
function getMostDiscussedPosts($conn, $search = '') {
    $searchCondition = "";
    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $searchCondition = " WHERE p.title LIKE '%$search%' OR p.body LIKE '%$search%' ";
    }

    $query = "SELECT p.*, u.username, COUNT(c.id) as comment_count
              FROM community_posts p 
              LEFT JOIN community_comments c ON p.id = c.post_id AND c.parent_id IS NULL
              JOIN user u ON p.user_id = u.id 
              $searchCondition
              GROUP BY p.id
              ORDER BY comment_count DESC, p.created_at DESC";
              
    $result = mysqli_query($conn, $query);
    
    $posts = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }
    return $posts;
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