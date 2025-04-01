<?php
// Include database connection and utility functions
require '../includes/conn.php';
require '../includes/functions.php'; 

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is authenticated; otherwise, redirect to login
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
    
    // Sanitize input values
    $book_no = htmlspecialchars(trim($_POST['book_no']));
    $book_name = htmlspecialchars(trim($_POST['book_name']));
    $author_name = htmlspecialchars(trim($_POST['author_name']));
    $category_name = htmlspecialchars(trim($_POST['category_name']));
    $book_price = floatval($_POST['book_price']);
    
    // Handle file upload
    $target_dir = "../uploads/books/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if not exists
    }
    
    $image_name = basename($_FILES["book_image"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    $db_path = "uploads/books/" . $image_name; // Relative path for database storage

    // Validate file type
    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: ./all_books.php");
        exit();
    }
    
    // Move uploaded file to target directory
    if (!move_uploaded_file($_FILES["book_image"]["tmp_name"], $target_file)) {
        $_SESSION['error'] = "Error uploading file.";
        header("Location: ./all_books.php");
        exit();
    }
    
    // Validate required fields
    if (empty($book_no) || empty($book_name) || empty($author_name) || empty($category_name) || empty($book_price)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ./all_books.php");
        exit();
    }

    // Check if book number already exists
    $check_book_no_query = "SELECT book_no FROM books WHERE book_no = ?";
    $stmt = mysqli_prepare($conn, $check_book_no_query);
    mysqli_stmt_bind_param($stmt, "s", $book_no);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Book number already exists. Please use a unique book number.";
        header("Location: ./all_books.php");
        exit();
    }

    // Insert category if not exists
    $category_query = "INSERT INTO category (cat_name) VALUES (?) ON DUPLICATE KEY UPDATE cat_name = cat_name";
    $stmt = mysqli_prepare($conn, $category_query);
    mysqli_stmt_bind_param($stmt, "s", $category_name);
    mysqli_stmt_execute($stmt);

    // Retrieve category ID
    $cat_id = mysqli_insert_id($conn);
    if ($cat_id == 0) {
        $cat_id_query = "SELECT cat_id FROM category WHERE cat_name = ?";
        $stmt = mysqli_prepare($conn, $cat_id_query);
        mysqli_stmt_bind_param($stmt, "s", $category_name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $cat_id = $row['cat_id'];
    }

    // Insert author if not exists
    $author_query = "INSERT INTO authors (author_name) VALUES (?) ON DUPLICATE KEY UPDATE author_name = author_name";
    $stmt = mysqli_prepare($conn, $author_query);
    mysqli_stmt_bind_param($stmt, "s", $author_name);
    mysqli_stmt_execute($stmt);

    // Retrieve author ID
    $author_id = mysqli_insert_id($conn);
    if ($author_id == 0) {
        $author_id_query = "SELECT author_id FROM authors WHERE author_name = ?";
        $stmt = mysqli_prepare($conn, $author_id_query);
        mysqli_stmt_bind_param($stmt, "s", $author_name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $author_id = $row['author_id'];
    }

    // Insert book details
    $book_query = "INSERT INTO books (book_name, author_id, cat_id, book_no, book_price, book_image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $book_query);
    mysqli_stmt_bind_param($stmt, "ssiids", $book_name, $author_id, $cat_id, $book_no, $book_price, $db_path);
    $insert_success = mysqli_stmt_execute($stmt);

    // Store success or error message
    $_SESSION['success'] = $insert_success ? "Book added successfully!" : "Error adding book.";
    
    header("Location: ./all_books.php");
    exit();
} else {
    header("Location: ./all_books.php");
    exit();
}
