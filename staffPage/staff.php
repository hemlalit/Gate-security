<?php

include '../config.php';
include '../encrypt_decrypt.php';
session_start();
date_default_timezone_set("Asia/Kolkata");

$fp = fsockopen("www.example.com", 80);
//website, port (try 80 or 443)
if (!$fp) {
    echo '
    <script>
        alert("No Internet connection!!\nFirst Connect")
    </script>
    ';
}

if (!isset($_SESSION['staff-data'])) {
    header('location:../index.php');
} else {

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!----======== CSS ======== -->
        <link rel="stylesheet" href="staff.css">
        <link rel="stylesheet" href="../index.css">
        <link rel="stylesheet" href="../profilePage/editProfile.css">

        <!----======== jQuery ======== -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <!----===== Boxicons CSS ===== -->
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

        <title>Vaze Security | Staff</title>
    </head>

    <body>
        <?php

        $today = date('d/m/Y');
        // echo $today;
        $sql = "SELECT id, status FROM visits WHERE date_of_visit = '$today' ORDER BY id DESC ";
        $select = mysqli_query($conn, $sql);

        if (mysqli_num_rows($select)) {
            while ($row = mysqli_fetch_assoc($select)) {

                if ($row['status'] == 'entered') {
                    echo "
                        <script>
                            $(document).ready(function () {
                                $('.green-badge" . $row['id'] . "').css({'display': 'block', 'background-color': '#3af402' });
                                $('.green-badge" . $row['id'] . "').text('Entered')
                            });
                        </script>
                    ";

                } else if ($row['status'] == 'entered&met') {
                    echo "
                        <script>
                            $(document).ready(function () {
                                $('.red-badge" . $row['id'] . "').css({'display': 'block', 'background-color': '#ff000d'});
                                $('.red-badge" . $row['id'] . "').text('Meeting Over')
                            });
                        </script>
                    ";
                } else if ($row['status'] == 'entered&met&exited') {
                    echo "
                        <script>
                            $(document).ready(function () {
                                $('.red-badge" . $row['id'] . "').css({'display': 'block', 'background-color': '#ff000d'});
                                $('.red-badge" . $row['id'] . "').text('Exited')
                            });
                        </script>
                    ";
                }
            }
        }

        $staffData = $_SESSION['staff-data'];
        $_SESSION['security'] = $staffData['s_userName'];

        ?>

        <nav class="sidebar close">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="../images/college_logo.jpg" alt="college logo">
                    </span>

                    <div class="text logo-text">
                        <span class="name">Vaze Security</span>
                    </div>
                </div>

                <i class='bx bx-chevron-right toggle'></i>
            </header>

            <div class="menu-bar">
                <div class="menu">

                    <li class="search-box">
                        <i class='bx bx-search icon'></i>
                        <input type="text" autocomplete="off" placeholder="Search Visits...">
                        <div class="result"></div>
                    </li>

                    <ul class="menu-links">
                        <li class="nav-link dashboard">
                            <a href="dashBoard/dashBoard.php">
                                <i class='bx bx-home-alt icon'></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-notepad icon'></i>
                                <span class="text nav-text">Visits</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-bell icon'></i>
                                <span class="text nav-text">Notifications</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-bar-chart-alt-2 icon'></i>
                                <span class="text nav-text">Analytics</span>
                            </a>
                        </li>

                    </ul>
                </div>

                <div class="bottom-content">
                    <li class="">
                        <a href="../logPage/logout.php">
                            <i class='bx bx-log-out icon'></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>

                    <li class="mode">
                        <div class="sun-moon">
                            <i class='bx bx-moon icon moon'></i>
                            <i class='bx bx-sun icon sun'></i>
                        </div>
                        <span class="mode-text text">Dark mode</span>

                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li>

                </div>
            </div>

        </nav>


        <section class="home">
            <div class="text">Hello <?php $staff_username = $staffData['s_userName'];
            echo $staff_username ?>!!</div>
            <img id="qr-scan" src="../images/qr-scan.png" />

            <div class="popup-overlay" id="popupOverlay">
                <div class="popup-staff" id="popup-staff">
                    <span class="close" id="closePopup">&times;</span>
                    <div class="popup-content">
                        <!-- <h1>QR Code Scanner</h1> -->
                        <video id="video" width="300" height="200" style="border: 1px solid black"></video>
                        <canvas id="canvas" hidden></canvas>
                    </div>
                </div>
            </div>

        </section>

        <div class="card-container">

            <?php

            $name = $staffData['s_name'];

            if ($staffData['role'] == 'teacher') {

                $sql = "SELECT * FROM visits WHERE personToMeet  = 'not specified' AND date_of_visit = '$today' ORDER BY id DESC ";
                $select_notSpecifiedVisits = mysqli_query($conn, $sql);

                if (mysqli_num_rows($select_notSpecifiedVisits) > 0) {
                    // $notSpecifiedVisits = mysqli_fetch_assoc($select);
                    // echo $notSpecifiedVisits['userName'];
        
                    while ($notSpecifiedVisits = mysqli_fetch_assoc($select_notSpecifiedVisits)) {

                        if ($notSpecifiedVisits['personToMeet'] == 'not specified') {

                            $sql = "SELECT dep_id FROM teaching_staff WHERE s_userName  = '$staff_username' ";
                            $select_dep_id = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($select_dep_id) > 0) {

                                $staff_dep_id = mysqli_fetch_assoc($select_dep_id);
                                $staff_dep_id = $staff_dep_id['dep_id'];

                                $notSpecifiedVisits_dep_id = $notSpecifiedVisits['meet_staff_dep_id'];

                                if ($notSpecifiedVisits_dep_id == $staff_dep_id) {

                                    $sql = "SELECT s_userName FROM teaching_staff WHERE dep_id  = '$notSpecifiedVisits_dep_id' ";
                                    $select_staff_usernames = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($select_staff_usernames) > 0) {

                                        while ($row = mysqli_fetch_assoc($select_staff_usernames)) {

                                            if ($staff_username == $row['s_userName']) {

                                                $sql = "SELECT * FROM visits WHERE personToMeet = 'not specified' AND meet_staff_dep_id = '$staff_dep_id' AND date_of_visit = '$today' ORDER BY id DESC ";
                                                $select_notSpecifiedVisits = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($select_notSpecifiedVisits) > 0) {
                                                    $m = 0; // it doesn't duplicate messages in loop
        
                                                    while ($row = mysqli_fetch_assoc($select_notSpecifiedVisits)) {
                                                        if ($row['status'] == 'entered') {
                                                            $color = ['cyan', 'red', 'orange', 'blue'];
                                                            $i = (int) rand(0, 3);

                                                            $data = $row["userName"];
                                                            $encryptedData = encryptData($data, $key);

                                                            echo '
                                                                <div class="box box-down ' . $color[$i] . '">
                                                                    <span class="green-badge' . $row['id'] . '"></span>
                                                                    <span class="red-badge' . $row['id'] . '"></span>
                                                                    <a href="userDetails.php?data=' . urlencode($encryptedData) . ' ">
                                                                        <h2>' . "@" . $row["userName"] . '</h2>
                                                                        <p> ' . $row["purpose"] . ' </p>
                                                                        <span>
                                                                            <img id="card-img" src="../images/default-avatar.png" alt="profile photo">
                                                                        </span>
                                                                     </a>
                                                                </div>
                                                                ';
                                                        } else {
                                                            if ($m == 0) {

                                                                if ($row['status'] == 'entered&met') {
                                                                    echo ' 
                                                                        <img src="../images/crossMark.png" alt="" >
                                                                        <span class="textMsg"> Don\'t have scheduled visits, yet </span>
                                                                    ';
                                                                } else {
                                                                    echo ' 
                                                                    <img src="../images/crossMark.png" alt="" >
                                                                    <span class="textMsg"> Visitor haven\'t entered yet </span>
                                                                    ';
                                                                }

                                                            }
                                                            $m++;
                                                        }

                                                    } // inner while loop
        
                                                }


                                                // -------------------------------------------- staff's rest all scheduled visits other than non-specified
        

                                                $sql = "SELECT * FROM visits WHERE personToMeet = '$name' AND date_of_visit = '$today' ORDER BY id DESC ";
                                                $select_notSpecifiedVisits = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($select_notSpecifiedVisits) > 0) {
                                                    while ($row = mysqli_fetch_assoc($select_notSpecifiedVisits)) {
                                                        if ($row['status'] == 'entered') {
                                                            $color = ['cyan', 'red', 'orange', 'blue'];
                                                            $i = (int) rand(0, 3);

                                                            $data = $row["userName"];
                                                            $encryptedData = encryptData($data, $key);

                                                            echo '
                                                                <div class="box box-down ' . $color[$i] . '">
                                                                    <span class="green-badge' . $row['id'] . '"></span>
                                                                    <span class="red-badge' . $row['id'] . '"></span>
                                                                    <a href="userDetails.php?data=' . urlencode($encryptedData) . ' ">
                                                                        <h2>' . "@" . $row["userName"] . '</h2>
                                                                         <p> ' . $row["purpose"] . ' </p>
                                                                        <span>
                                                                            <img id="card-img" src="../images/default-avatar.png" alt="profile photo">
                                                                         </span>
                                                                    </a>
                                                                </div>
                                                                ';
                                                        } else {
                                                            if ($m == 0) {
                                                                if ($row['status'] == 'entered&met') {
                                                                    echo ' 
                                                                        <img src="../images/crossMark.png" alt="" >
                                                                        <span class="textMsg"> Don\'t have scheduled visits, yet </span>
                                                                    ';
                                                                } else {
                                                                    echo ' 
                                                                    <img src="../images/crossMark.png" alt="" >
                                                                    <span class="textMsg"> Visitor haven\'t entered yet </span>
                                                                    ';
                                                                }
                                                            }
                                                        }
                                                        $j--;
                                                    } // inner while loop
        
                                                }


                                            }

                                        } // outer while loop
        
                                    } else {
                                        echo ' 
                                            <img src="../images/crossMark.png" alt="" >
                                            <span class="textMsg"> Don\'t have scheduled visits, yet </span>
                                        ';
                                        // break;
                                    }

                                }

                            }

                        }

                    }   // notSpecifiedVisits loop
        
                } else {

                    $sql = "SELECT * FROM visits WHERE personToMeet = '$name' AND date_of_visit = '$today' ORDER BY id DESC ";
                    $select_visits = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($select_visits) > 0) {

                        while ($row = mysqli_fetch_assoc($select_visits)) {
                            if ($row['status'] == 'entered') {
                                $color = ['cyan', 'red', 'orange', 'blue'];
                                $i = (int) rand(0, 3);

                                $data = $row["userName"];
                                $encryptedData = encryptData($data, $key);

                                echo '
                                    <div class="box box-down ' . $color[$i] . '">
                                        <span class="green-badge' . $row['id'] . '"></span>
                                        <span class="red-badge' . $row['id'] . '"></span>
                                        <a href="userDetails.php?data=' . urlencode($encryptedData) . ' ">
                                            <h2>' . "@" . $row["userName"] . '</h2>
                                            <p> ' . $row["purpose"] . ' </p>
                                            <span>
                                                <img id="card-img" src="../images/default-avatar.png" alt="profile photo">
                                            </span>
                                        </a>
                                    </div>
                                    ';

                            }else{
                                echo 'Visitor not entered yet';
                            }
                        } //while loop
        
                    } else {
                        echo ' 
                                <img src="../images/crossMark.png" alt="" >
                                <span class="textMsg"> Don\'t have scheduled visits, yet </span>
                             ';
                    }



                }

            } else if ($staffData['role'] == 'security') {

                $today = date('d/m/Y');
                $sql = "SELECT * FROM visits WHERE date_of_visit = '$today' ORDER BY id DESC ";
                $select_todays_visits = mysqli_query($conn, $sql);

                if (mysqli_num_rows($select_todays_visits) > 0) {
                    while ($row = mysqli_fetch_assoc($select_todays_visits)) {
                        $color = ['cyan', 'red', 'orange', 'blue'];
                        $i = (int) rand(0, 3);

                        $data = $row["userName"];
                        $encryptedData = encryptData($data, $key);

                        echo '
                                <div class="box box-down ' . $color[$i] . '">
                                    <span class="green-badge' . $row['id'] . '"></span>
                                    <span class="red-badge' . $row['id'] . '"></span>
                                    <a href="userDetails.php?data=' . urlencode($encryptedData) . ' ">
                                        <h2>' . "@" . $row["userName"] . '</h2>
                                        <p> ' . $row["purpose"] . ' </p>
                                        <span>
                                            <img id="card-img" src="../images/default-avatar.png" alt="profile photo">
                                        </span>
                                    </a>
                                </div>
                            ';

                    } //while loop
        
                } else {
                    echo ' 
                        <img src="../images/crossMark.png" alt="" >
                        <span class="textMsg"> Don\'t have scheduled visits, yet </span>
                    ';
                }
            }

            ?>

        </div>




        <!-- 
        <div class="card-container">
            <div class="box box-down blue">
                    <a href="#">
                    <h2>Name</h2>
                    <p> purpose </p>
                    <img src="../images/default-avatar.png" alt="profile photo">

                </a>
                </div>
            <a href="#">
                <div class="box box-down blue">
                    <h2>Name</h2>
                    <p> purpose </p>
                    <img src="../images/default-avatar.png" alt="profile photo">

                </div>
            </a>
        </div>
 -->


        <?php
        if ($staffData['role'] == 'security') {
            echo '<script type="text/javascript" src="staff_security.js"></script>';
        }
        ?>

        <script type="text/javascript" src="staff.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/jsqr@1.3.1/dist/jsQR.js"></script>


    </body>

    </html>


    <?php
}
?>