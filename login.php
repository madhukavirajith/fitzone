<?php
session_start();
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Use prepared statements for secure login
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); 

        if (password_verify($password, $user['password'])) {
            // Correct login
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["fullname"];
            $_SESSION["role"] = "customer";
            
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Wrong password!'); window.location.href='customer-signup-login.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with that email!'); window.location.href='customer-signup-login.php';</script>";
    }
    $stmt->close();
}
?>
