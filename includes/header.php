<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #343a40; /* Dark background for navbar */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow */
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8); /* Light text color */
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #fff; /* White text on hover */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2">
                Blog System
            </a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="create_post.php">Create Post</a>
                    <a class="nav-link" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="register.php">Register</a>
                    <a class="nav-link" href="login.php">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container my-5">