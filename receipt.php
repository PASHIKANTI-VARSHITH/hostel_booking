<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: studentlogin.php");
    exit;
}

// Include the database connection file
require_once "connection.php";

// Retrieve student ID from session variable
$studentId = $_SESSION['studentId'];

// Prepare SQL statement to fetch student details
$sql = "SELECT stname, styear, stparentname,bed_fee,booking_date,receipt_number FROM f1 WHERE stID=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $studentId);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

// Bind variables to prepared statement
mysqli_stmt_bind_result($stmt, $studentName, $studentYear, $studentParentName,$hostelFee, $bookingdate ,$receiptnumber);

// Fetch student details
mysqli_stmt_fetch($stmt);

// Close statement
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 60%;
            margin: 20px auto;
            border: 1px solid black;
            padding: 20px;
        }
        .header {
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        .header h3, .header p {
            margin: 5px 0;
        }
        .details {
            margin: 20px 0;
        }
        .details p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .header .rdet{
            width: 90%;
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
        .head{
            width: 100%;
            background-color: rgb(49, 50, 52);
            color: white;
            text-align: center;
        }
        .downloadb{
            width: 100%;
            display:flex;
            justify-content: center;
            margin-bottom:20px;
        }
        .downloadb button{
            background-color: rgb(15, 190, 15);
            border-radius: 5px;
            padding: 5px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="roomsnavbar">
        <div class="roomslogo">
            <a href="studentprofile.php"><img src="images/bvrit_logo.png" alt=""></a>
        </div>
    </div>
    <div class="head">
        <h2>Fee receipt</h2>
    </div>
    <div class="container" id="receipt">
        <div class="header">
            <div class="rlogo">
                <img src="images/bvlogo.png" alt="Logo">
            </div>
            <div class="rdet">
                <h3>B. V. RAJU INSTITUTE OF TECHNOLOGY (AUTONOMOUS)</h3>
                <p>Approved By AICTE, New Delhi., Affiliated to JNTU, Hyderabad</p>
                <p>Vishnupur, Narsapur, Medak District - 502 313</p>
                <p>Tel : 08458222000</p>
            </div>
        </div>
        <div class="details">
            <p>Receipt No: <?php echo $receiptnumber; ?></p>
            <p>Date : <?php echo  $bookingdate; ?></p>
            <p>Roll No:<?php echo $studentId; ?></p>
            <p>Name:<?php echo $studentName; ?></p>
            <p>Year:<?php echo $studentYear; ?></p>
            <p>Father's Name: <?php echo $studentParentName; ?></p>
        </div>
        <table class="table">
            <tr>
                <th>Sl. No</th>
                <th>Particulars</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Hostel Fee Fee(<?php echo $studentYear; ?> Year)</td>
                <td><?php echo $hostelFee; ?></td>
            </tr>
        </table>
        <div class="total">
            <p>total  : <?php echo $hostelFee; ?></p>
        </div>
        <div class="footer">
            <p>Gateway Reference No: CPADUIWDX4</p>
            <p>College Reference No: BVRITN376520</p>
        </div>
    </div>
    <div class="downloadb">
        <button onclick="downloadPDF()">Download as PDF</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            html2canvas(document.querySelector("#receipt")).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const imgProps = doc.getImageProperties(imgData);
                const pdfWidth = doc.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                doc.save("receipt.pdf");
            });
        }
    </script>
</body>
</html>



