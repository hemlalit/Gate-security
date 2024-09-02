<?php
session_start();
include '../config.php';

$username = $_SESSION['username'];
// if (isset($_SESSION['c_name'])) $company_name = $_SESSION['c_name'];

if (!isset($username)) {
  header('location:../logPage/login.php');
} else {
  // if user is logged in then only show this page, instead redirect to login page

  $select = mysqli_query($conn, "SELECT * FROM user WHERE u_userName = '$username' ") or die("query failed!");
  if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
    $_SESSION['fetch'] = $fetch;
  }

  if ($fetch['userType'] == 'parent') {
    $selectParent = mysqli_query($conn, "SELECT * FROM parent WHERE u_userName = '$username' ") or die("query failed!");
    if (mysqli_num_rows($selectParent) > 0) {
      $fetchParent = mysqli_fetch_assoc($selectParent);
    }
    $_SESSION['fetchParent'] = $fetchParent;
  }
  if ($fetch['userType'] == 'vendor') {
    $selectVendor = mysqli_query($conn, "SELECT * FROM vendor WHERE u_userName = '$username' ") or die("query failed!");
    if (mysqli_num_rows($selectVendor) > 0) {
      $fetchVendor = mysqli_fetch_assoc($selectVendor);
    }
    $_SESSION['fetchVendor'] = $fetchVendor;
  }

  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="../profilepage/home_myprofile.css" rel="stylesheet"> -->
    <link href="home.css" rel="stylesheet">

    <!----======== font-awesome ======== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!----======== jQuery ======== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!----======== QR code ======== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <title>Vaze Security | Home</title>
  </head>

  <div class="preloader"></div>

  <body>
    <!-- This is the header  -->
    <nav>
      <div class="h_container">
        <img class="logo" src="../images/college_logo.jpg" />
        <a class="header-left" href="#">
          <span class="logo-name">Vaze Security</span>
        </a>
        <ul>
          <li>
            <a href="home.php">Home</a>
          </li>
          <li>
            <a href="visits.php">Visits</a>
          </li>
          <li>
            <a href="#">About</a>
          </li>
        </ul>
        <div class="search">
          <span class="text">Search visits</span>
          <input type="text" placeholder="Enter name to search...">
          <button><i class="fas fa-search"></i></button>
        </div>
        <div class="action">
          <div class="h_profile">
            <?php
            if ($fetch['profile_photo'] == '') {
              echo '<img class="profile-pic" src="../images/default-avatar.png" >';
            } else {
              echo '<img class="profile-pic" src="../images/profile_photos/' . $fetch['profile_photo'] . ' " >';
            }
            ?>
          </div>
          <div class="menu hide">
            <h3><?php echo $fetch['u_name']; ?></h3>
            <p class="badge"><?php echo $fetch['userType']; ?></< /p>
            <div class="bio"><?php echo $fetch['u_userName']; ?></div>
            <ul>
              <li><img src="../images/icons/profile.png" alt=""><a href="../profilePage/myProfile.php">My Profile</a>
              </li>
              <li><img src="../images/icons/edit.png" alt=""><a href="../profilePage/editProfile.php">Edit Profile</a>
              </li>
              <li><img src="../images/icons/inbox.png" alt=""><a target="_blank" href="https://gmail.com">Inbox</a></li>
              <li><img src="../images/icons/setting.png" alt=""><a href="#">Settings</a></li>
              <li><img src="../images/icons/help.png" alt=""><a href="#">Help</a></li>
              <li><img src="../images/icons/logout.png" alt=""><a href="../logPage/logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="poster">
      <img id="" src="../images/schedule_your_visit.png" alt="Schedule your visit">

      <div class="visits">
        <form name="visitForm" class="form" action="scheduleVisit.php" method="post" enctype="multipart/form-data">

          <select name="dep" id="dep" required>
            <option value="">-- select department* --</option>
          </select>
          <select name="person-to-meet" id="ins">
            <option value="">-- select person to meet --</option>
          </select>
          <select name="date" id="date" required>
            <option value="">-- when?* --</option>
            <option value="today">today</option>
            <!-- if user schedule visit after college's operating time system should restrict-->
            <option value="tomorrow">tomorrow</option>
          </select>
          <!-- <input type="date" name="date" value="01/01/2024" id="date" required> -->
          <input type="text" style="padding-left: 2%" name="purpose" placeholder="Your Purpose*" required>

          <input type="submit" class="btn" name="schedule-visit" value="Schedule Meeting">
        </form>

        <div id="loader" class=""></div>

        <?php
        // unsetting session variables, so they disappear on refresh
      
        if (isset($_SESSION['fromEmail'])) {
          echo $_SESSION['fromEmail'];
          unset($_SESSION['fromEmail']);

        } else if (isset($_SESSION['already_have_visit'])) {
          echo $_SESSION['already_have_visit'];
          unset($_SESSION['already_have_visit']);

        }

        ?>

      </div>

      <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/EuP3xycjiM4?si=M1PxqibPGBnYnGN_"
        title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->
    </div>
    </div>

    


    <script src="home.js"></script>
  </body>

  </html>

  <?php
}
?>