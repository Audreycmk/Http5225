<?php
// Include database connection
require '../includes/conn.php';

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

// Check if book number is provided in the URL
if (isset($_GET['book_no'])) {
    $book_no = intval($_GET['book_no']); 

    // Prepare DELETE query to remove book
    $query = "DELETE FROM books WHERE book_no=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $book_no);

    // Execute the query and check for success
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Book deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting book.";
    }

    // Redirect to the books listing page
    header("Location: all_books.php");
    exit();
} else {
    // Redirect if no book number is provided
    header("Location: all_books.php");
    exit();
}
?>
