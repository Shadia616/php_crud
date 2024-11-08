<?php
include 'config.php';

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS company_management";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Use the created database
$conn->select_db($database);

// Create employees table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(50) NOT NULL,
    position VARCHAR(50),
    salary DECIMAL(10, 2),
    hire_date DATE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'employees' created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>
