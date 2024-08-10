<!-- studentlogin.php -->
<?php
session_start();

if(isset($_POST['submit'])){
    $stID = $_POST['stID'];
    $stpass = $_POST['stpass'];

    require_once "connection.php";

    // Prepare SQL statement to fetch password for the given student ID
    $sql = "SELECT stpass FROM f1 WHERE stID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $stID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $storedPassword);
        mysqli_stmt_fetch($stmt);

        // Compare the input password with the stored password from the database
        if($stpass === $storedPassword) {
            // Passwords match, set session variable and redirect to profile page
            $_SESSION['loggedin'] = true;
            $_SESSION['studentId'] = $stID; // Store student ID in session
            header("Location: studentprofile.php");
            exit(); // Stop script execution after redirect
        } else {
            // Incorrect password
            echo "<div class='alert alert-danger'>Incorrect password!</div>";
        }
    } else {
        // User with the entered ID does not exist
        echo "<div class='alert alert-danger'>User with the entered ID does not exist!</div>";
    }

    // Close statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
