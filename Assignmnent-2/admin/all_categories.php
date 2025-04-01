<?php
// Include database connection and utility functions
require '../includes/conn.php';
require '../includes/functions.php';

// Include header file
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
?>

<div class="container mt-3">
    <h4 class="text-center mb-4">All Categories</h4>

    <!-- Add New Category Button -->
    <div class="text-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add New Category</button>
    </div>

    <!-- Categories Table -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch all categories from the database
                        $query = "SELECT * FROM category ORDER BY cat_id DESC";
                        $query_run = mysqli_query($conn, $query);
                        
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            $cat_id = $row['cat_id'];
                            $cat_name = htmlspecialchars($row['cat_name']);
                        ?>
                        <tr>
                            <td><?php echo $cat_id; ?></td>
                            <td><?php echo $cat_name; ?></td>
                            <td>
                                <!-- Edit and Delete Buttons -->
                                <a href="edit_category.php?id=<?php echo $cat_id; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_category.php?id=<?php echo $cat_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_category.php" method="POST">
                    <!-- Category Name Input -->
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="cat_name" required>
                    </div>
                    <!-- Modal Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Category</button>
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
