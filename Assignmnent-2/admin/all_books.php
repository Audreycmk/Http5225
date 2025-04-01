<?php
// Include necessary files
require '../includes/functions.php';

// Include header file
include '../includes/header.php';

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

// Display error message if set
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}
?>

<div class="container mt-3">
    <!-- Library Info Banner -->
    <div class="alert alert-info text-center" role="alert">
        <strong>Library Management System:</strong> Library opens at 8:00 AM and closes at 11:00 PM
    </div>

    <h4 class="text-center mb-4">All Books</h4>
    
    <!-- Add New Book Button -->
    <div class="text-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBookModal">Add New Book</button>
    </div>
    
    <div class="row">
        <?php
        // Include database connection
        require '../includes/conn.php';

        // Fetch book details with category and author information
        $query = "SELECT 
                    b.book_no, 
                    b.book_name, 
                    c.cat_name, 
                    a.author_name, 
                    b.book_price, 
                    b.book_image 
                  FROM books b
                  LEFT JOIN authors a ON b.author_id = a.author_id
                  LEFT JOIN category c ON b.cat_id = c.cat_id";

        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                $book_number = htmlspecialchars($row['book_no']);
                $book_name = htmlspecialchars($row['book_name']);
                $category_name = htmlspecialchars($row['cat_name'] ?? "Unknown Category");
                $author_name = htmlspecialchars($row['author_name'] ?? "Unknown Author");
                $price = htmlspecialchars($row['book_price']);
                $book_image = !empty($row['book_image']) ? $row['book_image'] : "uploads/books/dummyimage.png";
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo '../'.$book_image; ?>" class="card-img-top" alt="Book Image">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $book_name; ?></h5>
                    <p class="text-muted">by <?php echo $author_name; ?></p>
                    <p><strong>Category:</strong> <?php echo $category_name; ?></p>
                    <p class="text-primary"><strong>Price:</strong> $<?php echo $price; ?></p>
                    <div class="mt-3">
                        <!-- Edit and Delete Buttons -->
                        <a href="edit_book.php?book_no=<?php echo $book_number; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_book.php?book_no=<?php echo $book_number; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
            echo "<div class='col-12 text-center'><p class='text-danger'>Error fetching data</p></div>";
        }
        ?>
    </div>
</div>

<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_book.php" method="POST" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <!-- Book Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Book Name</label>
                            <input type="text" class="form-control" name="book_name" placeholder="Enter book title" required>
                        </div>

                        <!-- Author Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control" name="author_name" placeholder="Enter author name" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="category_name" placeholder="Enter category" required>
                        </div>

                        <!-- Price -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="book_price" step="0.01" min="0" placeholder="Enter book price" required>
                        </div>

                        <!-- Book Number -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Book Number</label>
                            <input type="text" class="form-control" name="book_no" pattern="\d{5}" placeholder="Enter a 5-digit book number" required>
                            <small class="text-muted">Example: 12345</small>
                        </div>

                        <!-- Book Image -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Book Image</label>
                            <input type="file" class="form-control" name="book_image" accept="image/*" required>
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
// Include footer
include '../includes/footer.php'; 
?>
