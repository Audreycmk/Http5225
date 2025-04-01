<?php
// Include necessary files for database connection and functions
require '../includes/conn.php';
require '../includes/functions.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

// Restrict access to only admin users
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Process form submission when the "Add Admin" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    
    // Sanitize user input and hash the password
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $mobile = htmlspecialchars(trim($_POST['mobile']));
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $role = 'admin';

    // Validate required fields
    if (empty($name) || empty($email) || empty($mobile) || empty($_POST['password'])) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: admins.php");
        exit();
    }

    // Check if email already exists
    $check_query = "SELECT id FROM admins WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) { // Prevent duplicate admin registration
        $_SESSION['error'] = "Email already exists.";
        header("Location: admins.php");
        exit();
    }
    mysqli_stmt_close($stmt);

    // Insert new admin into database
    $query = "INSERT INTO admins (name, email, mobile, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $mobile, $password, $role);
    $success = mysqli_stmt_execute($stmt);

    // Set success or error message and redirect
    $_SESSION['success'] = $success ? "Admin added successfully!" : "Error adding admin.";
    header("Location: admins.php");
    exit();
}
?>
