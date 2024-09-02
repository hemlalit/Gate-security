<?php
include "../config.php";
// Enable error reporting for debugging
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Kolkata");
// if(isset($_SESSION['otp'])) echo $_SESSION['otp'];
// if(isset($_SESSION['userotp'])) echo $_SESSION['userotp'];

// Checking if the 'username' key exists in the $_POST array
if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];

    $username = $_SESSION['username'];
    $select = mysqli_query($conn, "SELECT * FROM user WHERE u_userName = '$username' ");
    if (mysqli_num_rows($select)) {
        $fetch = mysqli_fetch_assoc($select);
    }
    if ($fetch["userType"] == "vendor") {
        $selectVendor = mysqli_query($conn, "SELECT * FROM vendor WHERE u_userName = '$username' ") or die("query failed!");
        if (mysqli_num_rows($selectVendor) > 0) {
            $fetchVendor = mysqli_fetch_assoc($selectVendor);
        }
    }
    if ($fetch["userType"] == "parent") {
        $selectParent = mysqli_query($conn, "SELECT * FROM parent WHERE u_userName = '$username' ") or die("query failed!");
        if (mysqli_num_rows($selectParent) > 0) {
            $fetchParent = mysqli_fetch_assoc($selectParent);
        }
    }
    
    $today = date('d/m/Y', strtotime('now'));
    $select = mysqli_query($conn, "SELECT * FROM visits WHERE userName = '$username' AND date_of_visit = '$today' ");

    if (mysqli_num_rows($select)) {
        $fetch_visits = mysqli_fetch_assoc($select);

        $visitingId = $fetch_visits['visiting_id'];
        $purpose = $fetch_visits['purpose'];
        $personToMeet = $fetch_visits['personToMeet'];
        $select2 = mysqli_query($conn, "SELECT s_userName FROM college_staff WHERE s_name = '$personToMeet' ");
        if (mysqli_num_rows($select2)) {
            $fetch_username = mysqli_fetch_assoc($select2);
            $s_username = $fetch_username['s_userName'];
            // echo $s_username;
            $select3 = mysqli_query($conn, "SELECT dep_id FROM teaching_staff WHERE s_userName = '$s_username' ");
            if (mysqli_num_rows($select3)) {
                $fetch_depID = mysqli_fetch_assoc($select3);
                $dep_id = $fetch_depID['dep_id'];
                // echo $dep_id;
                $select4 = mysqli_query($conn, "SELECT depName FROM department WHERE dep_id = '$dep_id' ");
                if (mysqli_num_rows($select4)) {
                    $fetch_depName = mysqli_fetch_assoc($select4);
                    $dep_name = $fetch_depName['depName'];
                    // echo $dep_name;
                } else {
                    // echo "if3";
                }
            } else {
                // echo "if2";
            }

        } else {
            // echo "if1";
        }

        $date_of_visit = $fetch_visits['date_of_visit'];
        $date_of_schedule = $fetch_visits['date_of_schedule'];
        // HTML Template

        $field = '';

        if ($fetch["userType"] == "parent") {
            $field = '<span>Child\'s control id:</span>
            <input type="text" disabled class="box" name="update_ctrl_id" value=" ' . $fetchParent["childCtrl_id"] . ' "> ';

        } else if ($fetch["userType"] == "vendor") {
            $field = '<span>Company Name:</span>
            <input type="text" disabled class="box" name="update_c_name" value=" ' . $fetchVendor["compName"] . ' "> ';

        }


        echo '<div class="center">
        <table class="styled-table">
            <tbody>
                <tr>
                    <td>Visiting ID</td>
                    <td>' . $visitingId . '</td>
                </tr>
                <tr class="active-row">
                    <td>Username</td>
                    <td><label id="btn" >' . $username . '</label></td>
                </tr>
                <tr>
                    <td>Purpose</td>
                    <td>' . $purpose . '</td>
                </tr>
                <tr class="active-row">
                    <td>Person to Meet</td>
                    <td>' . $personToMeet . ' (' . $dep_name . ')</td>
                </tr>
                <tr>
                    <td>DateOfVisit</td>
                    <td>' . $date_of_visit . '</td>
                </tr>
                <!-- and so on... -->
            </tbody>
        </table>
    </div>
    <div class="user-details">
        <div class="update_profile">

        <form action="sendOTP.php" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputbox">
                    <span>Name:</span>
                    <input type="text" disabled class="box" name="update_name" value=" ' . $fetch["u_name"] . '">

                    <span>Username:</span>
                    <input type="text" disabled class="box" name="update_username"
                        value="' . $fetch["u_userName"] . ' ">

                    <span>Email:</span> ' . msg($fetch) . '
                    <input type="text" disabled class="box" name="update_email" value=" ' . $fetch["email"] . '">
                    <button class="otp-btn position" id="send-otp-btn" name="send-otp">OTP</button>
                    <div id="loader" class=""></div> 

                    <div id="verify-otp"></div>

                    <span>Phone:</span>
                    <input type="text" disabled class="box" name="update_phone" value=" ' . $fetch["phone"] . '">
                    ' . $field . '

                </div>
                <div class="inputbox">
                    <span>Aadhar:</span>    
                    <img class="box " src="../images/aadhar/' . $fetch["idProof"] . '" alt="your aadhar">
                </div>
            </div>
        </form>
    </div>
    </div>
    ';

        unset($_SESSION['fromOTP']);
        unset($_SESSION['fromEmail']);
        
    } else {
        echo "Todays's Visit was not scheduled for user " . $username . "";
    }
} else {
    echo "Something went wrong...";
}


// Sample values for other variables
// $visitingId = "12345";
// $purpose = "Meeting";
// $personToMeet = "John Doe";
// $dep = "HR Department";
// $date_of_schedule = "2024-07-15";
// $date_of_visit = "2024-07-16";





