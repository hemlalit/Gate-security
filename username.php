<?php
session_start();
include 'config.php';

$fname = $_SESSION['fname'];
$name = $_SESSION['name'];
$phone = $_SESSION['phone'];
echo $name;
if(isset($_SESSION['ctrl_id'])) $ctrl_id = $_SESSION['ctrl_id'];
if(isset($_SESSION['c_name'])) $company_name = $_SESSION['c_name'];
if(isset($_SESSION['id'])) $id = $_SESSION['id'];
if(isset($_SESSION['parent'])) $parent = $_SESSION['parent'];
if(isset($_SESSION['visitor'])) $visitor = $_SESSION['visitor'];
// $parent = $_SESSION['vendor'];
$update1 = $update2 = 0;

// $vendor = $_SESSION['vendor'];
// $visitor = $_SESSION['visitor'];

// $select = mysqli_query($conn, "SELECT * FROM users WHERE phone = '" . $phone . "' AND name = '" . $name . "' ") or die('query failed');
// $row = mysqli_fetch_assoc($select);
// echo $row['phone'];

$username = $fname;
$phone = strval($phone);
$username .= substr($phone, 5, 10);

if (isset($_POST['submit'])) {

    $pwd = mysqli_real_escape_string($conn, $_POST['password']);

    if (isset($parent)) {

        // Disable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");

        // Update user table
        $updateUserQuery = "UPDATE user SET u_userName = '$username', password = '$pwd' WHERE phone = '$phone' AND u_name = '$name'";
        $update1 = mysqli_query($conn, $updateUserQuery) or die('query failed');
        // Update parent table
        $updateParentQuery = "UPDATE parent SET u_userName = '$username' WHERE childCtrl_id = '$ctrl_id'";
        $update2 = mysqli_query($conn, $updateParentQuery) or die('query failed');

        // Enable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
        unset($_SESSION['parent']);
    } else if (isset($visitor)) {
        // Disable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");

        // Update user table
        $updateUserQuery = "UPDATE user SET u_userName = '$username', password = '$pwd' WHERE phone = '$phone' AND u_name = '$name'";
        $update1 = mysqli_query($conn, $updateUserQuery) or die('query failed');
        // Update visitor table
        $updateVisitorQuery = "UPDATE visitor SET u_userName = '$username' WHERE id = '$id' ";
        $update2 = mysqli_query($conn, $updateVisitorQuery) or die('query failed');

        // Enable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");

        unset($_SESSION['visitor']);
    } else {
        // Disable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");

        // Update user table
        $updateUserQuery = "UPDATE user SET u_userName = '$username', password = '$pwd' WHERE phone = '$phone' AND u_name = '$name'";
        $update1 = mysqli_query($conn, $updateUserQuery) or die('query failed');
        // Update vendor table
        $updateVendorQuery = "UPDATE vendor SET u_userName = '$username' WHERE compName = '$company_name' ";
        $update2 = mysqli_query($conn, $updateVendorQuery) or die('query failed');

        // Enable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
    }


    if ($update1 && $update2) {
        header('location: logPage/login.php');
    } else {
        $msg = 'something went wrong!';
    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="index.css"> -->
    <link rel="stylesheet" href="username.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" /> -->
    <title>Vaze Security | Your Username</title>
</head>

<body>
    <a class="info" href="#">
        <div class="logo">
            <img src="images/college_logo.jpg" alt="college logo" />
        </div>
        <p>Your UserName...</p>
    </a>

    <div class="username-popup" id="popup">
        <h2>Thank you!</h2>
        <p>Your details has been submitted successfully!</p>
        <div class="username">
            <div class="copy-username">
                <p id="username"> <?php if (isset($username))
                    echo $username ?> </p>
                    <div class="tooltip">
                        <label id="label" onclick="myFunction()" onmouseout="outFunc()">
                            <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
                            copy
                        </label>
                    </div>
                </div>
                <form action="" method="post" enctype="multipart/form-data" class="form">
                    <div class="form-element">
                        <label>Set Password</label>
                        <input type="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <button type="submit" name="submit">SET</button>
                </form>
            </div>
        </div>

        <script src="username.js"></script>
    </body>

    </html>