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

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $user_query = "SELECT * FROM users WHERE email = '$email'";
    $admin_query = "SELECT * FROM admins WHERE email = '$email'";
    $user_query_run = mysqli_query($conn, $user_query);
    $admin_query_run = mysqli_query($conn, $admin_query);

    if(mysqli_num_rows($user_query_run) > 0) {
        $row = mysqli_fetch_assoc($user_query_run);
        if($password === $row['password']) {
            session_start();
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            // Redirect based on name
            if ($row['name'] === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo '<div class="alert alert-danger text-center mt-3">Wrong Password!</div>';
        }
    }
    elseif(mysqli_num_rows($admin_query_run) > 0) {
        $row = mysqli_fetch_assoc($admin_query_run);
        if($password === $row['password']) {
            session_start();
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            // Redirect based on name
            if ($row['name'] === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }else {
            echo '<div class="alert alert-danger text-center mt-3">Wrong Password!</div>';
            
        }
    } else {
        echo '<div class="alert alert-danger text-center mt-3">User not found!</div>';
     }
    mysqli_close($conn);
}

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
                    <h3 class="text-center text-primary mb-3"><u>Login</u></h3>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email ID:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        <div class="text-center mt-3">
                            <a href="signup.php">Not registered yet?</a>
                        </div>
                    </form>
                    <div class="mt-3 text-center">
                        <small>To login as an admin, use the following credentials:</small><br>
                        <strong>Username:</strong> admin@gmail.com <br>
                        <strong>Password:</strong> admin@1234
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

    include 'includes/footer.php';
?>
