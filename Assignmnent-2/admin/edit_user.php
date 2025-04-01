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

$user = null;

// Fetch user details for editing
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Ensure ID is an integer to prevent SQL injection
    
    // Fetch user details from the database
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Redirect if user not found
    if (!$user) {
        $_SESSION['error'] = "User not found.";
        header("Location: manage_users.php");
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission for updating user details
    $user_id = intval($_POST['id']); // Ensure ID is an integer
    $name = htmlspecialchars(trim($_POST['name'])); // Sanitize form data
    $email = htmlspecialchars(trim($_POST['email']));
    $mobile = htmlspecialchars(trim($_POST['mobile']));
    $address = htmlspecialchars(trim($_POST['address']));

    // Check if all fields are filled
    if (empty($name) || empty($email) || empty($mobile) || empty($address)) {
        $_SESSION['error'] = "All fields are required.";
    } else {
        // Update user details in the database
        $query = "UPDATE users SET name=?, email=?, mobile=?, address=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $mobile, $address, $user_id);
        $success = mysqli_stmt_execute($stmt);

        // Set success or error message
        $_SESSION['success'] = $success ? "User updated successfully!" : "Error updating user.";
    }

    // Redirect after updating user
    header("Location: registerd_users.php");
    exit();
}

include '../includes/header.php';
?>

<!-- Edit User Form -->
<div class="container mt-3">
    <h4 class="text-center mb-4">Edit User</h4>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <?php if ($user): ?>
                    <!-- Form for editing user details -->
                    <form action="edit_user.php" method="POST">
                        <!-- Hidden input for user ID -->
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                        <!-- Name input -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        
                        <!-- Email input -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <!-- Mobile input -->
                        <div class="mb-3">
                            <label class="form-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
                        </div>

                        <!-- Address input -->
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                        </div>

                        <!-- Submit and Cancel buttons -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="registerd_users.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                    <?php else: ?>
                        <!-- Display error message if user not found -->
                        <p class="text-danger text-center">User not found.</p>
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
