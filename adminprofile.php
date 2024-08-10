<!-- adminprofile.php -->
<?php
// Start the session
session_start();
require_once "connection.php";
// Retrieve selected hostel name from URL parameter
$selectedHostel = isset($_GET['selected_hostel']) ? $_GET['selected_hostel'] : "";

$_SESSION['selectedHostel'] = $selectedHostel;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="adminrooms.css">
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
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
        .st{
            text-align: center;
            background-color: black;
            color: white;
            padding: 3px;
            font-size: 1rem;
        }
        .studentsl{
            gap: 1rem;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }
        .students{
            text-decoration: none;
            color:black;
            border: 2px solid black;
            padding: 5px 15px;
            margin: 5px;
            font-size: 1.2rem;
            box-shadow: 8px 8px 8px gray;
            transition: transform 0.3s ease-in-out;
            background-color: rgb(243, 238, 238);
        }
        .students:hover {
            transform: scale(1.05); /* Zoom effect on hover */
        }
        .stho{
            display:grid;
            grid-template-columns: 1fr 1fr;
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
        .log a{
            text-decoration:none;
            color:black;
        }
    </style>
</head>
<body>
<div class="roomsnavbar">
            <div class="roomslogo">
                <img src="images/bvrit_logo.png" alt="">
            </div>
            <div class="log">
            <a href="resphome.php?logout=true"><i class='bx bx-log-out'></i> Logout</a>
            </div>
    </div>
    </div>
        <div class="allhostels">
            <div class="ht">
                <h2>HOSTELS</h2>
            </div>
            <div class="stbackground">
                <a href="adminrooms.php?hostel=cvraman&selected_hostel=CVRAMAN_HOSTEL"">
                    <div class="hostelsd">
                    <img src="images/cvraman.webp" alt="">
                    <h1>C.V.RAMAN HOSTEL</h1>
                </div></a>
                <a href="adminrooms.php?hostel=bhatnagar&selected_hostel=BHATNAGAR_HOSTEL"">
                    <div class="hostelsd">
                    <img src="images/bhatnagar.webp" alt="">
                    <h1>BHATNAGAR HOSTEL</h1>
                </div></a>
                <a href="adminrooms.php?hostel=tagore&selected_hostel=TAGORE_HOSTEL"">
                    <div class="hostelsd">
                    <img src="images/tagore.webp" alt="">
                    <h1>TAGORE HOSTEL</h1>
                </div></a>
                <a href="adminrooms.php?hostel=ramanujan&selected_hostel=RAMANUJAN_HOSTEL"">
                    <div class="hostelsd">
                    <img src="images/ramanujan.webp" alt="">
                    <h1>RAMANUJAN HOSTEL</h1>
                </div></a>
                <a href="adminrooms.php?hostel=nalanda&selected_hostel=NALANDA_HOSTEL"">
                    <div class="hostelsd">
                    <img src="images/nalanda.webp" alt="">
                    <h1>NALANDA HOSTEL</h1>
                </div></a>
                <a href="adminrooms.php?hostel=vivekananda&selected_hostel=VIVEKANANDA_HOSTEL">
                    <div class="hostelsd">
                    <img src="images/vivakanandha.webp" alt="">
                    <h1>VIVAKANANDA HOSTEL</h1>
                </div></a>
                <a href="adminrooms.php?hostel=prathibha&selected_hostel=PRATHIBHA_HOSTEL"">
                    <div class="hostelsd">
                    <img src="images/prathibha.webp" alt="">
                    <h1>PRATHIBHA GIRLS HOSTEL</h1>
                </div></a>
                <a href="adminrooms.php?hostel=spoorthi&selected_hostel=SPOORTHI_HOSTEL">
                    <div class="hostelsd">
                    <img src="images/spoorthi.webp" alt="">
                    <h1>SPOORTHI GIRLS HOSTEL</h1>
                </div></a>
            </div>
        </div>
    <div class="stho">
        <div class="allstudents">
            <div class="st">
                <h2>BOYS STUDENTS LIST</h2>
            </div>
            <div class="studentsl">
                <a href="table.php?year=1st&gender=male" class="students">1st Year Boys</a>
                <a href="table.php?year=2nd&gender=male" class="students">2nd Year Boys</a>
                <a href="table.php?year=3rd&gender=male" class="students">3rd Year Boys</a>
                <a href="table.php?year=4th&gender=male" class="students">4th Year Boys</a>
            </div>
        </div>
        <div class="allstudents">
            <div class="st">
                <h2>GIRLS STUDENTS LIST</h2>
            </div>
            <div class="studentsl">
                <a href="table.php?year=1st&gender=female" class="students">1st Year Girls</a>
                <a href="table.php?year=2nd&gender=female" class="students">2nd Year Girls</a>
                <a href="table.php?year=3rd&gender=female" class="students">3rd Year Girls</a>
                <a href="table.php?year=4th&gender=female" class="students">4th Year Girls</a>
            </div>
        </div>
    </div> 
</body>
</html>