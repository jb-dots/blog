<?php
session_start();
include 'database/db.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$post_id = $_GET['id'];

// Delete the post
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
if ($stmt->execute([$post_id, $_SESSION['user_id']])) {
    header("Location: index.php");
    exit;
} else {
    die("Failed to delete post.");
}
?>