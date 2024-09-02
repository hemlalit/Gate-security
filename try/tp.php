<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            text-align: center;
        }

        .card-img {
            width: 100%;
            height: auto;
        }

        .card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #qrcode {
            margin: 10px;
        }

        #qrcode img {
            height: 200px;
        }

        .card-content h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .card-content p {
            margin: 10px 0;
            color: #666;
        }
    </style>
</head>

<body>
    <?php
    include_once '../encrypt_decrypt.php';
    include_once '../config.php';
    include('../phpqrcode/qrlib.php');
    include "../sendEmail/sendEmail.php";
    date_default_timezone_set("Asia/Kolkata");
    session_start();
    // phpInfo();
    
    $username = $data = '@hem51972';
    $encryptedData = encryptData($data, $key);

    $select_users = mysqli_query($conn, "SELECT * FROM user WHERE u_userName = '$username' ");

    if (mysqli_num_rows($select_users)) {
        $fetch_users = mysqli_fetch_assoc($select_users);
    }

    $today = date('h:i a', strtotime('+1 hour'));
    $subject = "Your pass to Extend time ";



    function generateQRCode($text)
    {
        ob_start();
        QRcode::png($text, null, QR_ECLEVEL_H, 4);
        $imageString = base64_encode(ob_get_contents());
        ob_end_clean();
        return $imageString;
    }

    $qrCodeData = generateQRCode("http://192.168.43.39/Gate-security/pass.php?data=" . urlencode($encryptedData));



    $imagePath = '../images/aadhar/' . $fetch_users["idProof"];
    $imageData = base64_encode(file_get_contents($imagePath));
    $src = 'data:image/jpeg;base64,' . $imageData;
    // echo $src;


    echo '
    <div class="card">
        <img src="data:image/png;base64,' . $imageData . '" alt="Visitor Photo" class="card-img">
        <div class="card-content">
            <h2>' . htmlspecialchars($fetch_users["u_userName"]) . '</h2>
            valid till: ' . htmlspecialchars($today) . '
            <div id="qrcode">
                <img src="data:image/png;base64,' . $qrCodeData . '" alt="QR Code">
            </div>
            <p>-- V.G.Vaze college --</p>
        </div>
    </div>
    ';

    ?>
    
</body>

</html>

