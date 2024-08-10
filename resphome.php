<!-- resphome.php -->
<?php
$errors = array();
$success_message = "";

session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
}

if(isset($_POST['submit'])){
    $stname = $_POST['stname'];
    $stID = $_POST['stID'];
    $stmobile = $_POST['stmobile'];
    $stgender = $_POST['stgender'];
    $styear = $_POST['styear'];
    $stbranch = $_POST['stbranch'];
    $stparentname = $_POST['stparentname'];
    $stparentnum = $_POST['stparentnum'];
    $stpass = $_POST['stpass'];

    if(empty($stname) || empty($stID) || empty($stmobile) || empty($stgender) || empty($styear) || empty($stbranch) || empty($stparentname) || empty($stparentnum) || empty($stpass)){
        $errors[] = "All fields are required";
    } else {
        if(preg_match('/\s/', $stID) || preg_match('/\s/', $stname)){
            $errors[] = "Student ID and Name cannot contain spaces";
        }
        if(preg_match('/^0+$/', $stmobile) || strlen($stmobile) !== 10){
            $errors[] = "Invalid mobile number format";
        }
        if(preg_match('/^0+$/', $stparentnum) || strlen($stparentnum) !== 10){
            $errors[] = "Invalid father's number format";
        }
        if(preg_match('/\s/', $stparentname) || preg_match('/\s/', $stparentnum)){
            $errors[] = "Father's Name and Number cannot contain spaces";
        }
        if(preg_match('/\s/', $stpass)){
            $errors[] = "Password cannot contain spaces";
        }
        if(empty($errors)){
            require_once "connection.php"; 
            $sql_check_existing = "SELECT * FROM f1 WHERE stmobile=? OR stID=?";
            $stmt_check_existing = mysqli_prepare($conn, $sql_check_existing);
            mysqli_stmt_bind_param($stmt_check_existing, "ss", $stmobile, $stID);
            mysqli_stmt_execute($stmt_check_existing);
            mysqli_stmt_store_result($stmt_check_existing);

            if(mysqli_stmt_num_rows($stmt_check_existing) > 0) {
                $errors[] = "Mobile number or Student ID already exists";
            } else {
                $sql_insert = "INSERT INTO f1 (stname, stID, stmobile, stgender, styear, stbranch, stparentname, stparentnum, stpass) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($conn, $sql_insert);
                
                if ($stmt_insert) {
                    mysqli_stmt_bind_param($stmt_insert, "sssssssss", $stname, $stID, $stmobile, $stgender, $styear, $stbranch, $stparentname, $stparentnum, $stpass);

                    if(mysqli_stmt_execute($stmt_insert)){
                        $success_message = "Registration successful";
                    } else {
                        $errors[] = "Error occurred while registering. Please try again.";
                    }
                } else {
                    $errors[] = "Error preparing the statement. Please try again.";
                }
            }
            if ($stmt_check_existing) {
                mysqli_stmt_close($stmt_check_existing);
            }
            if ($stmt_insert) {
                mysqli_stmt_close($stmt_insert);
            }
            mysqli_close($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>home</title>
<link rel="stylesheet" href="resphome.css">
<style>
    .login-section {
    height: 270px;
    }
        .error {
            color: red;
            margin-bottom: 10px;
        }

        .error ul {
            list-style-type: none;
            padding: 0;
        }

        .error li {
            margin-bottom: 5px;
        }
        .success{
            color:white;
        }
        .signupdetails form input, select {
    font-size: 0.9rem;
    border: none;
    border-bottom: 2px solid black;
    width: 350px;
    height: 30px;
    margin-bottom: 10px;
}
        @media screen and  (max-width: 770px) {
.signupdetails form input, select {
    font-size: 0.7rem;
    border: none;
    border-bottom: 2px solid black;
    width: 300px;
    height: 27px;
    margin-bottom: 10px;
}
}
@media screen and  (max-width: 660px) {
.signupdetails form input, select {
    font-size: 0.8rem;
    border: none;
    border-bottom: 2px solid black;
    width: 250px;
    height: 25px;
    margin-bottom: 10px;
}
}
@media screen and  (max-width: 560px) {
.signupdetails form select {
    font-size: 0.8rem;
    border: none;
    border-bottom: 2px solid black;
    width: 250px;
    height: 25px;
    margin-bottom: 8px;
}
.sbox {
    gap: 1.5rem;
}
}
@media screen and  (max-width: 490px) {
.sbox {
    flex-direction: column;
}
.signupdetails form select {
    font-size: 0.8rem;
    margin-bottom: 5px;
    width: 250px;
}
}
.title {
    text-align: center;
    margin-top: 0px;
    margin-bottom: 0;
    font-size: 2em;
    color: white;
    text-shadow: 2px 2px 10px black;
    padding: 8px 0;
    height: 30vh;
    position: relative;
    background-image: url('images/bvrit.jpeg');
    background-size: cover;
    background-position: center;
    overflow: hidden;
	object-fit: cover;
}
#signup {
    background-image: linear-gradient(rgba(0,0,0,0.7),rgba(228, 228, 226, 0.7)), url(images/bvritc.jpeg);
    height: 100vh;
    width: 100%;
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
</head> 
<body>
<header>
    <div class="navbar">
        <div class="brand-title">
            <img src="images/bvrit_logo.png" alt="">
        </div>
        <a href="#" class="toggle-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </a>
        <div class="navbar-links">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#signup">Signup</a></li>
            </ul>
        </div>
    </div>
</header>
<div class="naac">
    <marquee behavior="fast" direction="right">ACCREDITED BY NAAC WITH AN A+ GRADE &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; EAMCET | ECET | ICET | CODE : BVRI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PGECET | CODE : BVRI1</marquee>
</div>
<div id="home">
    <div class="title">
        <div class="placeholder"></div>
        <h1>Welcome to BVRIT Hostels</h1>
    </div>
    <div class="login-options">
        <div class="login-section student-login">
            <h2 class="login-title">Student Login</h2>
            <div class="8">
            <form class="studentloginbox" action="studentlogin.php" method="POST">
                        <input type="text" class="input-field" name="stID" placeholder="stID" required>
                        <input type="password" class="input-field" name="stpass" placeholder="stpass" required>
                        <button type="submit" class="login-button" name="submit">Login</button>
                    </form>
            </div>
        </div>
        <div class="login-section management-login">
            <h2 class="login-title">Management Login</h2>
            <form action="management.php" method="POST">
        <input type="text" class="input-field" name="incharge_id" placeholder="Incharge ID" required>
        <input type="password" class="input-field" name="password" placeholder="Password" required>
        <button type="submit" class="login-button">Login</button>
    </form>
        </div>
    </div>
</div>
<!-- ------------------about section ---------------------- -->
<section id="about">
    <div class="abtsection">
        <div class="placeholder"></div>
        <div class="aboutus">
            ABOUT US
        </div>
        <div class="space evenly ">
            <p class="bold">
                Welcome to BVRIT College Hostels
            </p>
            <p>At BVRIT College, we believe in providing not just education but also a nurturing environment where
                students
                can
                thrive both academically and personally. Our hostels are an integral part of this environment,
                offering
                a
                comfortable and secure home away from home for our students.
            </p>
        </div>
        <div class="space evenly ">
            <div class="bold">Our Mission:</div>

            <p>Our mission is to create a supportive and inclusive community within our hostels, where students from
                diverse
                backgrounds can live, learn, and grow together.
            </p>
        </div>
        <div class="space evenly ">
            <div class="bold">Key Features:</div>
            <p>Modern and well-equipped hostel facilities
                Dedicated hostel staff committed to student well-being
                Focus on creating a conducive environment for academic success
                Regular recreational and extracurricular activities to promote social interaction and personal
                development
            </p>
        </div>
        <div class="space evenly ">
            <div class="bold">Why Choose BVRIT Hostels:</div>
            <p> Convenient location within the college campus
                Safe and secure environment with 24/7 security
                Amenities such as Wi-Fi, laundry facilities, and common areas for recreation and study
                Opportunities for personal growth and community engagement through various events and initiatives
            </p>
        </div>
    </div>
</section>
<!-- services section ----------------------------------------------------------- -->
<section id="services">
    <div class="servicesce">
        <div class="survhead">
            <h1>SERVICES</h1>
        </div>
        <div class="sec1 padd">
            <div class="bold center ">
               <h1>Accommodation:</h1> 
            </div>
            <div class="twobox">
                <div class="cont">
                    Spacious and comfortable rooms with options for single or shared occupancy
                    Bed, mattress, study table, and wardrobe provided in each room
                    Regular cleaning and maintenance to ensure a hygienic environment
                </div>
                <div class="imgcont">
                    <img class="img" src="images/bhostel.jpg" alt=" bvrit rooms ">
                </div>
            </div>
        </div>
       <div class="sec2 padd">
            <div class="bold center "> <h1>Dining Facilities:</h1>
            </div>
            <div class="twobox">
                <div class="cont">Well-equipped dining hall serving nutritious and delicious meals
                    Otionp for vegetarian and non-vegetarian meals to cater to diverse preferences
                    Special arrangements for dietary restrictions or special occasions upon request</div>
                <div class="imgcont">
                    <img class="img" src="images/dining_bvrit.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="sec3 padd">
            <div class="bold center "><h1>Facilities:</h1>
            </div>
            <div class="twobox">
                <div class="cont">
                    Indoor and outdoor sports facilities for fitness and leisure
                    At our college, our state-of-the-art gym facilities offer a comprehensive range of equipment,
                    catering to the diverse fitness needs of our students. From cutting-edge cardio machines and
                    free weights to resistance training apparatus, our gym is equipped to accommodate various
                    workout preferences. The spacious layout fosters a comfortable and motivating environment,
                    encouraging a dynamic fitness experience.
                </div>
                <div class="imgcont">
                    <img class="img" src="images/bvrigym.jpg" alt=" bvrit rooms ">
                </div>
            </div>
        </div>
        <div class="sec4 padd">
            <div class="bold center "><h1>Events</h1></div>
            <div class="twobox">
                <div class="cont">
                    At our college, vibrant events enrich campus life, fostering a sense of community and
                    engagement. From academic conferences and cultural festivals to sports competitions and creative
                    showcases, our diverse events cater to various interests. These gatherings not only enhance the
                    overall college experience but also create lasting memories and connections among students.
                </div>
                <div class="imgcont">
                    <img class="img" src="images/hostelday.jpg" alt=" bvrit rooms ">
                </div>
            </div>
        </div>
        <div class="sec5 padd">
            <div class="bold center "><h1>Medical Facilities</h1></div>
            <div class="twobox">
                <div class="cont">
                    At our college, vibrant events enrich campus life, fostering a sense of community and
                    engagement. From academic conferences and cultural festivals to sports competitions and creative
                    showcases, our diverse events cater to various interests. These gatherings not only enhance the
                    overall college experience but also create lasting memories and connections among students.
                </div>
                <div class="imgcont">
                    <img class="img" src="images/bvrithospital.jpg" alt=" bvrit rooms ">
                </div>
            </div>
        </div>
    </div>
</section>
<section id="signup">
    <div class="signup_container">
        <div class="signupdetails">
            <h2>Signup</h2>
            <!-- Display error messages -->
            <?php 
                if(!empty($errors)){
                    echo "<div class='error'>";
                    echo "<ul>";
                    foreach($errors as $error){
                        echo "<li>$error</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } elseif(!empty($success_message)) {
                    echo "<div class='success'>$success_message</div>";
                }
                ?>
            <form id="signupForm" name="form" action="resphome.php#signup" method="POST">
                <div class="sbox">
                    <div class="sleft side">
                        <input type="text" name="stname" placeholder="Enter Your Name" value="" required>
                        <input type="text" name="stID" placeholder="Enter Your ID" value="" required>
                        <input type="text" name="stmobile" placeholder="Enter Your Mobilenumber" required>
                        <select name="stgender" id="" required>
                            <option value="" selected hidden>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <select name="styear" id="" required>
                            <option value="" selected hidden>Select Year</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                        </select>                       
                    </div>
                    <div class="sright side">
                        <select name="stbranch" id="" required>
                            <option value="" selected hidden>Select Your Branch</option>
                            <option value="CSE">CSE</option>
                            <option value="IT">IT</option>
                            <option value="ECE">ECE</option>
                            <option value="EEE">EEE</option>
                            <option value="PHE">PHE</option>
                            <option value="CIVIL">CIVIL</option>
                            <option value="MECH">MECH</option>
                            <option value="BME">BME</option>
                            <option value="CSM">CSM</option>
                            <option value="CSD">CSD</option>
                            <option value="AIDS">AIDS</option>
                            <option value="CSBS">CSBS</option>
                        </select>
                        <input type="text" name="stparentname" placeholder="Enter Your Parent Name" required>
                        <input type="text" name="stparentnum" placeholder="Enter Your Parent Number" required>
                        <input type="password" name="stpass" placeholder="Enter Your Password" required>
                        <!-- <input type="password" name="strepass" placeholder="Re-enter Your Password" required> -->
                    </div>
                </div>
                <div class="subbtn">
                    <input class="sub" type="submit" value="Signup" name="submit">
                </div>
            </form>
        </div>
    </div>
</section>
<script>
const toggleButton = document.querySelector('.toggle-button');
const navbarLinks = document.querySelector('.navbar-links');
const navLinks = document.querySelectorAll('.navbar-links a');

toggleButton.addEventListener('click', () => {
    navbarLinks.classList.toggle('active');
});

navLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        const targetId = link.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        if (targetSection) {
            targetSection.scrollIntoView({ behavior: 'smooth' });
        }
        navbarLinks.classList.remove('active');
    });
});
</script>
</body>
</html>