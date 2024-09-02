<?php

session_start();
date_default_timezone_set("Asia/Kolkata");
include_once '../config.php';
include '../encrypt_decrypt.php';

$visiting_users_username = $_SESSION['visiting-user'];
$visiting_id = $_SESSION['visiting_id'];

$data = $visiting_users_username;
$encryptedData = encryptData($data, $key);



if (isset($_POST['end-meeting'])) {

    $time = date("h:i:s a");

    $sql = "UPDATE visits SET meetOverTime = '$time', status = 'entered&met' WHERE visiting_id = '$visiting_id' AND userName = '$visiting_users_username' ";
    $update_meeting_time = mysqli_query($conn, $sql);

    if ($update_meeting_time) {
        $_SESSION['fromEndMeeting'] = "<p>Data stored, succesfully</p>";

    } else {
        $_SESSION['fromEndMeeting'] = "<p>Data has not stored, try again!</p>";

    }

    header('location: userDetails.php?data=' . urlencode($encryptedData));

} else {
    $_SESSION['fromEndMeeting'] = '<p>something went wrong, try again!</p>';
    header('location: userDetails.php?data=' . urlencode($encryptedData));

}


