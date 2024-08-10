<?php
session_start();

// Include the database connection file
require_once "connection.php";

// Check if the confirm booking button is clicked
if (!empty($_POST)) {
    // Retrieve booking details from POST data
    $roomNumber = $_POST['roomNumber'];
    $bedNumber = $_POST['bedNumber'];
    $bedFee = $_POST['bedFee'];
    $hostel = $_POST['hostel'];
    $studentId = $_POST['studentId'];

    // Generate a random 6-digit receipt number
    $receiptNumber = mt_rand(100000, 999999);

    // Get the current date
    $bookingDate = date('Y-m-d');

    // Prepare SQL statement to update the booking details in the f1 table
    $stmt = $conn->prepare("UPDATE f1 SET room_number = ?, bed_number = ?, bed_fee = ?, hostel = ?, booking_date = ?, receipt_number = ? WHERE stID = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param("sssssss", $roomNumber, $bedNumber, $bedFee, $hostel, $bookingDate, $receiptNumber, $studentId);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Booking update successful
        echo 'success';
    } else {
        // Booking update failed
        echo 'failure';
        // Uncomment the following line for debugging:
        // echo "Error: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
<!-- confirm_booking.php -->
<?php
// session_start();

// // Include the database connection file
// require_once "connection.php";

// // Check if the confirm booking button is clicked
// if (!empty($_POST)) {
//     // Retrieve booking details from POST data
//     $roomNumber = $_POST['roomNumber'];
//     $bedNumber = $_POST['bedNumber'];
//     $bedFee = $_POST['bedFee'];
//     $hostel = $_POST['hostel'];
//     $studentId = $_POST['studentId'];

//      // Generate a random 6-digit receipt number
//      $receiptNumber = mt_rand(100000, 999999);

//      // Get the current date
//      $bookingDate = date('Y-m-d');

//     // Prepare SQL statement to update the booking details
//     $stmt = $conn->prepare("UPDATE f1 SET room_number = ?, bed_number = ?, bed_fee = ?, hostel = ? WHERE stID = ?");
//     if ($stmt === false) {
//         die('Prepare failed: ' . $conn->error);
//     }

//     // Bind parameters to the prepared statement
//     $stmt->bind_param("sssssss", $roomNumber, $bedNumber, $bedFee, $hostel, $bookingDate, $receiptNumber, $studentId);

//     // Execute the prepared statement
//     if ($stmt->execute()) {
//         // Retrieve the student details
//         $stmt = $conn->prepare("SELECT stname, stmobile, styear, stgender, stbranch, stparentname, stparentnum, stpass FROM f1 WHERE stID = ?");
//         if ($stmt === false) {
//             die('Prepare failed: ' . $conn->error);
//         }
//         $stmt->bind_param("s", $studentId);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($result->num_rows > 0) {
//             // Fetch the student details
//             $row = $result->fetch_assoc();
//             $stname = $row['stname'];
//             $stmobile = $row['stmobile'];
//             $styear = $row['styear'];
//             $stgender = $row['stgender'];
//             $stbranch = $row['stbranch'];
//             $stparentname = $row['stparentname'];
//             $stparentnum = $row['stparentnum'];
//             $stpass = $row['stpass'];

//             // Determine the table based on year and gender
//             $table = '';
//             if ($styear == '1st') {
//                 if ($stgender == 'male') {
//                     $table = 'firstyearboys';
//                 } else {
//                     $table = 'firstyeargirls';
//                 }
//             } elseif ($styear == '2nd') {
//                 if ($stgender == 'male') {
//                     $table = 'secondyearboys';
//                 } else {
//                     $table = 'secondyeargirls';
//                 }
//             } elseif ($styear == '3rd') {
//                 if ($stgender == 'male') {
//                     $table = 'thirdyearboys';
//                 } else {
//                     $table = 'thirdyeargirls';
//                 }
//             } elseif ($styear == '4th') {
//                 if ($stgender == 'male') {
//                     $table = 'fourthyearboys';
//                 } else {
//                     $table = 'fourthyeargirls';
//                 }
//             }

//             if ($table !== '') {
//                 // Prepare SQL statement to insert the student details into the appropriate table
//                 $stmt = $conn->prepare("INSERT INTO $table (stID, stname, stmobile, stgender, styear, stbranch, stparentname, stparentnum, stpass, hostel, room_number, bed_number, bed_fee) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
//                 if ($stmt === false) {
//                     die('Prepare failed: ' . $conn->error);
//                 }
//                 $stmt->bind_param("sssssssssssss", $studentId, $stname, $stmobile, $stgender, $styear, $stbranch, $stparentname, $stparentnum, $stpass, $hostel, $roomNumber, $bedNumber, $bedFee);

//                 if ($stmt->execute()) {
//                     // Insert successful
//                     echo 'success';
//                 } else {
//                     // Insert failed
//                     echo 'failure: ' . $stmt->error;
//                 }
//             } else {
//                 // Invalid year or gender
//                 echo 'invalid_year_or_gender';
//             }
//         } else {
//             // Student not found
//             echo 'student_not_found';
//         }
//     } else {
//         // Booking update failed
//         echo 'failure: ' . $stmt->error;
//     }

//     // Close the statement and database connection
//     $stmt->close();
//     $conn->close();
// }
?>