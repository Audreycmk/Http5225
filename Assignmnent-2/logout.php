<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_unset();
session_destroy();

// Ensure session cookie is removed
setcookie(session_name(), '', time() - 3600, '/');

// Prevent caching issues
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

// Redirect to login page
header("Location: login.php");
exit();
?>
