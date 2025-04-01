<?php
// Include database connection, functions, and header
require '../includes/conn.php';
require '../includes/functions.php';
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

// Fetch category details for editing
$category = null;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $cat_id = intval($_GET['id']); 
    $query = "SELECT * FROM category WHERE cat_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cat_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $category = mysqli_fetch_assoc($result);
    
    // Redirect if category is not found
    if (!$category) {
        $_SESSION['error'] = "Category not found.";
        header("Location: all_categories.php");
        exit();
    }
}

// Handle category update (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_category'])) {
    $cat_id = intval($_POST['id']); 
    $cat_name = htmlspecialchars(trim($_POST['cat_name'])); 

    // Validate that category name is provided
    if (empty($cat_name)) {
        $_SESSION['error'] = "Category name is required.";
    } else {
        // Update category in the database
        $query = "UPDATE category SET cat_name = ? WHERE cat_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $cat_name, $cat_id);
        $success = mysqli_stmt_execute($stmt);

        // Set success or error message
        $_SESSION['success'] = $success ? "Category updated successfully!" : "Error updating category.";
    }
    // Redirect back to all categories page
    header("Location: all_categories.php");
    exit();
}
?>

<!-- Edit Category Form -->
<div class="container mt-3">
    <h4 class="text-center mb-4">Edit Category</h4>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <?php if ($category): ?>
                    <!-- Form for editing category -->
                    <form action="edit_category.php" method="POST">
                        <!-- Hidden input to pass category ID -->
                        <input type="hidden" name="id" value="<?php echo $category['cat_id']; ?>">

                        <!-- Category name input -->
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="cat_name" value="<?php echo htmlspecialchars($category['cat_name']); ?>" required>
                        </div>
                        
                        <!-- Form buttons -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="edit_category">Update Category</button>
                            <a href="all_categories.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                    <?php else: ?>
                        <!-- Display error message if category not found -->
                        <p class="text-danger text-center">Category not found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include '../includes/footer.php';
?>
