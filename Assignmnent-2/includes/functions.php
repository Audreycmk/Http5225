<?php
    include 'conn.php';
    

    // Function to get the count of users
    function get_user_count(){
        global $conn; 
        $user_count = 0;
        $query = "SELECT COUNT(*) as user_count FROM users";
        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $row = mysqli_fetch_assoc($query_run);
            $user_count = $row['user_count'];
        }
        return $user_count;
    }

    // Function to get the count of admins
    function get_admin_count(){
        global $conn; 
        $user_count = 0;
        $query = "SELECT COUNT(*) as user_count FROM admins";
        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $row = mysqli_fetch_assoc($query_run);
            $user_count = $row['user_count'];
        }
        return $user_count;
    }

    // Function to get the count of books
    function get_book_count(){
        global $conn; 
        $book_count = 0;
        $query = "SELECT COUNT(*) as book_count FROM books";
        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $row = mysqli_fetch_assoc($query_run);
            $book_count = $row['book_count'];
        }
        return $book_count;
    }

?>
