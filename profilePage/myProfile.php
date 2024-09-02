<?php
include '../config.php';
session_start();

$fetch = $_SESSION['fetch'];

if (!isset($fetch))
    header('location:../logPage/login.php');

if (isset($_SESSION['fetchParent']))
    $fetchParent = $_SESSION['fetchParent'];
if (isset($_SESSION['fetchVendor']))
    $fetchVendor = $_SESSION['fetchVendor'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaze Security | My Profile</title>

    <!----======== jQuery ======== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="editProfile.css">
</head>

<body>
    <nav>
        <div class="container">
            <img class="logo" src="../images/college_logo.jpg" />
            <a class="header-left" href="#">
                <span class="logo-name">Vaze Security</span>
            </a>
            <ul>
                <li>
                    <a href="../homePage/home.php" aria-current="true">Home</a>
                </li>
                <li>
                    <a href="../homePage/Visits.php">Visits</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <!-- <li>
                    <a href="../profilepage/profile.html">Profile</a>
                </li> -->
            </ul>
        </div>
    </nav>

    <!-- <div class="gallery">
        <img src="../images/default-avatar.png" alt="Image 1" onclick="openViewer(this)">
        <img src="image2.jpg" alt="Image 2" onclick="openViewer(this)">
        <img src="image3.jpg" alt="Image 3" onclick="openViewer(this)">
    </div> -->




    <div class="update_profile">

        <form action="" method="post" enctype="multipart/form-data">
            <?php
            if ($fetch["profile_photo"] == "") {
                echo '<img class="profile_pic" src="../images/default-avatar.png" alt="" onclick="openViewer(this)">';
            } else {
                echo '<img class="profile_pic" src="../images/profile_photos/' . $fetch["profile_photo"] . ' " > ';
            }

            if (isset($msg)) {
                echo '<div class="msg">' . $msg . '</div>';
            }

            ?>
            
            <div id="imageViewer" class="viewer">
                <span class="closebtn" onclick="closeViewer()">&times;</span>
                <img class="viewer-content" id="viewerImage">
            </div>

            <div class="flex">
                <div class="inputbox">
                    <span>Name:</span>
                    <input type="text" disabled class="box" name="update_name" value="<?php echo $fetch["u_name"] ?>">

                    <span>Username:</span>
                    <input type="text" disabled class="box" name="update_username"
                        value="<?php echo $fetch['u_userName'] ?>">

                    <span>Email:</span>
                    <input type="text" disabled class="box" name="update_email" value="<?php echo $fetch["email"] ?>">

                    <span>Phone:</span>
                    <input type="text" disabled class="box" name="update_phone" value="<?php echo $fetch["phone"] ?>">

                    <?php
                    if ($fetch['userType'] == 'parent') {
                        echo '<span>Child\'s control id:</span>
                            <input type="text" disabled class="box" name="update_ctrl_id" value=" ' . $fetchParent["childCtrl_id"] . ' "> ';


                    } else if ($fetch['userType'] == 'vendor') {
                        echo '<span>Company Name:</span>
                            <input type="text" disabled class="box" name="update_c_name" value=" ' . $fetchVendor["compName"] . ' "> ';
                    }
                    ?>

                    <!-- <span>Password:</span>
                    <input type="password" class="box" name="update_password" value="<?php //echo $fetch['password'] ?>"> -->
                </div>
                <div class="inputbox">


                    <span>Aadhar:</span>
                    <img class="box " src="../images/aadhar/<?php echo $fetch["idProof"] ?>" alt="your aadhar" onclick="openViewer(this)">
                    <!-- <div class="aadhar">
                    </div> -->
                    <!-- <input type="text"  name="update_phone" value="<?php //echo $fetch['phone'] ?>"> -->
                </div>
            </div>
            <a class="e_link" href="editProfile.php">Edit Profile</a>
        </form>


        <!-- <label for="input-file">Update image</label>
        <input type="file" class="none" accept="image/jpg, image/jpeg, image/png" id="input-file"> -->
    </div>

    <script src="editPro.js"></script>
</body>

</html>