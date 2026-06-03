<?php
$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASSWORD') ?: "";
$dbname = getenv('DB_NAME') ?: "fitzone";

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    echo "connection failed: " . $conn->connect_error;
}
?>