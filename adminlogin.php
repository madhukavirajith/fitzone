<?php
session_start();
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']); 

    // Check if user exists using prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password']; 

        // Compare direct plaintext passwords as stored in this legacy DB
        if ($password === $stored_password) {
            // Password is correct
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];
            header("Location: admindash.php");
            exit();
        } else {
            echo "<script>alert('Wrong password!'); window.location.href='staff-admin-login.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with that username and role!'); window.location.href='staff-admin-login.php';</script>";
    }
    $stmt->close();
}
?>


