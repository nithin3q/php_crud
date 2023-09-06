<?php
session_start();
include 'bootstrap.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Database connection setup (Replace with your database credentials)
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'list_app';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user's lists
$sql = "SELECT id, title, description FROM lists WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$lists = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container mt-5 dashboard-container">
        <h2 class="text-center">Welcome to Your Dashboard</h2>

        <h3>Your Lists</h3>
        <ul>
            <?php foreach ($lists as $list): ?>
                <li class="list-item">
                    <span class="list-title"><?php echo $list['title']; ?></span>
                     <span class="list-description"><?php echo $list['description']; ?></span>
                     
                </li>
            <?php endforeach; ?>
        </ul>
    
        <h3>Create a New List</h3>
        <form class="create-list-form" method="POST" action="create_list.php">
            <div class="form-group">
                <label for="title">String:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" rows="4" ></textarea>
            </div>
            <div class="form-group">
                <label for="is_private">Private:</label>
                <input type="checkbox" class="" name="is_private" id="is_private" value="1">
            </div>
            <button type="submit" class="btn btn-primary">Create List</button>
        </form>

        <p class="logout-link mt-4"><a href="logout.php">Logout</a></p>
    </div>

    
</body>
</html>
