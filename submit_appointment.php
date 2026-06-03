<?php
session_start();
include "connect.php";

// Ensure the user is logged in as a customer
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    echo "<script>alert('Please log in first!'); window.location.href='customer-signup-login.php';</script>";
    exit();
}

$customer_id = $_SESSION["user_id"];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form values and sanitize
    $classType = mysqli_real_escape_string($conn, $_POST['classType']);
    $appointmentDate = mysqli_real_escape_string($conn, $_POST['appointmentDate']);
    $appointmentTime = mysqli_real_escape_string($conn, $_POST['appointmentTime']);
    
    // Validate inputs
    if (empty($classType) || empty($appointmentDate) || empty($appointmentTime)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    // Insert appointment into database using prepared statements
    $stmt = $conn->prepare("INSERT INTO appointments (customer_id, class_type, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $customer_id, $classType, $appointmentDate, $appointmentTime);

    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Appointment successfully booked! We will notify you with further details.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Close connection
$conn->close();
?>
