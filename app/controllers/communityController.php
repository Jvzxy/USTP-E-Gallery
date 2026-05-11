<?php
// app/controllers/communityController.php

// Function to get all posts (for community.php)
function getAllPosts($conn) {
    // Join with user table to get the username (which is the student ID number)
    $query = "SELECT p.*, u.username 
              FROM community_posts p 
              JOIN user u ON p.user_id = u.id 
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

// Function to get a single post with its comments (for post.php)
function getPostDetails($conn, $postId) {
    $postId = mysqli_real_escape_string($conn, $postId);
    
    // Get the main post
    $postQuery = "SELECT p.*, u.username FROM community_posts p JOIN user u ON p.user_id = u.id WHERE p.id = '$postId'";
    $postResult = mysqli_query($conn, $postQuery);
    $post = mysqli_fetch_assoc($postResult);
    
    // Get the comments for this post
    $commentsQuery = "SELECT c.*, u.username FROM community_comments c JOIN user u ON c.user_id = u.id WHERE c.post_id = '$postId' ORDER BY c.created_at ASC";
    $commentsResult = mysqli_query($conn, $commentsQuery);
    $comments = [];
    while ($row = mysqli_fetch_assoc($commentsResult)) {
        $comments[] = $row;
    }
    
    return ['post' => $post, 'comments' => $comments];
}
?>