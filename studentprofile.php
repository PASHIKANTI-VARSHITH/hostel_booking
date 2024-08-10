<!-- studentprofile.php -->
<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location:resphome.php");
    exit;
}

// Include the database connection file
require_once "connection.php";

// Retrieve student ID from session variable
$studentId = $_SESSION['studentId'];

// Prepare SQL statement to fetch student details
$sql = "SELECT stname, stmobile, styear ,stgender FROM f1 WHERE stID=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $studentId);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

// Bind variables to prepared statement
mysqli_stmt_bind_result($stmt, $studentName, $studentNumber, $studentYear ,$studentGender);

// Fetch student details
mysqli_stmt_fetch($stmt);

// Close statement
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Retrieve selected hostel name from URL parameter
$selectedHostel = isset($_GET['selected_hostel']) ? $_GET['selected_hostel'] : "";

// Pass session variables to studentrooms.php
$_SESSION['studentName'] = $studentName;
$_SESSION['studentNumber'] = $studentNumber;
$_SESSION['studentYear'] = $studentYear;
$_SESSION['studentGender'] = $studentGender;
$_SESSION['selectedHostel'] = $selectedHostel;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* header----------------------------------- */
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
        .profile {
            text-align: right;
            font-size: 20px;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
        }
        .dropdown-menu {
            width: 120px;
            position: absolute;
            display: none;
            background: #fff;
            box-shadow: 0 0 4px rgba(0,0,0,.5);
            border-radius: 4px;
            padding: 8px 0px;
            right: 0;
            top: calc(100% + 10px);
        }
        .dropdown-menu ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .dropdown-menu li {
            color: black;
            padding: 8px 16px;
        }
        .dropdown-menu li a {
            text-decoration: none;
            color: black;
            display: flex;
            align-items: center;
        }
        .dropdown-menu li a i {
            font-size: 20px;
            margin-right: 10px;
        }
		@media only screen and (min-width: 0px) and (max-width: 600px){
            .roomslogo img {
            width: 120px;
            height: auto;
        }
        }
        .hostelsd{
            border: 2px solid black;
            width: 250px;
            height: 220px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            color: black;
            font-size: 0.6rem;
            margin: 1rem;
            box-shadow: 8px 8px 8px gray;
            transition: transform 0.3s ease-in-out;
            background-color: rgb(243, 238, 238);
        }
        .hostelsd:hover {
            transform: scale(1.05); /* Zoom effect on hover */
        }

        .hostelsd img{
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin: 3px;
        } 
        .stbackground a{
            text-decoration: none;
        }
        .stbackground{
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .ht{
            text-align: center;
            background-color: black;
            color: white;
            padding: 3px;
            font-size: 1rem;
        }
        .stpf{
            display:flex;
        }
        
    </style>
</head>
<body>
    <div class="roomsnavbar">
            <div class="roomslogo">
                <img src="images/bvrit_logo.png" alt="">
            </div>
                <div class="profile" onclick="toggleDropdown()">
                    <i class='bx bx-user'></i><i class='bx bx-caret-down'></i>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <ul>
                            <li><a href="profile.php"><i class='bx bxs-user-detail'></i> Profile</a></li>
                            <li><a href="resphome.php?logout=true"><i class='bx bx-log-out'></i> Logout</a></li>
                            <li><a href="receipt.php"><i class='bx bx-receipt'></i></i> Receipt</a></li>
                        </ul>
                    </div>
                </div>
    </div>
    <div class="ht">
        <h2>HOSTELS</h2>
    </div>
    <div class="stbackground">
    <?php if ($studentGender == 'male') { ?>
        <!-- Display male hostels -->
        <a href="studentrooms.php?hostels=cvraman&selected_hostel=CVRAMAN_HOSTEL">
            <div class="hostelsd">
                <img src="images/cvraman.webp" alt="">
                <h1>C.V.RAMAN HOSTEL</h1>
            </div>
        </a>
        <a href="studentrooms.php?hostels=bhatnagar&selected_hostel=BHATNAGAR_HOSTEL">
            <div class="hostelsd">
                <img src="images/bhatnagar.webp" alt="">
                <h1>BHATNAGAR HOSTEL</h1>
            </div>
        </a>
        <a href="studentrooms.php?hostels=tagore&selected_hostel=TAGORE_HOSTEL">
            <div class="hostelsd">
                <img src="images/tagore.webp" alt="">
                <h1>TAGORE HOSTEL</h1>
            </div>
        </a>
        <a href="studentrooms.php?hostels=ramanujan&selected_hostel=RAMANUJAN_HOSTEL">
            <div class="hostelsd">
                <img src="images/ramanujan.webp" alt="">
                <h1>RAMANUJAN HOSTEL</h1>
            </div>
        </a>
        <a href="studentrooms.php?hostels=nalanda&selected_hostel=NALANDA_HOSTEL">
            <div class="hostelsd">
                <img src="images/nalanda.webp" alt="">
                <h1>NALANDA HOSTEL</h1>
            </div>
        </a>
        <a href="studentrooms.php?hostels=vivekananda&selected_hostel=VIVEKANANDA_HOSTEL">
            <div class="hostelsd">
                <img src="images/vivakanandha.webp" alt="">
                <h1>VIVEKANANDA HOSTEL</h1>
            </div>
        </a>
    <?php } else { ?>
        <!-- Display female hostels -->
        <a href="studentrooms.php?hostels=spoorthi&selected_hostel=SPOORTHI_HOSTEL">
            <div class="hostelsd">
                <img src="images/spoorthi.webp" alt="">
                <h1>SPOORTHI HOSTEL</h1>
            </div>
        </a>
        <a href="studentrooms.php?hostels=prathibha&selected_hostel=PRATHIBHA_HOSTEL">
            <div class="hostelsd">
                <img src="images/prathibha.webp" alt="">
                <h1>PRATHIBHA HOSTEL</h1>
            </div>
        </a>
    <?php } ?>
</div>

    <div class="graphs" style="width: 80%; height: 500px; ">
    <div id="columnchart_material" style="width: 100%; height: 100%;margin-left:50px"></div>
</div>


    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdownMenu");
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
        document.addEventListener("click", function(event) {
            var dropdown = document.getElementById("dropdownMenu");
            var profile = document.querySelector('.profile');
            if (!profile.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['hostel', 'fees(k)'],
          ['prathiba', 90000],
          ['spoorthy', 77000],
          ['c v Raman', 90000],
          ['nalanda', 88000],
          ['tagore', 88000],
          ['bhatnagar', 88000],
          ['ramanujan', 88000],
          ['vivekananda', 75000]
        ]);

        var options = {
    chart: {
        title: 'Hostel fee structure',
        subtitle: 'fees',
    },
    width: '100%', // Set chart width to 100% of container
    height: '100%' // Set chart height to 100% of container
};


        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

      function feestructure(){
        let feestructure=document.querySelector(".graphs")
        hostelsd=document.querySelector(".stbackground")
        feestructure.style.display="block";
        hostelsd.style.display="none";
      }
      let rules=document.querySelector(".rulescontainer")
            let rcon=document.querySelector(".roomscontainer")
            rules.style.display="block";
            rcon.style.display="none";

    </script>
</body>
</html>