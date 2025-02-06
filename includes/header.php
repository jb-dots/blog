<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faceblog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Default dark theme */
        body.dark-theme {
            background-color: #121212;
            color: #ffffff;
        }
        .dark-theme .card {
            background-color: #1e1e1e;
            border: 1px solid #333;
            color: #ffffff;
        }
        .dark-theme .card-text {
            color: #cccccc;
        }
        .dark-theme .text-muted {
            color: #888 !important;
        }
        .dark-theme .navbar {
            background-color: #1e1e1e;
        }
        .dark-theme .navbar-brand,
        .dark-theme .nav-link {
            color: #ffffff !important;
        }

        /* Light theme */
        body.light-theme {
            background-color: #ffffff;
            color: #000000;
        }
        .light-theme .card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            color: #000000;
        }
        .light-theme .card-text {
            color: #555;
        }
        .light-theme .text-muted {
            color: #6c757d !important;
        }
        .light-theme .navbar {
            background-color: #588b76;
        }
        .light-theme .navbar-brand,
        .light-theme .nav-link {
            color: #000000 !important;
        }
    </style>
</head>
<body class="dark-theme"> <!-- Default to dark theme -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2">
                Faceblog
            </a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="profile.php">Profile</a>
                    <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a> <!-- Logout confirmation -->
                <?php else: ?>
                    <a class="nav-link" href="register.php">Register</a>
                    <a class="nav-link" href="login.php">Login</a>
                <?php endif; ?>
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="btn btn-sm btn-outline-secondary ms-2">
                    <span id="theme-icon">🌙</span> <!-- Moon icon for dark theme -->
                </button>
            </div>
        </div>
    </nav>
    <div class="container my-5">
    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;

        // Check localStorage for saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            body.classList.add(savedTheme);
            updateThemeIcon(savedTheme);
        }

        // Toggle theme on button click
        themeToggle.addEventListener('click', () => {
            if (body.classList.contains('dark-theme')) {
                body.classList.remove('dark-theme');
                body.classList.add('light-theme');
                localStorage.setItem('theme', 'light-theme');
                updateThemeIcon('light-theme');
            } else {
                body.classList.remove('light-theme');
                body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark-theme');
                updateThemeIcon('dark-theme');
            }
        });

        // Update the theme icon
        function updateThemeIcon(theme) {
            themeIcon.textContent = theme === 'dark-theme' ? '🌙' : '☀️';
        }

        // Logout Confirmation
        function confirmLogout() {
            return confirm('Are you sure you want to log out?');
        }
    </script>
</body>
</html>