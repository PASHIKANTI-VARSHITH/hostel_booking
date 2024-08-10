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
            font-size: 0.7rem;
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
            margin: 5px;
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
    </style>
</head>
<body>
    <div class="roomsnavbar">
            <div class="roomslogo">
                <a href="studentprofile.php"><img src="images/bvrit_logo.png" alt=""></a>
            </div>
            <div class="profile" onclick="toggleDropdown()">
                <i class='bx bx-user'></i><i class='bx bx-caret-down'></i>
                <div class="dropdown-menu" id="dropdownMenu">
                    <ul>
                        <li><a href="#"><i class='bx bxs-user-detail'></i> Profile</a></li>
                        <li><a href="#"><i class='bx bx-log-out'></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    <div class="ht">
        <h2>HOSTELS</h2>
    </div>
    <div class="stbackground">
        <a href="studentrooms.php?hostels=spoorthi">
            <div class="hostelsd">
            <img src="images/spoorthi.webp" alt="">
            <h1>SPOORTHI HOSTEL</h1>
        </div></a>
        <a href="studentrooms.php?hostels=prathibha">
            <div class="hostelsd">
            <img src="images/prathibha.webp" alt="">
            <h1>PRATHIBHA HOSTEL</h1>
        </div></a>
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
</body>
</html>