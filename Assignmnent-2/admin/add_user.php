<?php
// Include database connection and utility functions
require '../includes/conn.php';
require '../includes/functions.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not authenticated
if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

// Restrict access to only admin users
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize and trim user input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $mobile = htmlspecialchars(trim($_POST['mobile']));
    $address = htmlspecialchars(trim($_POST['address']));

    // Validate required fields
    if (empty($name) || empty($email) || empty($mobile) || empty($address)) {
        $_SESSION['error'] = "All fields are required.";
    } else {
        // Insert new user into the database
        $query = "INSERT INTO users (name, email, mobile, address) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $mobile, $address);
        $success = mysqli_stmt_execute($stmt);

        // Store success or error message
        $_SESSION['success'] = $success ? "User added successfully!" : "Error adding user.";
    }

    // Redirect back to registered users page
    header("Location: registerd_users.php");
    exit();
}
?>
