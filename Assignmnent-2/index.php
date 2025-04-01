<?php
require 'includes/conn.php';
require 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include 'includes/header.php';

if (!isset($_SESSION['role'])) {
    header("Location: " . $baseURL . "/login.php");
    exit();
}

 if ($_SESSION['role'] === 'admin') {
     header("Location: " . $baseURL . "/admin/index.php");
     exit();
} 
?>

<div class="container mt-3">
    <div class="alert alert-info text-center" role="alert">
        <strong>Library Management System:</strong> Library opens at 8:00 AM and closes at 11:00 PM
    </div>
    <h4 class="text-center mb-4">All Books</h4>
    
    <div class="row">
        <?php
            require 'includes/conn.php'; 
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
                    $book_image = !empty($row['book_image']) ? htmlspecialchars($row['book_image']) : 'includes/images/dummyimage.png'; // Default image if not found
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo $book_image; ?>" class="card-img-top" alt="Book Image">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $book_name; ?></h5>
                    <p class="text-muted">by <?php echo $author_name; ?></p>
                    <p><strong>Category:</strong> <?php echo $category_name; ?></p>
                    <p class="text-primary"><strong>Price:</strong> $<?php echo $price; ?></p>
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

<?php
    include 'includes/footer.php'
?>