<?php

session_start();
include "../../config.php";
date_default_timezone_set("Asia/Kolkata");

$fp = fsockopen("www.example.com", 80);
//website, port (try 80 or 443)
if (!$fp) {
    echo '<script>alert("No Internet connection!!\nFirst Connect")</script>';
}

if (!isset($_SESSION['staff-data'])) {
    header('location:../index.php');
} else {
    
    $fetch = $_SESSION['staff-data'];
    
    if ($fetch['role'] == 'teacher') {
        $username = $fetch['s_name'];
        $today = date('d/m/Y');
        $tomorrow = date("d/m/Y", strtotime('tomorrow'));
        $select = mysqli_query($conn, "SELECT * FROM visits WHERE personToMeet = '$username' AND (date_of_visit = '$today' OR date_of_visit = '$tomorrow') ");
        
        if (mysqli_num_rows($select)) {
            $fetch_visits = mysqli_fetch_assoc($select);
            echo "
            <div class='cont'>
            <p>There's a scheduled visit by <strong>" . $fetch_visits['userName'] . "</strong> </p>
            </div>
        ";
        } else {
            echo "
            <div class='cont'>
            <p>No scheduled visits today!</p>
            </div>
            ";
        }
    }
    
}

