<?php
session_start();

// Destroy the user's session
session_unset();
session_destroy();

// Redirect to the login page
header("Location: index.php");
exit();
?>
