<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['incharge_id'] === 'admin' && $_POST['password'] === 'admin111') {
        // Redirect to admin profile page
        header("Location: adminprofile.php");
        exit;
    } else {
        // Display alert for incorrect credentials
        echo "<script>alert('Incorrect incharge ID or password');</script>";
    }
}
?>
