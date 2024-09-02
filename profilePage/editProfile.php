<?php
include '../config.php';
session_start();

$username = $_SESSION['username'];

if (!isset($username)) header('location:../logPage/login.php');


$fetch = $_SESSION['fetch'];
if (isset($_SESSION['fetchParent']))
    $fetchParent = $_SESSION['fetchParent'];
if (isset($_SESSION['fetchVendor']))
    $fetchVendor = $_SESSION['fetchVendor'];
// $msg = 'Details updated successfully!';



if (isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    mysqli_query($conn, "UPDATE user SET u_name = '$update_name', email = '$update_email' WHERE u_userName = '$username'") or die("query failed!");

    $old_password = $fetch['password'];
    $update_password = mysqli_real_escape_string($conn, $_POST['update_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if (!empty($update_password) || !empty($new_password) || !empty($confirm_password)) {
        if ($update_password != $old_password) {
            $msg = 'old password did not match!';
        } elseif ($new_password != $confirm_password) {
            $msg = 'confirm password did not match!';
        } else {
            mysqli_query($conn, "UPDATE user SET password = '$confirm_password' WHERE u_userName = '$username'") or die("query failed!");
            $msg = 'Password updated successfully!';
        }
    }

    $updated_img = $_FILES['update_profile_photo']['name'];
    $updated_img_size = $_FILES['update_profile_photo']['size'];
    $updated_img_tmp_name = $_FILES['update_profile_photo']['tmp_name'];
    $updated_img_folder = '../images/profile_photos/' . $updated_img;

    if (!empty($updated_img)) {
        if ($updated_img_size > 2000000) {
            $msg = 'image is too large';
        } else {
            $img_update_query = mysqli_query($conn, "UPDATE user SET profile_photo = '$updated_img' WHERE u_userName = '$username' ");
            if ($img_update_query) {
                move_uploaded_file($updated_img_tmp_name, $updated_img_folder);
            }
            $msg = 'Image updated succesfully';
        }
    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaze Security | Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="editProfile.css">
</head>

<body>
    <?php
    $select = mysqli_query($conn, "SELECT * FROM user WHERE u_userName = '$username' ") or die("query failed!");
    if (mysqli_num_rows($select)) {
        $fetch = mysqli_fetch_assoc($select);
    }
    ?>
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

    <div class="update_profile">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="center">
                <div class="profile-pic">
                    <label class="-label" for="file">
                        <span class="fa fa-camera"></span>
                        <span>Change Image</span>
                    </label>
                    <input id="file" name="update_profile_photo" accept="image/jpg, image/jpeg, image/png"
                        type="file" />
                    <?php
                    if ($fetch['profile_photo'] == '') {
                        echo '<img class="profile-pic" id="output" src="../images/default-avatar.png" alt="">';
                    } else {
                        echo '<img class="profile-pic" id="output" src="../images/profile_photos/' . $fetch['profile_photo'] . ' " > ';
                    }
                    ?>
                </div>
            </div>
            <?php
            if (isset($msg)) {
                echo '<div class="msg">' . $msg . '</div>';
            }
            ?>
            <div class="flex">
                <div class="inputbox">
                    <span>Name:</span>
                    <input type="text" class="box" name="update_name" value="<?php echo $fetch['u_name'] ?>">

                    <span>Username:</span>
                    <input type="text" disabled class="box" name="update_username"
                        value="<?php echo $fetch['u_userName'] ?>">

                    <span>Email:</span>
                    <input type="text" class="box" name="update_email" value="<?php echo $fetch['email'] ?>">


                    <!-- <span>Password:</span>
                    <input type="password" class="box" name="update_password" value="<?php //echo $fetch['password'] ?>"> -->
                </div>
                <div class="inputbox">
                    <span>Phone:</span>
                    <input type="text" class="box" name="update_phone" value="<?php echo $fetch['phone'] ?>">
                    <?php
                    if ($fetch['userType'] == 'parent') {
                        echo '<span>Child\'s control id:</span>
                            <input type="text" disabled class="box" value=" ' . $fetchParent['childCtrl_id'] . ' "> ';


                    } else if ($fetch['userType'] == 'vendor') {
                        echo '<span>Company Name:</span>
                            <input type="text" disabled class="box" value=" ' . $fetchVendor['compName'] . ' "> ';
                    }
                    ?>
                    <!-- 
                    <span>Profile photo:</span>
                    <input type="file" class="box" name="update_profile_photo" accept="image/jpg, image/jpeg, image/png"
                        value="<?php echo $fetch['profile_photo'] ?>"> -->

                    <!-- <span>Aadhar:</span>
                    <img class="box" src="../images/aadhar/<?php echo $fetch['idProof'] ?>" alt="your aadhar"> -->
                    <!-- <input type="text"  name="update_phone" value="<?php //echo $fetch['phone'] ?>"> -->
                </div>
                <div class="inputbox">
                    <!-- <input type="hidden" name="old_password" value="<?php //echo $fetch['password'] ?>"> -->

                    <span>Old Password</span>
                    <input type="password" class="box" name="update_password" placeholder="Enter old password">

                    <span>New Password</span>
                    <input type="password" class="box" name="new_password" placeholder="Enter new password">

                    <span>Confirm Password</span>
                    <input type="password" class="box" name="confirm_password" placeholder="Enter confirm password">
                </div>
            </div>
            <input type="submit" value="Update profile" name="update_profile">
        </form>


        <!-- <label for="input-file">Update image</label>
        <input type="file" class="none" accept="image/jpg, image/jpeg, image/png" id="input-file"> -->
    </div>

    <script src="editPro.js">
    </script>
</body>

</html>