<?php
include 'connection.php';

// Check if room_number, no_of_beds, and foryear are set
if (isset($_POST['room_number']) && isset($_POST['no_of_beds']) && isset($_POST['for_year'])) {
    $room_number = $_POST['room_number'];
    $no_of_beds = $_POST['no_of_beds'];
    $for_year = $_POST['for_year'];
    $bed_fee = $_POST['bed_fee'];

    // Check for empty fields
    if (empty($room_number) || empty($no_of_beds) || empty($for_year) || empty($bed_fee)) {
        echo "<script>alert('Please fill out all fields');</script>";
    } else {
        // Check if the room number already exists
        $check_query = "SELECT * FROM nalandaroom WHERE room_number = '$room_number'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            // Room already exists, display an alert if needed
            echo "<script>alert('Room number already exists');</script>";
        } else {
            // Insert the new room into the database
            $insert_query = "INSERT INTO nalandaroom (room_number, no_of_beds, for_year, bed_fee, beds_booked, vacancy_beds) VALUES ('$room_number', '$no_of_beds', '$for_year', '$bed_fee', '0', '$no_of_beds')";

            if ($conn->query($insert_query) === TRUE) {
                // Successfully added the room
                // You may optionally echo a success message here
            } else {
                // Error handling
                echo "<script>alert('Error adding room: " . $conn->error . "');</script>";
            }
        }
    }
} else {
    echo "<script>alert('Form data not received');</script>";
}
?>
