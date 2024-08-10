<!-- adminrooms.php -->
<?php
session_start();
require_once "connection.php";
// Retrieve selected hostel name from URL parameter
$selectedHostel = isset($_GET['selected_hostel']) ? $_GET['selected_hostel'] : "";
// Display room details in HTML
$bookedBeds_query = "SELECT room_number, bed_number FROM f1 WHERE hostel = '$selectedHostel' AND room_number IS NOT NULL AND bed_number IS NOT NULL AND stID IS NOT NULL";
$bookedBeds_result = $conn->query($bookedBeds_query);

// for booked beds in an array
$bookedBeds = [];
if ($bookedBeds_result->num_rows > 0) {
    while ($bookedBed = $bookedBeds_result->fetch_assoc()) {
        $bookedBeds[] = $bookedBed;
    }
}

// Encode booked beds as a JSON object and pass to JavaScript
$bookedBedsJson = json_encode($bookedBeds);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="adminrooms.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addRoomForm').submit(function(e) {
                e.preventDefault(); 
                
                var urlParams = new URLSearchParams(window.location.search);
                var selectedHostel = urlParams.get('hostel');

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: selectedHostel + '_addrooms.php',
                    data: formData,
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#addRoomBtn').click(function(e) {
                e.preventDefault();
                var urlParams = new URLSearchParams(window.location.search);
                var selectedHostel = urlParams.get('hostel');

                var formData = $('#addRoomForm').serialize();

                $.ajax({
                    url: selectedHostel + '_addrooms.php', 
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.trigger-btn').click(function(e) {
                e.preventDefault();

                var roomNumber = $(this).data('room-number');
                var urlParams = new URLSearchParams(window.location.search);
                var hostel = urlParams.get('hostel');

                $.ajax({
                    type: 'POST',
                    url: 'delete_room.php',
                    data: { room_number: roomNumber, hostel: hostel },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="rooms">
        <div class="roomsnavbar">
            <div class="roomslogo">
                <a href="adminprofile.php"><img src="images/bvrit_logo.png" alt=""></a>
            </div>
            <div class="addroom">
                <a href="#myModal" data-toggle="modal">Add Room</a>
            </div>
        </div>
    </div>

    <div class="roomscontainer">
    <?php
    include 'connection.php';
     
    if(isset($_GET['hostel'])) {
        $hostel = $_GET['hostel'];
    
        if($hostel == "cvraman") {
            $rooms_query = "SELECT * FROM cvramanroom";
        } elseif($hostel == "bhatnagar") {
            $rooms_query = "SELECT * FROM bhatnagarroom";
        } elseif($hostel == "tagore") {
            $rooms_query = "SELECT * FROM tagoreroom";
        } elseif($hostel == "nalanda") {
            $rooms_query = "SELECT * FROM nalandaroom";
        } elseif($hostel == "ramanujan") {
            $rooms_query = "SELECT * FROM ramanujanroom";
        } elseif($hostel == "vivekananda") {
            $rooms_query = "SELECT * FROM vivekanandaroom";
        } elseif($hostel == "prathibha") {
            $rooms_query = "SELECT * FROM prathibharoom";
        } elseif($hostel == "spoorthi") {
            $rooms_query = "SELECT * FROM spoorthiroom";
        } else {
            echo "Invalid hostel parameter";
        }
        $rooms_result = $conn->query($rooms_query);
    
        if ($rooms_result->num_rows > 0) {
            while($room = $rooms_result->fetch_assoc()) {
                echo "<div class='room'>";
                echo "<h1><span>Room " . $room['room_number'] . "</span>";
                // echo "<a href='#Edit' data-toggle='modal'><i class='bx bx-edit editroom'></i></a>";
                echo "<a href='#Delete' class='trigger-btn' data-toggle='modal' data-room-number='" . $room['room_number'] . "'><i class='bx bx-trash deleteroom'></i></a>";
                echo "</h1>";
                echo "<div class='row'>";
                for ($i = 1; $i <= $room['no_of_beds']; $i++) {
                    echo "<div class='bed'>$i</div>";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No rooms found</p>";
        }
    } else {
        echo "Hostel parameter not set";
    }
    $conn->close();    
    ?>
    </div>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-login">
            <div class="modal-content">
                <form id="addRoomForm" method="post">
                    <div class="modal-header">				
                        <h4 class="modal-title">Add Rooms</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">				
                        <div class="form-group">
                            <label>Room Number</label>
                            <input id="RoomNumber" name="room_number" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Number of Beds</label>
                            <input id="NumBeds" name="no_of_beds" type="number" class="form-control" required>
                        </div>
                        <div class="form-group">
                        <label>For Year</label>
                        <select id="for_year" name="for_year" class="form-control" required>
                            <option value="" selected hidden>Select Year</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Enter the fee</label>
                            <input id="bed_fee" name="bed_fee" type="number" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <input type="submit" name="submit" class="btn btn-primary pull-right" value="Add room"> -->
                        <button type="button" id="addRoomBtn" class="btn btn-primary pull-right">Add Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  

    <div id="Edit" class="modal fade">
        <div class="modal-dialog modal-login">
            <div class="modal-content">
                <form id="editRoomForm" method="post" action="cvraman_addrooms.php">
                    <div class="modal-header">				
                        <h4 class="modal-title">Edit Rooms</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">				
                        <div class="form-group">
                            <label>Room Number</label>
                            <input id="RoomNumber" name="edit_room_number" type="text" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Number of Beds</label>
                            <input id="NumBeds" name="edit_no_of_beds" type="number" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="editRoomBtn" class="btn btn-primary pull-right">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  

 <!-- Delete modal HTML -->
<div id="Delete" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this room? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <form id="deleteRoomForm" method="post" action="cvraman_addrooms.php">
                    <input type="hidden" id="deleteRoomNumber" name="room_number">
                    <button id="deleteRoomBtn" type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="footer">
      <div class="samplebeds">
      <ul class="showcase">
        <li>
            <div class="b na"></div>
            <small>N/A</small>
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
      <!-- <div class="bookbtn">
        <button>Book Room</button>
      </div> -->
    </div>
    <script>
        var bookedBedsData = <?php echo $bookedBedsJson; ?>;

        function markBookedBeds(bookedBeds) {
            var beds = document.getElementsByClassName('bed');
            for (var i = 0; i < beds.length; i++) {
                var bedNumber = parseInt(beds[i].innerText);
                var roomNumber = parseInt(beds[i].parentNode.parentNode.querySelector('h1 span').innerText.replace('Room ', ''));

                for (var j = 0; j < bookedBeds.length; j++) {
                    if (bookedBeds[j].room_number == roomNumber && bookedBeds[j].bed_number == bedNumber) {
                        beds[i].classList.add('bk');
                        break;
                    }
                }
            }
        }
        markBookedBeds(bookedBedsData);
    </script>
</body>
</html>

