<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./profilePage/editProfile.css">

    <title>User Info</title>
    <style>
        img {
            width: 500px;
            height: 500px;
            object-fit: contain;
            margin-top: 25px;
        }

        .inputbox {
            /* background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            text-align: center;
            padding: 50px; */
        }
    </style>
</head>

<body>

    <?php
    include_once 'encrypt_decrypt.php';
    include_once 'config.php';

    if (isset($_GET['data'])) {
        $encryptedData = urldecode($_GET['data']);
        $decryptedData = decryptData($encryptedData, $key);
        $username = $decryptedData;

        $select_users = mysqli_query($conn, "SELECT * FROM user WHERE u_userName = '$username' ");

        if (mysqli_num_rows($select_users)) {
            $fetch_users = mysqli_fetch_assoc($select_users);
        }

        // header('location: userDetails.php?data='. urlencode($encryptedData));
    
        ?>
        <div class="user-details">
            <div class="update_profile">

                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="flex">
                        <!-- <div class="aadhar">
                        <span>Aadhar:</span>

                    </div> -->
                        <img class="box " src="images/aadhar/<?php echo $fetch_users['idProof'] ?>" alt="your aadhar">
                        <div class="inputbox">
                            <span>Name:</span>
                            <input type="text" disabled class="box" name="update_name"
                                value="<?php echo $fetch_users['u_name'] ?>">

                            <span>Username:</span>
                            <input type="text" disabled class="box" name="update_username"
                                value="<?php echo $fetch_users['u_userName'] ?>">
                            <span>User:</span>
                            <input type="text" disabled class="box" name="update_username"
                                value="<?php echo $fetch_users['userType'] ?>">

                            <span>Email:</span>
                            <input type="text" disabled class="box" name="update_email"
                                value="<?php echo $fetch_users['email'] ?>">


                            <span>Phone:</span>
                            <input type="text" disabled class="box" name="update_phone"
                                value="<?php echo $fetch_users['phone'] ?>">

                        </div>

                    </div>
                </form>
            </div>
        </div>

        <?php

    } else {

        ?>
        <h1 style="text-align: center; font-size: 30px;">Somethig is wrong here...</h1>


        <?php

    }
    ?>
    <footer style="position: static; text-align: center; font-size: 15px; ">-- V.G.Vaze college --</footer>
</body>

</html>