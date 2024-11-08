<?php
// Database configuration file
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'company_management';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
