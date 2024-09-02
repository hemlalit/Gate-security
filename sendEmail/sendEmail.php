<?php

// session_start();
date_default_timezone_set("Asia/Kolkata");
include '../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
function sendEmail($sub, $msg, $goToLocation, $imagePath = '', $qrCodePath = '')
{
    $time_now = date('h:i:sa', strtotime('now'));
    global $conn;
    if (isset($_SESSION['fetch'])) {
        $fetch = $_SESSION['fetch'];
    } else if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $select = mysqli_query($conn, "SELECT * FROM user WHERE u_userName = '$username' ");
        if (mysqli_num_rows($select)) {
            $fetch = mysqli_fetch_assoc($select);
            // echo the fetch['email'];
        }
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'onlyprogramming123@gmail.com';
        $mail->Password = 'ktfd wdgs hdzd dhdu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465';

        //Recipients
        $mail->setFrom('onlyprogramming123@gmail.com');
        $mail->addAddress($fetch['email']);

        //Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->WordWrap = 1000;

        // Embed images
        if ($imagePath != '' && $qrCodePath != '') {
            $mail->AddEmbeddedImage($imagePath, 'visitor_photo');
            $mail->AddEmbeddedImage($qrCodePath, 'qrcode');

            // Clean up the temporary files
            unlink($imagePath);
            unlink($qrCodePath);
        }

        $mail->Subject = $sub;
        $mail->Body = $msg;

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $_SESSION['fromEmail'] = '<em> ' . $time_now . ' </em> <p>email sent successfully to <b>' . $fetch['email'] . '</b></p>';
            echo "
            <script>
                document.location.href = '" . $goToLocation . "'
            </script>
            ";
        }


    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}