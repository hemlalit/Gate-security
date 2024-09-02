<?php

include 'config.php';
session_start();

if (isset($_SESSION['username'])) {
    header('location: homePage/home.php');
}

if (isset($_SESSION['staff-data'])) {
    header('location: staffPage/staff.php');
}

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    if (isset($_POST['p_user']))
        $parent = mysqli_real_escape_string($conn, $_POST['p_user']);
    if (isset($_POST['v_user']))
        $visitor = mysqli_real_escape_string($conn, $_POST['v_user']);
    if (isset($_POST['ve_user']))
        $vendor = mysqli_real_escape_string($conn, $_POST['ve_user']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // $pwd = mysqli_real_escape_string($conn, $_POST['password']);
    if (isset($_POST['cid']))
        $ctrl_id = mysqli_real_escape_string($conn, $_POST['cid']);
    if (isset($_POST['c_name']))
        $company_name = mysqli_real_escape_string($conn, $_POST['c_name']);
    $aadhar_img_name = $_FILES['aadhar']['name'];
    $aadhar_size = $_FILES['aadhar']['size'];
    $aadhar_tmp_name = $_FILES['aadhar']['tmp_name'];
    $image_folder = 'images/aadhar/' . $aadhar_img_name;

    $select = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' ") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $msg = 'email already exists';
    } else {
        $select1 = mysqli_query($conn, "SELECT * FROM user WHERE phone = '$phone' ") or die('query failed');

        if (mysqli_num_rows($select1) > 0) {
            $msg = 'phone no. already exists';
        } else if ($aadhar_size > 2000000) {
            $msg = 'image is too large';
        } else {
            if (isset($parent)) {
                $insert = mysqli_query($conn, "INSERT INTO user (u_name, userType, phone, email, idProof) values('$name', '$parent', '$phone', '$email', '$aadhar_img_name')") or die('query failed');
                $insert2 = mysqli_query($conn, "INSERT INTO parent (childCtrl_id) values('$ctrl_id')");
                $_SESSION['parent'] = $parent;
                $_SESSION['ctrl_id'] = $ctrl_id;
            } else if (isset($visitor)) {
                $id = rand();
                $id .= substr($name, 0, 2);

                mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");
                $insert = mysqli_query($conn, "INSERT INTO user (u_name, userType, phone, email, idProof) values('$name', '$visitor', '$phone', '$email', '$aadhar_img_name')") or die('query failed');
                $insert = mysqli_query($conn, "INSERT INTO visitor (id) values('$id')") or die('query failed');
                mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");

                $_SESSION['visitor'] = $visitor;
                $_SESSION['id'] = $id;
            } else {
                mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");
                $insert = mysqli_query($conn, "INSERT INTO user (u_name, userType, phone, email, idProof) values('$name', '$vendor', '$phone', '$email', '$aadhar_img_name')") or die('query failed');
                $insert2 = mysqli_query($conn, "INSERT INTO vendor (compName) values('$company_name')");
                mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
                // $_SESSION['vendor'] = $vendor;
                $_SESSION['c_name'] = $company_name;
            }

            $first_name = preg_split('[ ]', $name);
            $_SESSION['fname'] = $first_name[0];
            $_SESSION['name'] = $name;
            $_SESSION['phone'] = $phone;

            if ($insert) {
                move_uploaded_file($aadhar_tmp_name, $image_folder);
                header('location: username.php');
            } else {
                $msg = 'Registeration failed!!';
            }
        }
    }
}

if (isset($_POST['hidden_login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // $role = mysqli_real_escape_string($conn, $_POST['role']);

    $select = mysqli_query($conn, "SELECT * FROM college_staff WHERE s_userName = '$username' AND password = '$password' ");

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['staff-data'] = $row;
        header('location: staffPage/staff.php');
    } else {
        echo ' <script> alert("User does\'nt exist!!") </script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="index.css">

    <link rel=”stylesheet” href=”http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css” />
    
    <!----======== jQuery ======== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src=”http://code.jquery.com/jquery-1.11.1.min.js”></script>
    <script src=”http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js”></script>

    <title>Vaze Security</title>
</head>

<body>
    <!-- <script>
        alert(hello)
    </script> -->
    <div class="container">
        <div class="info">
            <img class="logo" src="images/college_logo.jpg" alt="college logo" />
            <a class="greet" href="#">
                <p>Welcome to Vaze Security,</p>
                <!-- <p>who are you?</p> -->
                <div style="height:50px"></div>
            </a>
            <?php
            if (isset($msg)) {
                echo "<script>
                        alert('" . $msg . "')
                      </script>";
            }
            ?>
        </div>
        <div class="options">
            <label for="parent" class="show-login parent">Parent</label>
            <!-- <input type="checkbox" id="parent"> -->
            <label for="visitor" class="show-login visitor">Visitor</label>
            <!-- <input type="checkbox" id="visitor"> -->
            <label for="vendor" class="show-login vendor">Vendor</label>
            <!-- <input type="checkbox" id="vendor"> -->
        </div>
        <div class="login">
            Or want to login? <a href="logPage/login.php">Login here</a>
        </div>
        <div class="popup hide">
            <div class="close-btn fas fa-times"></div>
            <h2>Register here</h2>
            <form action="" method="post" enctype="multipart/form-data" class="form">
                <div class="flexBox">
                    <div class="box">
                        <div class="form-element">
                            <label>Name</label>
                            <input type="text" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="phone">
                            <div class="form-element">
                                <label>Phone</label>
                                <input type="phone" name="phone" placeholder="Enter phone no." required>
                            </div>
                        </div>
                        <div class="form-element">
                            <label>Email</label>
                            <input type="text" name="email" placeholder="Enter email" required>
                        </div>
                    </div>
                    <div class="box">
                        <div class="form-element" id="cid">
                            <label>Child's Control Id</label>
                            <input id="c-id" type="text" name="cid" placeholder="Enter your child's control id">
                        </div>
                        <div class="form-element" id="cname">
                            <label>Company name</label>
                            <input id="c-name" type="text" name="c_name" placeholder="Enter your company's name">
                        </div>
                        <div class="form-element" id="p_user">
                            <label>User Type</label>
                            <input id="parent" type="text" name="p_user" value="parent" readonly>
                        </div>
                        <div class="form-element" id="v_user">
                            <label>User Type</label>
                            <input id="visitor" type="text" name="v_user" value="visitor" readonly>
                        </div>
                        <div class="form-element" id="ve_user">
                            <label>User Type</label>
                            <input id="vendor" type="text" name="ve_user" value="vendor" readonly>
                        </div>
                        <div class="aadhar">
                            <label>Aadhar</label>
                            <div class="input">
                                <input type="file" name="aadhar" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn">
                    <div class="inner"></div>
                    <button type="submit" name="submit">Register</button>
                </div>
            </form>
            <!-- <div class="signup-link">already registered? <a href="logPage/login.php">Login now</a></div> -->
        </div>

        <div class="popup-overlay" id="popupOverlay">

            <div class="popup-staff" id="popup-staff">

                <span class="close" id="closePopup">&times;</span>

                <div class="popup-content">

                    <h3>Admin & Staff login portal</h3>

                    <!-- <p>login with proper cred's</p> -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <i class="fas fa-eye"></i>
                        <!-- <select name="role" id="role" required>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teaching Staff</option>
                            <option value="security">Security Staff</option>
                            <option value="no-teacher">NonTeaching Staff</option>
                        </select> -->

                        <button type="submit" name="hidden_login">Login</button>
                    </form>
                    <!-- <p>Not registered? <a href="#">register here</a></p> -->
                </div>

            </div>

        </div>

    </div>

    <script src="script.js"></script>

    <!-- <div class="username-popup" id="popup">
            <img src="images/tick.png" alt="">
            <h2>Thank you!</h2>
            <p>Your details has been submitted successfully!</p>
            <div class="username">
                Your UserName
                <div>******</div>
                <div class="form">
                    <div class="form-element">
                        <label>Set Password</label>
                        <input type="password" name="password" placeholder="Enter Password" required>
                    </div>
                </div>
            </div>
            <button type="button" onclick="closePopup()">SET</button>
        </div> -->



    <script src="index.js"></script>
</body>

</html>