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
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow to cards */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px); /* Lift card on hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Enhance shadow on hover */
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-text {
            color: #555;
        }
        .text-muted {
            font-size: 0.9rem;
        }
        .btn-primary {
            background-color: #a3d9a5;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #a3d9a5;
        }
    </style>
</head>
<body>
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