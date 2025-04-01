<?php 
// Include necessary functions, header, and database connection
include '../includes/functions.php';
include '../includes/header.php';
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
?>

<div class="container mt-3">
    <!-- Display system information alert -->
    <div class="alert alert-info text-center" role="alert">
        <strong>Library Management System:</strong> Library opens at 8:00 AM and closes at 11:00 PM
    </div>
    <h4 class="text-center mb-4">Registered Users Detail</h4>
    
    <!-- Add New User Button -->
    <div class="text-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="table-responsive">
                <!-- Table displaying registered users -->
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Query to fetch all users from the database
                            $query = "SELECT * FROM users";
                            $query_run = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($query_run)) {
                                $user_id = $row['id'];
                                $name = htmlspecialchars($row['name']);
                                $email = htmlspecialchars($row['email']);
                                $mobile = htmlspecialchars($row['mobile']);
                                $address = htmlspecialchars($row['address']);
                        ?>
                        <tr>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $mobile; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $address; ?></td>
                            <td>
                                <!-- Edit and Delete User Actions -->
                                <a href="edit_user.php?id=<?php echo $user_id; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_user.php?id=<?php echo $user_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new user -->
                <form action="add_user.php" method="POST">
                    <!-- User name input -->
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <!-- Email input -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <!-- Mobile input -->
                    <div class="mb-3">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="mobile" required>
                    </div>
                    <!-- Address input -->
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
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
