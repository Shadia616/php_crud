<?php
include 'config.php';

// Get the employee ID from the URL parameter
$id = $_GET['id'];

// Fetch the current data for the employee from the database
$sql = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

// Check if the employee exists
if (!$employee) {
    echo "Employee not found!";
    exit();
}

// Handle form submission (Update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated data from the form
    $employee_name = $_POST['employee_name'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $hire_date = $_POST['hire_date'];

    // Prepare the SQL update query
    $update_sql = "UPDATE employees SET employee_name = ?, position = ?, salary = ?, hire_date = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssdsi", $employee_name, $position, $salary, $hire_date, $id);

    // Execute the query
    if ($update_stmt->execute()) {
        // Redirect to the same page to show updated details
        echo "<p style='color: green;'>Employee details updated successfully!</p>";
        // Reload the data after update
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = $result->fetch_assoc();
    } else {
        echo "<p style='color: red;'>Error updating record: " . $conn->error . "</p>";
    }

    // Close the prepared statement
    $update_stmt->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        .form-container {
            width: 80%;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container input, .form-container button {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container input[type="number"] {
            -moz-appearance: textfield;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        .form-container label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-container .form-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-container .form-footer a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .form-container .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h2>Edit Employee</h2>
</header>

<div class="form-container">
    <div class="form-heading">
        <h3>Edit Employee Details</h3>
    </div>

    <!-- Form to update employee details -->
    <form action="edit.php?id=<?php echo $employee['id']; ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">

        <label for="employee_name">Employee Name:</label>
        <input type="text" id="employee_name" name="employee_name" value="<?php echo htmlspecialchars($employee['employee_name']); ?>" required>

        <label for="position">Position:</label>
        <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>" required>

        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($employee['salary']); ?>" required>

        <label for="hire_date">Hire Date:</label>
        <input type="date" id="hire_date" name="hire_date" value="<?php echo htmlspecialchars($employee['hire_date']); ?>" required>

        <button type="submit">Update Employee</button>
    </form>

    <div class="form-footer">
        <a href="index.php">Back to Employee List</a>
    </div>
</div>

</body>
</html>
