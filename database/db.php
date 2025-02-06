<?php
$host = 'localhost';
$dbname = 'blog_db';
$username = 'root';
$password = '';

try {
    // Step 1: Connect to MySQL server (without selecting a database)
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Step 2: Check if the database exists
    $stmt = $conn->query("SHOW DATABASES LIKE '$dbname'");
    if ($stmt->rowCount() == 0) {
        // Database does not exist, create it
        $conn->exec("CREATE DATABASE $dbname");
        echo "Database created successfully.<br>";
    }

    // Step 3: Connect to the specific database
    $conn->exec("USE $dbname");

    // Step 4: Check if the `users` table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        // Create the `users` table
        $conn->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                gender ENUM('male', 'female') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        echo "Table 'users' created successfully.<br>";
    }

    // Step 5: Check if the `posts` table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'posts'");
    if ($stmt->rowCount() == 0) {
        // Create the `posts` table
        $conn->exec("
            CREATE TABLE posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ");
        echo "Table 'posts' created successfully.<br>";
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>