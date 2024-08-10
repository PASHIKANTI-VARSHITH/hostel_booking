<?php
require_once 'connection.php';

// Get the year and gender parameters from the AJAX request
$year = isset($_POST['year']) ? $_POST['year'] : null;
$gender = isset($_POST['gender']) ? $_POST['gender'] : null;

// Check if both year and gender are provided
if ($year && $gender) {
    // Prepare and execute the SQL query to delete data
    $sql = "DELETE FROM f1 WHERE styear = ? AND stgender = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("ss", $year, $gender);

    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);
    }

    echo "Data deleted successfully.";
} else {
    echo "Both year and gender are required.";
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>