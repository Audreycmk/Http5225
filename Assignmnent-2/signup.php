<?php
require 'includes/conn.php';
include 'includes/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/index.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = ($_POST['password']); 
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        echo "<div class='alert alert-danger text-center'>Email is already registered!</div>";
    } else {
        $query = "INSERT INTO users (name, email, password, mobile, address, role) 
                  VALUES ('$name', '$email', '$password', '$mobile', '$address', 'user')";

        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success text-center'>Registration Successful! <a href='login.php'>Login Here</a></div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
mysqli_close($conn);
?>
<div class="container mt-3">
    <div class="alert alert-info text-center" role="alert">
        <strong>Library Management System:</strong> Library opens at 8:00 AM and closes at 8:00 PM (Sunday Off)
    </div>
    <div class="row">
        <div class="col-lg-4 mb-4" id="side_bar">
            <h5 class="fw-bold">Library Timing</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Opening: 8:00 AM</li>
                <li class="list-group-item">Closing: 8:00 PM</li>
                <li class="list-group-item">(Sunday Off)</li>
            </ul>
            <h5 class="fw-bold mt-3">What We Provide?</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Full furniture</li>
                <li class="list-group-item">Free Wi-Fi</li>
                <li class="list-group-item">Newspapers</li>
                <li class="list-group-item">Discussion Room</li>
                <li class="list-group-item">RO Water</li>
                <li class="list-group-item">Peaceful Environment</li>
            </ul>
        </div>
        <div class="col-lg-8" id="main_content">
            <div class="card shadow p-4">
                <h3 class="text-center text-primary mb-3"><u>User Registration</u></h3>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email ID:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile:</label>
                        <input type="text" name="mobile" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <textarea name="address" class="form-control" required></textarea> 
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

    include 'includes/footer.php';
?>
