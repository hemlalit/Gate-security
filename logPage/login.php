<?php
include '../config.php';
session_start();
if (isset($_SESSION['username'])) {
    header('location:../homePage/home.php');
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pwd = mysqli_real_escape_string($conn, $_POST['password']);

    $select = mysqli_query($conn, "SELECT * FROM user WHERE u_userName = '$username' AND password = '$pwd' ") or die('query failed!');
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['username'] = $row['u_userName'];
        header('location: ../homePage/home.php');
    } else {
        $msg = 'Invalid email or password';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="log.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Vaze Security | Login portal</title>
</head>

<body>

    <div class="preloader"></div>
    <div class="box">

        <a class="info" href="#">
            <img class="logo" src="../images/college_logo.jpg" alt="college logo" />
            <span>Log into Vaze Security</span>
        </a>
        <?php
        if (isset($msg)) {
            echo '<ul class="msg"> <li>' . $msg . '</li></ul>';
        }
        ?>
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data" class="form">
                <!-- <div class="back-btn fa fa-angle-left"></div> -->
                <h2>Login here</h2>
                <div class="form-element">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-element">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="btn">
                    <div class="inner"></div>
                    <button type="submit" name="submit">Login</button>
                </div>
                <!-- <div class="signup-link">Not registered? <a href="#">Signup now</a></div> -->

            </form>
        </div>
    </div>

    <script src="log.js"></script>
</body>

</html>