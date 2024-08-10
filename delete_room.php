<?php

include 'connection.php';

// Check if room_number and hostel are set
if(isset($_POST['room_number']) && isset($_POST['hostel'])) {
    $room_number = $_POST['room_number'];
    $hostel = $_POST['hostel'];

    // Construct SQL query based on the hostel
    $delete_query = "DELETE FROM {$hostel}room WHERE room_number = '$room_number'";

    // Execute the query
    if ($conn->query($delete_query) === TRUE) {
        // Successfully deleted the room
        // You may optionally echo a success message here
        echo "Room deleted successfully";
    } else {
        // Error handling
        echo "Error deleting room: " . $conn->error;
    }
} else {
    echo "Room number or hostel not received";
}

// Close the database connection
$conn->close();

?>
