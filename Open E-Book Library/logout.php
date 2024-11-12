<?php
session_start();  // Start the session

// Destroy the session to log out
session_unset();  // Removes all session variables
session_destroy();  // Destroys the session

// Redirect to the home page or login page
header("Location: index.php");
exit();
?>