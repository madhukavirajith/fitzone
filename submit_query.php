<?php
session_start();
include "connect.php";

// Ensure the user is logged in as a customer
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    echo "<script>alert('Please log in first!'); window.location.href='customer-signup-login.php';</script>";
    exit();
}

$customer_id = $_SESSION["user_id"];

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $query = $conn->real_escape_string($_POST['query']);
    
    if (empty($query)) {
        echo "<script>alert('Query text cannot be empty!'); window.history.back();</script>";
        exit;
    }
    
    // Insert the query into the "queries" table using prepared statements
    $stmt = $conn->prepare("INSERT INTO queries (customer_id, query_text) VALUES (?, ?)");
    $stmt->bind_param("is", $customer_id, $query);
    
    if ($stmt->execute() === TRUE) {
        // If successful, redirect back to the dashboard
        echo "<script>alert('Query submitted successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Close the connection
$conn->close();
?>

