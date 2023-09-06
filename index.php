<?php
session_start();
// Include the common dependencies
include 'bootstrap.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection setup (Replace with your database credentials)
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'list_app';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve the hashed password from the database
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the entered password with the stored hashed password
    if ($user && password_verify($password, $user['password'])) {
        // Login successful, set a session variable
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Login failed
        echo "Login failed. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="login-form">
                    <h2 class="text-center">Login</h2>
                    <form method="POST" action="index.php">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    
                </div>
                <p>new user?   <a href="register.php">register</a></p>
            </div>
        </div>
    </div>
</body>
</html>
