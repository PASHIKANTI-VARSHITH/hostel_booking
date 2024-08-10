<!-- studentrooms.php -->
<?php
session_start();

// Retrieve session variables
$studentName = $_SESSION['studentName'];
$studentNumber = $_SESSION['studentNumber'];
$studentYear = $_SESSION['studentYear'];
$selectedHostel = $_SESSION['selectedHostel'];
$studentId = $_SESSION['studentId'];
// Check if the user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: studentlogin.php");
    exit;
}

require_once "connection.php";

// Retrieve selected hostel name from URL parameter
$selectedHostel = isset($_GET['selected_hostel']) ? $_GET['selected_hostel'] : "";

// Prepare and execute SQL query to check if the student has already booked a room
$checkBookingQuery = "SELECT hostel, room_number, bed_number FROM f1 WHERE stID = '$studentId'";
$checkBookingResult = $conn->query($checkBookingQuery);

// Check if the student has already booked a room
$hasBookedRoom = false;
if ($checkBookingResult->num_rows > 0) {
    $row = $checkBookingResult->fetch_assoc();
    if (!empty($row['hostel']) && !empty($row['room_number']) && !empty($row['bed_number'])) {
        $hasBookedRoom = true;
    }
}

// Display room details in HTML
$bookedBeds_query = "SELECT room_number, bed_number FROM f1 WHERE hostel = '$selectedHostel' AND room_number IS NOT NULL AND bed_number IS NOT NULL AND stID IS NOT NULL";
$bookedBeds_result = $conn->query($bookedBeds_query);
// Store booked beds in an array
$bookedBeds = [];
if ($bookedBeds_result->num_rows > 0) {
    while ($bookedBed = $bookedBeds_result->fetch_assoc()) {
        $bookedBeds[] = $bookedBed;
    }
}
// Encode booked beds as a JSON object and pass to JavaScript
echo "<script>var bookedBeds = " . json_encode($bookedBeds) . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="adminrooms.css">
    <style>
        .feepaidandbooked{
            color:red;
        }
        .row {
            display: flex;
            justify-content: center;
            flex-direction: row;
            padding: 8px 12px;
            margin: 0;
            list-style: none;
        }
        .bk{
            background-color: red;
        }
        .bookbtn button {
    cursor: pointer;
    color: white;
    background-color: red;
    padding: 5px 10px;
    border-radius: 5px;
    border: 2px solid black;
}
.bookbtn button:hover {
    background-color: rgb(212, 4, 4);
}

.beforebtn button {
    background-color: rgb(236, 114, 114);
    cursor: not-allowed;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    border: 2px solid black;
}
</style>
</head>
<body>
    <div class="rooms">
        <div class="roomsnavbar">
            <div class="roomslogo">
                <a href="studentprofile.php"><img src="images/bvrit_logo.png" alt=""></a>
            </div>
        </div>
    </div>
    <div class="roomscontainer">
    <?php
    include 'connection.php';
    // Check if the hostel parameter is set
    if(isset($_GET['hostels'])) {
        // Retrieve the hostel parameter value
        $hostels = $_GET['hostels'];

    if($hostels == "cvraman") {
        // Construct the SQL query to select rooms from the cvramanroom table for the student's year
        $rooms_query = "SELECT * FROM cvramanroom WHERE for_year = '$studentYear'";
    } elseif($hostels == "bhatnagar") {
        $rooms_query = "SELECT * FROM bhatnagarroom WHERE for_year = '$studentYear'";
    } elseif($hostels == "tagore") {
        $rooms_query = "SELECT * FROM tagoreroom WHERE for_year = '$studentYear'";
    } elseif($hostels == "nalanda") {
        $rooms_query = "SELECT * FROM nalandaroom WHERE for_year = '$studentYear'";
    } elseif($hostels == "ramanujan") {
        $rooms_query = "SELECT * FROM ramanujanroom WHERE for_year = '$studentYear'";
    } elseif($hostels == "vivekananda") {
        $rooms_query = "SELECT * FROM vivekanandaroom WHERE for_year = '$studentYear'";
    } elseif($hostels == "prathibha") {
        $rooms_query = "SELECT * FROM prathibharoom WHERE for_year = '$studentYear'";
    } elseif($hostels == "spoorthi") {
        $rooms_query = "SELECT * FROM spoorthiroom WHERE for_year = '$studentYear'";
    } else {
        echo "Invalid hostel parameter";
    }
        // Execute the query and fetch the result
        $rooms_result = $conn->query($rooms_query);

    if (!$rooms_result) {
        echo "Error executing query: " . $conn->error;
        exit;
    }

    // Check if there are rows returned
    if ($rooms_result->num_rows > 0) {
        // Store bed fees in a PHP array
        $bedFees = [];

        // Loop through each row and display room information
        while($room = $rooms_result->fetch_assoc()) {
            // Output room details
            echo "<div class='room'>";
            echo "<h1><span>Room " . $room['room_number'] . "</span></h1>";

            // Store the bed_fee for this room
            $bedFees[$room['room_number']] = $room['bed_fee'];

            // Display beds with numbers
            echo "<div class='row'>";
            for($i = 1; $i <= $room['no_of_beds']; $i++) {
                $bedIsBooked = false;
                foreach ($bookedBeds as $bookedBed) {
                    if ($bookedBed['room_number'] == $room['room_number'] && $bookedBed['bed_number'] == $i) {
                        $bedIsBooked = true;
                        break;
                    }
                }

                if ($bedIsBooked) {
                    echo "<div class='bed bk'>$i</div>";
                } else {
                    echo "<div class='bed' onclick='selectBed(this, " . $room['room_number'] . ")'>$i</div>";
                }
            }
            echo "</div>";
            echo "</div>";
        }
        // Encode bed fees as a JSON object and pass to JavaScript
        echo "<script>var bedFees = " . json_encode($bedFees) . ";</script>";
    } else {
        // Output if no rooms found
        echo "<p>No rooms found</p>";
    }
} else {
    // Handle case where hostel parameter is not set
    echo "Hostel parameter not set";
}

// Close the database connection
$conn->close();
?>
    </div>
    <div class="footer">
      <div class="samplebeds">
      <ul class="showcase">
        <li>
            <div class="b na"></div>
            <small>Available</small>
        </li>
        <li>
            <div class="b sel"></div>
            <small>Selected</small>
        </li>
        <li>
            <div class="b bk"></div>
            <small>Booked</small>
        </li>
       </ul>
      </div>
      <?php
      // Check if the student has already booked a room
      if ($hasBookedRoom) {
          echo '<div class="feepaidandbooked" ><p>You have already booked a room. You cannot book another room.</p></div>';
      } else {
          echo '<div class="beforebtn"><button id="bookRoomBtn" disabled>Book Room</button></div>';
      }
      ?>
    </div>


<div class="rulescontainer">
        <div class="rules">
            <div class="randr">
                <h1>RULES AND REGULATIONS</h1>
                <!-- <h1><a href="" onclick="undisplayRules()">X</a></h1> -->
                <h1><button class="closebtn" onclick="undisplayRules()">X</button></h1>
            </div>
            <p> Treat fellow residents with kindness and consideration.</p>
            <p>Keep noise levels down during specific times.</p>
            <p>No Smoking and drinking alcohol are not permitted.</p>
            <p> Return to the hostel by a certain time at night.</p>
            <p>Keep your space and shared areas clean.</p>
            <p>Inform staff and follow guidelines for visitors.</p>
            <p>Lock doors and keep belongings secure.</p>
            <p>Follow procedures for arrival and departure.</p>
            <p>Follow staf Listen and comply with staff directions.</p>
            <p>Cons Understand that breaking rules may have consequences.</p>
            <p>Adhering to these simple rules fosters a positive and harmonious hostel environment.</p>
            <button class="continue" onclick="confirm()">Accept and continue</button>
        </div>
    </div>

    <div class="detailscon">
        <div class="detailsc">
            <h1>Details</h1>
            <div class="det">
                <h4>Name : <?php echo $studentName; ?></h4>
                <h4>Roll Number : <?php echo $studentId; ?></h4>
                <h4>Year : <?php echo $studentYear; ?></h4>
                <h4>Mobile Number : <?php echo $studentNumber; ?></h4>
                <h4>Hostel : <?php echo $selectedHostel; ?></h4>
                <h4>Room Number : <span id="roomNumber"></span></h4>
                <h4>Bed Number: <span id="bedNumber"></span></h4>
                <h4>Bed Fee: <span id="bedFee"></span></h4>
            </div>
            <button class="dconfirm" type="button" name="confirmandpay" onclick="pay()">Confirm and Pay</button>
         </div>
    </div>

    <div class="upisection">
        <div class="upicontainer">
            <div class="upiback">
                <i class='bx bx-arrow-back'></i>
            </div>
            <div class="upicon">
                <img src="images/upi.jpg" alt="">
                <button class="upip" type="button" name="confirmBooking" onclick="success()">Done</button>
            </div>
        </div>
    </div>

    <div class="successcon">
        <div class="success">
            <div class="congrats">
                <h3>Congratulations!</h3>
            </div>
            <div class="successinfo">
                <p>Your booking has been confirmed.</p>
                <p>Check your reciept for detials.</p>
            </div>
            <div class="successok">
                <button class="sok" onclick="okclick()">OK</button>
            </div>
        </div>
    </div>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- JavaScript code for displaying rules -->
    <script>
       function displayRules() {
            // Toggle the visibility of the rules section
            let rules=document.querySelector(".rulescontainer")
            let rcon=document.querySelector(".roomscontainer")
            rules.style.display="block";
            rcon.style.display="none";

        }
        function undisplayRules(){
            let rules=document.querySelector(".rulescontainer")
            rules.style.display="none";
            // let roomsc=document.querySelector(".roomscontainer")
            // roomsc.style.display="flex";
        }
        function confirm(){
            let confirm=document.querySelector(".detailscon")
            confirm.style.display="block";
            undisplayRules();
        }
        function pay(){
            let confirm=document.querySelector(".detailscon")
            confirm.style.display="none";
            undisplayRules();
            let upi=document.querySelector(".upisection")
            upi.style.display="flex";
        }
        function success() {
    let roomNumber = document.getElementById('roomNumber').innerText;
    let bedNumber = document.getElementById('bedNumber').innerText;
    let bedFee = document.getElementById('bedFee').innerText;
    let hostel = '<?php echo $selectedHostel; ?>';
    let studentId = '<?php echo $studentId; ?>';

    // Send AJAX request to confirm booking
    $.ajax({
        type: "POST",
        url: "confirm_booking.php",
        data: {
            roomNumber: roomNumber,
            bedNumber: bedNumber,
            bedFee: bedFee,
            hostel: hostel,
            studentId: studentId
        },
        success: function(response) {
            if (response.includes('success')) {
                // Show success message
                let successcon = document.querySelector(".successcon");
                successcon.style.display = "block";
                //Hide details container
                let detailscon = document.querySelector(".detailscon");
                detailscon.style.display = "none";
                undisplayRules();
                let upisection = document.querySelector(".upisection");
                upisection.style.display = "none";
            } else if (response.includes('invalid_year_or_gender')) {
                alert("Invalid year or gender.");
            } else if (response.includes('student_not_found')) {
                alert("Student not found.");
            } else if (response.includes('failure')) {
                alert("Booking failed. Please try again. Error: " + response);
            } else {
                // Handle unexpected responses, but don't show an alert
                console.log("Unexpected response: " + response);
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX error
            alert("AJAX error: " + error);
        }
    });
}

function okclick() {
    let success = document.querySelector(".successcon");
    success.style.display = "none";
    window.location.href = "studentprofile.php";
}
</script>
<script>
function selectBed(bed, roomNumber) {
    // Reset all beds to default (N/A)
    var beds = document.getElementsByClassName('bed');
    for (var i = 0; i < beds.length; i++) {
        beds[i].classList.remove('sel');
    }
    var bedNumber = bed.innerText;
    var isBooked = false;
    // Check if the bed is already booked
    for (var i = 0; i < bookedBeds.length; i++) {
        if (bookedBeds[i].room_number == roomNumber && bookedBeds[i].bed_number == bedNumber) {
            isBooked = true;
            break;
        }
    }
    if (isBooked) {
        // Bed is already booked, do nothing
        return;
    } else {
        // Mark the selected bed
        bed.classList.add('sel');

        // Retrieve the bed fee for the selected room from the JavaScript object
        var selectedBedFee = bedFees[roomNumber];

        // Update the room number, bed number, and bed fee in the details section
        document.getElementById('roomNumber').innerText = roomNumber;
        document.getElementById('bedNumber').innerText = bedNumber;
        document.getElementById('bedFee').innerText = selectedBedFee;

        var bookRoomBtn = document.getElementById('bookRoomBtn');

        // Check if a bed is selected
        if (bedNumber) {
            // Enable the book room button and apply the 'bookbtn' class
            bookRoomBtn.disabled = false;
            bookRoomBtn.onclick = function() {
            displayRules();
            bookRoomBtn.disabled = true; // Disable the button after clicking
        };
            bookRoomBtn.parentNode.classList.remove('beforebtn');
            bookRoomBtn.parentNode.classList.add('bookbtn');
        } else {
            // Disable the book room button and apply the 'beforebtn' class
            bookRoomBtn.disabled = true;
            bookRoomBtn.onclick = null;
            bookRoomBtn.parentNode.classList.remove('bookbtn');
            bookRoomBtn.parentNode.classList.add('beforebtn');
        }
    }
    
}
</script>
</body>
</html>