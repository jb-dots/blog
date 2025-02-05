<?php
session_start();
include 'database/db.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch the logged-in user's details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch the logged-in user's posts
$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$posts = $stmt->fetchAll();

// Set profile picture based on gender
$profile_picture = ($user['gender'] == 'male') ? 'default_profile2.png' : 'default_profile.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%; /* Circular profile picture */
            object-fit: cover; /* Ensure the image fits */
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container my-5">
        <div class="text-center">
            <!-- Profile Picture Based on Gender -->
            <img src="images/<?= $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
            <h1 class="mb-4"><?= htmlspecialchars($user['username']); ?>'s Profile</h1>
        </div>

        <h2 class="text-center mb-4">Your Posts</h2>
        <?php if (empty($posts)): ?>
            <p class="text-center">You have no posts yet. <a href="create_post.php">Create your first post!</a></p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title"><?= htmlspecialchars($post['title']); ?></h2>
                                <p class="card-text"><?= nl2br(htmlspecialchars($post['content'])); ?></p>
                                <p class="text-muted">
                                    Posted on <?= $post['created_at']; ?>
                                </p>
                                <a href="edit_post.php?id=<?= $post['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_post.php?id=<?= $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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