<?php
// session_start();

// if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
//     exit;
// }

// require_once "connection.php";

// $studentId = $_SESSION['studentId'];
// $roomNumber = $_POST['roomNumber'];
// $bedNumber = $_POST['bedNumber'];
// $hostel = $_POST['hostel'];

// $check_query = "SELECT * FROM booked_beds WHERE room_number=? AND bed_number=? AND hostel=?";
// $stmt = $conn->prepare($check_query);
// $stmt->bind_param("sis", $roomNumber, $bedNumber, $hostel);
// $stmt->execute();
// $stmt->store_result();

// if($stmt->num_rows > 0) {
//     echo json_encode(['status' => 'error', 'message' => 'Bed already booked']);
// } else {
//     $insert_query = "INSERT INTO booked_beds (student_id, room_number, bed_number, hostel) VALUES (?, ?, ?, ?)";
//     $stmt = $conn->prepare($insert_query);
//     $stmt->bind_param("isis", $studentId, $roomNumber, $bedNumber, $hostel);
//     if($stmt->execute()) {
//         echo json_encode(['status' => 'success', 'message' => 'Bed booked successfully']);
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Error booking bed']);
//     }
// }

// $stmt->close();
// $conn->close();
?>
