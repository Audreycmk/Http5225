<?php
// Include database connection and header
require '../includes/conn.php';
include '../includes/header.php';

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

// Redirect if book number is not provided in the URL
if (!isset($_GET['book_no'])) {
    header("Location: all_books.php");
    exit();
}

// Get the book number from the URL
$book_no = $_GET['book_no'];

// Handle form submission for updating book details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $book_name = $_POST['book_name'];
    $category_id = $_POST['cat_id'];
    $author_id = $_POST['author_id'];
    $book_price = $_POST['book_price'];

    // Prepare and execute the update query
    $query = "UPDATE books SET book_name=?, cat_id=?, author_id=?, book_price=? WHERE book_no=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "siiii", $book_name, $category_id, $author_id, $book_price, $book_no);
    
    // Redirect on success or display error message
    if (mysqli_stmt_execute($stmt)) {
        header("Location: all_books.php");
        exit();
    } else {
        echo "<p class='text-danger'>Error updating book.</p>";
    }
}

// Fetch the book details for the given book number
$query = "SELECT * FROM books WHERE book_no=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $book_no);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($result);
?>

<!-- Edit Book Form -->
<div class="container mt-3">
    <h4 class="text-primary">Edit Book</h4>
    <div class="card shadow p-4">
        <form method="POST">
            <!-- Book Name -->
            <div class="mb-3">
                <label class="form-label">Book Name</label>
                <input type="text" name="book_name" class="form-control" value="<?php echo htmlspecialchars($book['book_name']); ?>" required>
            </div>
            <!-- Category ID -->
            <div class="mb-3">
                <label class="form-label">Category ID</label>
                <input type="number" name="cat_id" class="form-control" value="<?php echo htmlspecialchars($book['cat_id']); ?>" required>
            </div>
            <!-- Author ID -->
            <div class="mb-3">
                <label class="form-label">Author ID</label>
                <input type="number" name="author_id" class="form-control" value="<?php echo htmlspecialchars($book['author_id']); ?>" required>
            </div>
            <!-- Price -->
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="text" name="book_price" class="form-control" value="<?php echo htmlspecialchars($book['book_price']); ?>" required>
            </div>
            <!-- Submit and Cancel Buttons -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="all_books.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php
    // Include footer
    include '../includes/footer.php';
?>
