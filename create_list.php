<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $is_private = isset($_POST['is_private']) ? 1 : 0; // Check if the 'Private' checkbox is checked

    // Insert the new list into the 'lists' table
    $sql = "INSERT INTO lists (user_id, title, description, is_private) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $user_id, $title, $description, $is_private);

    if ($stmt->execute()) {
        // List creation successful, redirect back to the dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // List creation failed
        echo "List creation failed. Please try again.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect to the dashboard if accessed directly without a POST request
    header("Location: dashboard.php");
    exit();
}
