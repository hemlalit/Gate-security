<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
include "../sendEmail/sendEmail.php";
include '../encrypt_decrypt.php';

$data = $_SESSION['visiting-user'];
$encryptedData = encryptData($data, $key);

$username = $data;
$visiting_id = $_SESSION['visiting_id'];

$fp = fsockopen("www.example.com", 80);
//website, port (try 80 or 443)
if (!$fp) {
    $_SESSION['network-error'] = '
    <div>
        <img src="../images/no-wifi.png" alt="">
        <span>No Internet connection!!</span>
    </div>
    ';
    header("location: userDetails.php?data='" . urlencode($encryptedData) . " ' ");

} else {

    $go = "userDetails.php?data= " . urlencode($encryptedData);

    if ((isset($_POST['send-otp']) || isset($_POST['resend-otp']))) {

        $subject = 'OTP for V.G.Vaze College Campus Entry';

        // Generate OTP and store it in the session
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_timestamp'] = time(); // Store the creation timestamp

        $message = '<!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Verification Email</title>
                </head>
                <body>
                    <p>This is your verification number for college campus access:</p>
                    <p>Your OTP is <strong> ' . $otp . '</strong></p>
                    <p>Thank you for visiting V.G.Vaze College. Visit again next time!</p>
                    <p>Regards,<br>V.G.Vaze College</p>
                </body>
                </html>
                ';

        sendEmail($subject, $message, $go);
    }
    //  else {
//     $_SESSION['fromOTP'] = '<p>something went wrong...</p>';
//     header('location: userDetails.php?data=' . urlencode($encryptedData));
// }




    // Verify OTP during validation
    if (isset($_POST['otp-verification'])) {
        $userEnteredOTP = $_POST['otp'];
        $storedOTP = $_SESSION['otp'];
        $otpTimestamp = $_SESSION['otp_timestamp'];

        // for trials - using sample data
        // $userEnteredOTP = '123456'; 
        // $storedOTP = '123456';
        // $otpTimestamp = time(); 

        // Check if the entered OTP matches the stored OTP
        if ($userEnteredOTP == $storedOTP) {
            // Verify OTP validity (e.g., 5 minutes)
            $validityDuration = 300; // 5 minutes in seconds
            $currentTime = time();
            $otpAge = $currentTime - $otpTimestamp;

            if ($otpAge <= $validityDuration) {
                // Valid OTP! Proceed with account creation or login.

                $_SESSION['fromOTPVerification'] = "<p>User has been Verified, Give Permission.</p>";
                header('location: userDetails.php?data=' . urlencode($encryptedData));

            } else {
                $_SESSION['fromOTPVerification'] = "<p>OTP has expired. Please request a new one.</p>";
                header('location: userDetails.php?data=' . urlencode($encryptedData));

            }



        } else {
            $_SESSION['fromOTPVerification'] = "<p>Invalid OTP. Please try again.</p>";
            header('location: userDetails.php?data=' . urlencode($encryptedData));

        }

    }
    //  else {
//     $_SESSION['fromOTPVerification'] = '<p>something went wrong, try again!</p>';
//     header('location: userDetails.php?data=' . urlencode($encryptedData));
// }

    $time = date("h:i:s a");


    if (isset($_POST['isOK'])) {

        $security = $_SESSION['security'];

        $sql = "UPDATE visits SET entryTime = '$time', entry_s_userName ='$security', status = 'entered' WHERE visiting_id = '$visiting_id' AND userName = '$username' ";

        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");
        $update = mysqli_query($conn, $sql);
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");

        if ($update) {
            $_SESSION['fromOTPVerification'] = "<p>Data has been stored, successfully</p>";
            header('location: userDetails.php?data=' . urlencode($encryptedData));

        } else {
            $_SESSION['fromOTPVerification'] = "<p>Data has not stored, try again!</p>";
            header('location: userDetails.php?data=' . urlencode($encryptedData));

        }

    }

    if (isset($_POST['user-exit'])) {

        $sql = "UPDATE visits SET exitTime = '$time', status = 'entered&met&exited' WHERE visiting_id = '$visiting_id' AND userName = '$username' ";
        $update_exitTime = mysqli_query($conn, $sql);

        if ($update_exitTime) {
            $_SESSION['fromEndMeeting'] = "<p>Data stored, successfully</p>";
            header('location: userDetails.php?data=' . urlencode($encryptedData));

        } else {
            $_SESSION['fromEndMeeting'] = "<p>Data has not stored, try again!</p>";
            header('location: userDetails.php?data=' . urlencode($encryptedData));

        }

    }


}