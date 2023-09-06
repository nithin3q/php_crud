<?php
session_start();
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

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the 'users' table
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        // Registration successful, redirect to login page
        header("Location: index.php");
        exit();
    } else {
        // Registration failed
        echo '<div class="alert alert-danger text-center">Registration failed. Please try again.</div>';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="registration-form">
                    <h2 class="text-center">Register</h2>
                    <form method="POST" action="register.php">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
                <p>Already user? <a href="index.php">login</a></p>
            </div>
        </div>
    </div>

   
</body>
</html>

