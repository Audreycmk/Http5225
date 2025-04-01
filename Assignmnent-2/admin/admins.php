<?php 
// Include necessary files
include '../includes/functions.php';
include '../includes/header.php';
require '../includes/conn.php';

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
?>

<div class="container mt-3">
    <!-- Library Info Banner -->
    <div class="alert alert-info text-center" role="alert">
        <strong>Library Management System:</strong> Library opens at 8:00 AM and closes at 11:00 PM
    </div>
    
    <h4 class="text-center mb-4">Admin Users Detail</h4>
    
    <!-- Add New Admin Button -->
    <div class="text-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_admin">Add New Admin</button>
    </div>
    
    <!-- Admins Table -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch admin users from the database
                        $query = "SELECT * FROM admins";
                        $query_run = mysqli_query($conn, $query);
                        
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            $user_id = $row['id'];
                            $name = htmlspecialchars($row['name']);
                            $email = htmlspecialchars($row['email']);
                            $mobile = htmlspecialchars($row['mobile']);
                        ?>
                        <tr>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $mobile; ?></td>
                            <td><?php echo $email; ?></td>
                            <td>
                                <!-- Edit and Delete buttons -->
                                <a href="edit_admin.php?id=<?php echo $user_id; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_admin.php?id=<?php echo $user_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Admin Modal -->
<div class="modal fade" id="add_admin" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_admin.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="mobile" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add_admin">Add Admin</button>
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
