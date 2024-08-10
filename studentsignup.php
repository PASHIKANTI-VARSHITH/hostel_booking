<?php

$errors = array();
$invalid_mobile_format = false;
if(isset($_POST['submit'])){
    $stname = $_POST['stname'];
    $stID = $_POST['stID'];
    $stmobile = $_POST['stmobile'];
    $stgender = $_POST['stgender'];
    $styear = $_POST['styear'];
    $stparentname = $_POST['stparentname'];
    $stparentnum = $_POST['stparentnum'];
    $stpass = $_POST['stpass'];
    $strepass = $_POST['strepass'];

    // Check if any field is left blank
    if(empty($stname) || empty($stID) || empty($stmobile) || empty($stgender) || empty($styear) || empty($stparentname) || empty($stparentnum) || empty($stpass) || empty($strepass)){
        $errors[] = "All fields are required";
    } else {
        // Check if student ID and name contain spaces
        if(preg_match('/\s/', $stID) || preg_match('/\s/', $stname)){
            $errors[] = "Student ID and Name cannot contain spaces";
        }

        // Check if phone number contains all zeros or doesn't have exactly 10 digits
        if(preg_match('/^0+$/', $stmobile) || strlen($stmobile) !== 10){
            $invalid_mobile_format = true;
        }
        if($invalid_mobile_format){
            echo "<script>alert('Invalid mobile number format');</script>";
        }

        // Check if phone number already exists in the database
        require_once "connection.php";
        $sql_check_phone = "SELECT * FROM f1 WHERE stmobile=?";
        $stmt_check_phone = mysqli_prepare($conn, $sql_check_phone);
        mysqli_stmt_bind_param($stmt_check_phone, "s", $stmobile);
        mysqli_stmt_execute($stmt_check_phone);
        mysqli_stmt_store_result($stmt_check_phone);
        if(mysqli_stmt_num_rows($stmt_check_phone) > 0) {
            $errors[] = "Phone number already exists";
        }
        mysqli_stmt_close($stmt_check_phone);

        // Check if father's number contains all zeros or doesn't have exactly 10 digits
        if(preg_match('/^0+$/', $stparentnum) || strlen($stparentnum) !== 10){
            $errors[] = "Invalid father's number format";
        }

        // Check if father's name and number contain spaces
        if(preg_match('/\s/', $stparentname) || preg_match('/\s/', $stparentnum)){
            $errors[] = "Father's Name and Number cannot contain spaces";
        }

        // Check if father's number already exists in the database
        $sql_check_father_num = "SELECT * FROM f1 WHERE stparentnum=?";
        $stmt_check_father_num = mysqli_prepare($conn, $sql_check_father_num);
        mysqli_stmt_bind_param($stmt_check_father_num, "s", $stparentnum);
        mysqli_stmt_execute($stmt_check_father_num);
        mysqli_stmt_store_result($stmt_check_father_num);
        if(mysqli_stmt_num_rows($stmt_check_father_num) > 0) {
            $errors[] = "Father's number already exists";
        }
        mysqli_stmt_close($stmt_check_father_num);

        // Check if password contains spaces
        if(preg_match('/\s/', $stpass)){
            $errors[] = "Password cannot contain spaces";
        }
    }

    if(strlen($stpass) < 8){
        $errors[] = "Password must contain at least 8 characters";
    }
    if($stpass !== $strepass){
        $errors[] = "Passwords do not match";
    }

    if(!empty($errors)){
        foreach($errors as $error){
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Proceed with signup process
        $password_hash = password_hash($stpass, PASSWORD_DEFAULT);
        $sql_insert = "INSERT INTO f1(stname, stID, stmobile, stgender, styear, stparentname, stparentnum, stpass) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt_insert, $sql_insert)){
            mysqli_stmt_bind_param($stmt_insert, "ssssssss", $stname, $stID, $stmobile, $stgender, $styear, $stparentname, $stparentnum, $password_hash);
            if(mysqli_stmt_execute($stmt_insert)){
                // echo "<div class='alert alert-success'>You have registered successfully.</div>";
                echo "<script>alert('registered successfully</script>";
            
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_stmt_error($stmt_insert) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: Unable to prepare statement</div>";
        }
        mysqli_stmt_close($stmt_insert);
    }
}

?>