<?php
session_start();
include_once "db.php"; // Include the database connection file

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
   

    // Prepare and bind statement to insert data
    $stmt = $conn->prepare("INSERT INTO patients (name, age, gender) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $age, $gender);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to dashboard with success message
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        // Redirect to dashboard with error message
        header("Location: dashboard.php?error=1");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect back to dashboard if accessed directly
    header("Location: dashboard.php");
    exit();
}
?>
