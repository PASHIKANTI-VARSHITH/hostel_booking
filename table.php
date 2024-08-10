<!-- table.php -->
<?php
require_once 'connection.php';

// Get the year and gender parameters from the query string
$year = isset($_GET['year']) ? $_GET['year'] : null;
$gender = isset($_GET['gender']) ? $_GET['gender'] : null;

// Prepare and execute the SQL query
$sql = "SELECT * FROM f1 WHERE styear = ? AND stgender = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}

$stmt->bind_param("ss", $year, $gender);

if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();

$heading = "";
if ($year && $gender) {
    $yearText = $year . ' year';
    $genderText = ($gender === 'male') ? 'Boys' : 'Girls';
    $heading = "{$yearText} {$genderText} Details";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Table with Search Column Feature</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    body {
        color: #566787;
        background: #f7f5f2;
        font-family: 'Roboto', sans-serif;
    }
    .table-responsive {
        margin: 10px 0;
    }
    .table-wrapper {
        height: 80vh;
        min-width: 2500px;
        background: #fff;
        padding: 20px 25px;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        color: #fff;
        background: #40b2cd;		
        padding: 16px 25px;
        margin: -20px -25px 10px;
        border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
        margin: 5px 0 0;
        font-size: 24px;
    }
    table.table {
        table-layout: fixed;
        margin-top: 15px;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:first-child {
        width: 60px;
    }
    table.table th:last-child {
        width: 120px;
    }
    table.table td a {
        color: #a0a5b1;
        display: inline-block;
        margin: 0 5px;
    }
    table.table td a.view {
        color: #03A9F4;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
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
</style>
</head>
<body>
<div class="roomsnavbar">
        <div class="roomslogo">
            <a href="adminprofile.php"><img src="images/bvrit_logo.png" alt=""></a>
        </div>
        <div class="bt">
                    <button>Clear complete data</button>
                </div>
</div>
<div class="container">
    <div class="table-responsive">
        <div class="table-wrapper">			
            <div class="table-title">
                <div class="row">
                    <div class="col-xs-6">
                        <h2><?php echo $heading; ?></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Student Mobile</th>
                        <th>Student Year</th>
                        <th>Student Gender</th>
                        <th>Student Branch</th>
                        <th>Parent Name</th>
                        <th>Parent Number</th>
                        <th>Hostel</th>
                        <th>Room Number</th>
                        <th>Bed Number</th>
                        <th>Fee Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $index++; ?></td>
                        <td><?php echo $row['stname']; ?></td>
                        <td><?php echo $row['stID']; ?></td>
                        <td><?php echo $row['stmobile']; ?></td>
                        <td><?php echo $row['styear']; ?></td>
                        <td><?php echo $row['stgender']; ?></td>
                        <td><?php echo $row['stbranch']; ?></td>
                        <td><?php echo $row['stparentname']; ?></td>
                        <td><?php echo $row['stparentnum']; ?></td>
                        <td><?php echo $row['hostel']; ?></td>
                        <td><?php echo $row['room_number']; ?></td>
                        <td><?php echo $row['bed_number']; ?></td>
                        <td><?php echo $row['bed_fee']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>   
            </table>
            <?php
            if ($result->num_rows == 0) {
                echo "<p>No data found for the selected year and gender.</p>";
            }
            ?>
        </div>
    </div> 
</div>    
</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
<script>
$(document).ready(function() {
    $(".bt button").click(function() {
        var year = "<?php echo $year; ?>";
        var gender = "<?php echo $gender; ?>";

        if (year && gender) {
            $.ajax({
                url: "deletetable_data.php",
                type: "POST",
                data: {
                    year: year,
                    gender: gender
                },
                success: function(response) {
                    alert(response);
                    location.reload(); // Reload the page after successful deletion
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        } else {
            alert("Both year and gender are required.");
        }
    });
});
</script>