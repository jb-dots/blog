<?php
session_start();
include 'database/db.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all posts
$stmt = $conn->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faceblog Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Dark theme styles (already included in header.php) */
    </style>
</head>
<body class="dark-theme"> <!-- Default to dark theme -->
    <?php include 'includes/header.php'; ?>
    <div class="container my-5">
        <h1 class="text-center mb-4">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
        <div class="text-center mb-4">
            <a href="create_post.php" class="btn btn-primary">Create New Post</a>
        </div>

        <?php if (empty($posts)): ?>
            <p class="text-center">No posts found.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title"><?= htmlspecialchars($post['title']); ?></h2>
                                <p class="card-text"><?= nl2br(htmlspecialchars($post['content'])); ?></p>
                                <p class="text-muted">
                                    Posted by <strong><?= htmlspecialchars($post['username']); ?></strong> on <?= $post['created_at']; ?>
                                </p>
                                <?php if ($_SESSION['user_id'] == $post['user_id']): ?>
                                    <a href="edit_post.php?id=<?= $post['id']; ?>" class="btn btn-warning">Edit</a>
                                    <a href="delete_post.php?id=<?= $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>