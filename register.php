<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $membershipplan = mysqli_real_escape_string($conn, $_POST['membershipplan']);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already has an account!'); window.location.href='customer-signup-login.php';</script>";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // SQL query to insert data into the database using prepared statements
        $insert_stmt = $conn->prepare("INSERT INTO customers (fullname, email, password, class, membershipplan) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssss", $fullname, $email, $hashed_password, $class, $membershipplan);

        if ($insert_stmt->execute() === TRUE) {
            echo "<script>alert('Account Created successfully! Please log in.'); window.location.href='customer-signup-login.php';</script>";
            exit;
        } else {
            echo "Error: " . $insert_stmt->error;
        }
        $insert_stmt->close();
    }
    $stmt->close();
}
?>

