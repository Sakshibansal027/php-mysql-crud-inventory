<?php
$servername = "localhost";
$db_username = "root";
$db_password = "YOUR_DATABASE_PASSWORD_HERE"; // Replace with your actual password
$dbname = "test_db";
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>