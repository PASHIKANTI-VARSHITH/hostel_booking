<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: studentlogin.php");
    exit;
}

// Include the database connection file
require_once "connection.php";

// Retrieve student ID from session variable
$studentId = $_SESSION['studentId'];

// Prepare SQL statement to fetch student details
$sql = "SELECT stname, stmobile, styear, stgender, stbranch, stparentname, stparentnum, hostel, room_number, bed_number FROM f1 WHERE stID=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $studentId);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

// Bind variables to prepared statement
mysqli_stmt_bind_result($stmt, $studentName, $studentNumber, $studentYear, $studentGender, $studentBranch, $studentParentName, $studentParentNumber, $hostel, $room_number, $bed_number);

// Fetch student details
mysqli_stmt_fetch($stmt);

// Close statement
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        .roomsnavbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        padding-left: 16px;
        padding-right: 16px;
        border-bottom: 1px solid #d6d6d6;
        box-shadow: 0 0 4px rgba(0,0,0,.1);
        }   
        .roomslogo img {
            width: 170px;
            height: auto;
        }
        @media only screen and (min-width: 0px) and (max-width: 600px){
            .roomslogo img {
                width: 120px;
                height: auto;
            }
        }
        .profileheading{
            margin-top: 0%;
            width: 100%;
            background-color: black;
            color: white;
            text-align: center;
            font-size: small;
        }
        .profilecon{
            padding: 2rem 4rem;
            background-color: rgb(234, 230, 230);
            border-radius: 10px;
            /* box-shadow: 8px 8px 8px gray; */
        }
        .profilecontainer{
            margin-top: 1rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profilecontainer p{
            margin: 0.6rem;
            font-size: large;
            font-weight: bolder;
        }
    </style>
</head>
<body>
    <div class="roomsnavbar">
        <div class="roomslogo" >
            <a href="studentprofile.php"><img src="images/bvrit_logo.png" alt=""></a>
        </div>
    </div>
    <div class="profileheading">
        <h1>Your Profile</h1>
    </div>
    <div class="profilecontainer">
        <div class="profilecon">
                <p>Name : <?php echo $studentName; ?></p>
                <p>Roll number:<?php echo $studentId; ?></p>
                <p>Mobile : <?php echo $studentNumber; ?></p>
                <p>Year : <?php echo $studentYear; ?> Year</p>
                <p>Branch : <?php echo $studentBranch; ?> Year</p>
                <p>Gender :<?php echo $studentGender; ?></p>
                <p>Parent Name : <?php echo $studentParentName; ?></p>
                <p>Parent number : <?php echo $studentParentNumber; ?></p>
                <!-- <p>hostel : <?php echo $hostel; ?></p>
                <p>Room number : <?php echo $room_number; ?></p>
                <p>bed number : <?php echo $bed_number; ?></p> -->
                <?php
            // Check if hostel is not empty before printing
            if (!empty($hostel)) {
                echo "<p>Hostel : $hostel</p>";
            }

            // Check if room_number is not empty before printing
            if (!empty($room_number)) {
                echo "<p>Room number : $room_number</p>";
            }

            // Check if bed_number is not empty before printing
            if (!empty($bed_number)) {
                echo "<p>Bed number : $bed_number</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>