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

// Fetch Admin Details for Editing
$admin = null;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $admin_id = intval($_GET['id']); 
    $query = "SELECT * FROM admins WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);
    
    // Redirect if admin not found
    if (!$admin) {
        $_SESSION['error'] = "Admin not found.";
        header("Location: admins.php");
        exit();
    }
}

// Edit Admin (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_admin'])) {
    
    $admin_id = intval($_POST['id']);
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $mobile = htmlspecialchars(trim($_POST['mobile']));
    $role = htmlspecialchars(trim($_POST['role']));

    // Check if all fields are filled
    if (empty($name) || empty($email) || empty($mobile) || empty($role)) {
        $_SESSION['error'] = "All fields are required.";
    } else {
        // Prepare and execute update query
        $query = "UPDATE admins SET name=?, email=?, mobile=?, role=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $mobile, $role, $admin_id);
        $success = mysqli_stmt_execute($stmt);

        // Set success or error message
        $_SESSION['success'] = $success ? "Admin updated successfully!" : "Error updating admin.";
    }

    // Redirect after form submission
    header("Location: admins.php");
    exit();
}

// Include header
include '../includes/header.php';
?>

<div class="container mt-3">
    <h4 class="text-center mb-4">Edit Admin</h4>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <?php if ($admin): ?>
                    <!-- Admin edit form -->
                    <form action="edit_admin.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">

                        <!-- Name input -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
                        </div>

                        <!-- Email input -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                        </div>

                        <!-- Mobile input -->
                        <div class="mb-3">
                            <label class="form-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" value="<?php echo htmlspecialchars($admin['mobile']); ?>" required>
                        </div>

                        <!-- Role input (readonly) -->
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" name="role" value="admin" readonly required>
                        </div>

                        <!-- Form buttons -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="edit_admin">Update Admin</button>
                            <a href="admins.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                    <?php else: ?>
                        <p class="text-danger text-center">Admin not found.</p>
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
