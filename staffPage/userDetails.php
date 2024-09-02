<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="staff.css">
    <link rel="stylesheet" href="../profilePage/editProfile.css">

    <!----======== jQuery ======== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ============== QRCode ============== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Vaze Security | Staff</title>
</head>

<body>

    <div id="myProgress">
        <div id="myBar"></div>
    </div>

    <!-- <br>
    <button type="button" id="progress-btn">Click Me</button> -->


    <div class="side-container">

    </div>

    <section class="home">

        <?php

        session_start();
        date_default_timezone_set("Asia/Kolkata");
        include_once '../config.php';
        include_once '../encrypt_decrypt.php';

        $staffData = $_SESSION['staff-data'];

        if (isset($_GET['data'])) {
            $encryptedData = urldecode($_GET['data']);
            $decryptedData = decryptData($encryptedData, $key);
            $username = $decryptedData;
            // echo strlen($encryptedData);
        
            $select = mysqli_query($conn, "SELECT * FROM user WHERE u_userName = '$username' ");

            if (mysqli_num_rows($select)) {
                $fetch = mysqli_fetch_assoc($select);
            } else {
                echo "
                <div class='text'>Something went wrong, going back</div>
                <script>
                            $(document).ready(function () {
                                    $('#myProgress').css('display', 'block');

                                    var i = 0;
                                    if (i == 0) {
                                         i = 1;
                                        var elem = document.getElementById('myBar');
                                        var width = 1;
                                        var id = setInterval(frame, 20);
                                        function frame() {
                                            if (width >= 100) {
                                                clearInterval(id);
                                                i = 0;
                                            } else {
                                                width++;
                                                elem.style.width = width + '%';
                        
                                                if (width == 100) window.location.replace('staff.php');
                        
                                            }
                                        }
                                    }   
                            });
                        </script>
                ";

            }

            if (isset($fetch['userType'])) {
                if ($fetch["userType"] == "vendor") {
                    $selectVendor = mysqli_query($conn, "SELECT * FROM vendor WHERE u_userName = '$username' ") or die("query failed!");
                    if (mysqli_num_rows($selectVendor) > 0) {
                        $fetchVendor = mysqli_fetch_assoc($selectVendor);

                    }

                }
                if ($fetch["userType"] == "parent") {
                    $selectParent = mysqli_query($conn, "SELECT * FROM parent WHERE u_userName = '$username' ") or die("query failed!");
                    if (mysqli_num_rows($selectParent) > 0) {
                        $fetchParent = mysqli_fetch_assoc($selectParent);

                    }

                }
            }

            $today = date('d/m/Y', strtotime('now'));
            $select = mysqli_query($conn, "SELECT * FROM visits WHERE userName = '$username' AND date_of_visit = '$today' ");

            if (mysqli_num_rows($select)) {
                $fetch_visits = mysqli_fetch_assoc($select);

                $_SESSION['visiting_id'] = $visitingId = $fetch_visits['visiting_id']; // this session will be required in sendOTP.php
        
                $purpose = $fetch_visits['purpose'];
                $personToMeet = $fetch_visits['personToMeet'];
                $dep_id = $fetch_visits['meet_staff_dep_id'];

                if ($personToMeet == 'not specified') {
                    $select2 = mysqli_query($conn, "SELECT depName FROM department WHERE dep_id = '$dep_id' ");
                    if (mysqli_num_rows($select2)) {
                        $fetch_depName = mysqli_fetch_assoc($select2);
                        $dep_name = $fetch_depName['depName'];

                    }

                } else {

                    $select4 = mysqli_query($conn, "SELECT depName FROM department WHERE dep_id = '$dep_id' ");
                    if (mysqli_num_rows($select4)) {
                        $fetch_depName = mysqli_fetch_assoc($select4);
                        $dep_name = $fetch_depName['depName'];
                        // echo $dep_name;
        
                    }
                }

                $date_of_visit = $fetch_visits['date_of_visit'];
                $field = '';
                if ($fetch["userType"] == "parent") {
                    $field = '
                        <span>Child\'s control id:</span>
                        <input type="text" disabled class="box" name="update_ctrl_id" value=" ' . $fetchParent["childCtrl_id"] . ' "> 
                    ';

                } else if ($fetch["userType"] == "vendor") {
                    $field = '
                        <span>Company Name:</span>
                        <input type="text" disabled class="box" name="update_c_name" value=" ' . $fetchVendor["compName"] . ' ">
                    ';

                }

            }

        } else {
            header('location: staff.php');

        }

        // unset($_SESSION['visiting-user']);
        function msg($fetch_visits)
        {
            if (isset($_SESSION['fromOTP'])) {
                echo "
                    <script>
                        $(document).ready( function () {
                            $('#loader').addClass('loading');
                                var statusChange = function (status) {
                                var el = $('.loading')
                                el.removeClass()
                                el.addClass('loading');
                                el.addClass(status);
                            }
                            statusChange('failed');
                        });
                    </script>
                ";

                return $_SESSION['fromOTP'];
            } // fromOTP
        
            if (isset($_SESSION['fromOTPVerification'])) {

                if ($_SESSION['fromOTPVerification'] == '<p>Data has not stored!!</p>' || $_SESSION['fromOTPVerification'] == '<p>OTP has expired. Please request a new one.</p>' || $_SESSION['fromOTPVerification'] == '<p>Invalid OTP. Please try again.</p>' || $_SESSION['fromOTPVerification'] == '<p>something went wrong, try again!</p>') {
                    echo "
                        <script>
                            $(document).ready( function () {
                                $('#loader').addClass('loading');
                                    var statusChange = function (status) {
                                    var el = $('.loading')
                                    el.removeClass()
                                    el.addClass('loading');
                                    el.addClass(status);
                                }
                                statusChange('failed');
                                const html = \"<input class='otp-input' type='text' name='otp' placeholder='Enter OTP' /> <button type='submit' class='otp-btn' name='otp-verification'> Verify</button> <div> <button class='txt-btn' name='resend-otp'>Resend</button></div> \";
                                $('#verify-otp').html(html)
                                $('#send-otp').css('display', 'none');
                            });
                        </script>
                    ";

                    return $_SESSION['fromOTPVerification'];

                } else {
                    // $key = 'vazeCollege@mulund';
                    // $data = 'entered';
                    // $encryptedData = encryptData($data, $key);
        
                    if ($fetch_visits['status'] == 'entered&met') {

                        echo "
                        <script>
                            $(document).ready(function () {
                                $('#loader').addClass('loading');

                                    var statusChange = function (status) {
                                    var el = $('.loading')
                                    el.removeClass()
                                    el.addClass('loading');
                                    el.addClass(status);
                                }

                                statusChange('success');
                                $('#verify-otp').css('display', 'none');
                                $('#send-otp').css('display', 'none');

                                const html = \" <button class='otp-btn elongate redBtn' name='user-exit' >Exit</button> \";
                                $('.user-exit').html(html)

                            });
                        </script>
                    ";

                    } else {

                        echo "
                        <script>
                            $(document).ready(function () {
                                $('#loader').addClass('loading');

                                    var statusChange = function (status) {
                                    var el = $('.loading')
                                    el.removeClass()
                                    el.addClass('loading');
                                    el.addClass(status);
                                }

                                statusChange('success');
                                $('#verify-otp').css('display', 'none');
                                $('#send-otp').css('display', 'none');

                                const html = \" <button class='otp-btn elongate greenBtn' name='isOK' >OK</button>\";
                                $('.ok').html(html)

                                $('.ok').on('click', function () {
                                    $('#myProgress').css('display', 'block');

                                    var i = 0;
                                    if (i == 0) {
                                         i = 1;
                                        var elem = document.getElementById('myBar');
                                        var width = 1;
                                        var id = setInterval(frame, 30);
                                        function frame() {
                                            if (width >= 100) {
                                                clearInterval(id);
                                                i = 0;
                                            } else {
                                                width++;
                                                elem.style.width = width + '%';
                        
                                                if (width == 100) window.location.replace('staff.php');
                        
                                            }
                                        }
                                    }   
                                });
            
                            });
                        </script>
                    ";
                    }

                    return $_SESSION['fromOTPVerification'];

                }


            } // fromOTPVerification
        

            if (isset($_SESSION['fromEmail'])) {
                echo "
                    <script>
                        $(document).ready( function () {
                            $('#loader').addClass('loading');
                                var statusChange = function (status) {
                                    var el = $('.loading')
                                    el.removeClass()
                                    el.addClass('loading');
                                    el.addClass(status);
                                }
                                statusChange('success');
                                const html = \"<input class='otp-input' type='text' name='otp' placeholder='Enter OTP' /> <button type='submit' class='otp-btn' name='otp-verification'> Verify</button> <div> <button class='txt-btn' name='resend-otp'>Resend</button></div> \";    
                                $('#verify-otp').html(html)
                                $('#send-otp').css('display', 'none');
            
                        });
                    </script>
                ";
                return $_SESSION['fromEmail'];

            } // fromEmail
        
            if (isset($_SESSION['fromEndMeeting'])) {

                if ($_SESSION['fromEndMeeting'] == '<p>something went wrong, try again!</p>' || $_SESSION['fromEndMeeting'] == '<p>Data has not stored, try again!</p>') {
                    echo "
                    <script>
                        $(document).ready( function () {
                            $('#loader').addClass('loading');
                                var statusChange = function (status) {
                                var el = $('.loading')
                                el.removeClass()
                                el.addClass('loading');
                                el.addClass(status);
                            }
                            statusChange('failed');  
                            
                        });
                    </script>
                ";
                } else {
                    echo "
                    <script>
                        $(document).ready( function () {
                            $('#loader').addClass('loading');
                            var statusChange = function (status) {
                                var el = $('.loading')
                                el.removeClass()
                                el.addClass('loading');
                                el.addClass(status);
                            }
                            statusChange('success');
                       
                            $('#myProgress').css('display', 'block');

                            var i = 0;
                            if (i == 0) {
                                i = 1;
                                var elem = document.getElementById('myBar');
                                var width = 1;
                                var id = setInterval(frame, 40);
                                function frame() {
                                    if (width >= 100) {
                                        clearInterval(id);
                                        i = 0;
                                    } else {
                                        width++;
                                        elem.style.width = width + '%';
                        
                                        if (width == 100) window.location.replace('staff.php');
                        
                                    }
                                }
                            } 
                            

                        });
                    </script>
                ";
                }

                return $_SESSION['fromEndMeeting'];
            } // fromEndMeeting
        
        }


        ?>

        <div class="text">
            <div class="date">
                <?php echo date('d/m/Y', strtotime('now'));
                if (isset($_SESSION['network-error'])) {
                    echo $_SESSION['network-error'];
                }

                ?>

            </div>
        </div>

        <!-- <div id="responseContainer"></div> -->

        <?php

        $_SESSION['visiting-user'] = $username;
        $sql = "SELECT * FROM user WHERE u_userName = '$username'";
        $select = mysqli_query($conn, $sql);

        if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
            $_SESSION['fetch'] = $fetch; // will require in sendEmail.php 
        
            if ($staffData['role'] == 'security') {

                // echo $fetch_visits['status'];

                if ($fetch_visits['status'] == 'entered&met') {

                    echo '
                <div class="center">
                    <table class="styled-table">
                        <tbody>
                            <tr class="active-row">
                                <td>Visiting ID</td>
                                <td>' . $visitingId . '</td>
                            </tr>
                            <tr>
                                <td>Purpose</td>
                                <td>' . $purpose . '</td>
                            </tr>
                            <tr class="active-row">
                                 <td>Person to Meet</td>
                                <td>' . $personToMeet . ' (' . $dep_name . ')</td>
                            </tr>
                            <tr>
                                <td>DateOfVisit</td>
                                <td>' . $date_of_visit . '</td>
                            </tr>
                            <!-- and so on... -->
                        </tbody>
                    </table>
                </div>

                <div class="user-details">
                    <div class="update_profile">

                        <form action="sendOTP.php" method="post" enctype="multipart/form-data">
                            <div id="imageViewer" class="viewer">
                                <span class="closebtn" onclick="closeViewer()">&times;</span>
                                <img class="viewer-content" id="viewerImage">
                            </div>
                            <div class="flex">
                                <div class="inputbox">
                                    <span>Name:</span>
                                    <input type="text" disabled class="box" name="update_name" value=" ' . $fetch["u_name"] . '">

                                    <span>Username:</span>
                                    <input type="text" disabled class="box" name="update_username" value="' . $fetch["u_userName"] . ' (' . $fetch['userType'] . ')">

                                    <span>Email:</span> ' . msg($fetch_visits) . '
                                    <div id="loader" class="">
                                        <div class="status draw"></div>
                                    </div>
                                    <input type="text" disabled class="box" name="update_email" value=" ' . $fetch["email"] . '">
                                    <button class="otp-btn" id="send-otp" name="send-otp">OTP</button>
                        
                                    <div id="verify-otp">
                                        <!-- <input class="otp-input" type="text" name="otp" placeholder="Enter OTP" /> 
                                            <button type="submit" class="otp-btn" name="otp-verification"> Verify</button>
                                            <div> 
                                                 <button class="txt-btn" name="resend-otp">Resend</button>
                                            </div>;
                                        -->
                                    </div>

                                    <span>Phone:</span>
                                    <input type="text" disabled class="box" name="update_phone" value=" ' . $fetch["phone"] . '">
                                    ' . $field . '

                                </div>
                                <div class="inputbox">
                                    <span>Aadhar:</span>    
                                    <img class="box " src="../images/aadhar/' . $fetch["idProof"] . '" alt="your aadhar" onclick="openViewer(this)">
                                    <br/>
                                    <br/>
                                    <br/>
                                    <div class="user-exit">
                                    
                                        <button class="otp-btn elongate redBtn" name="user-exit" >Exit</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                ';

                } else if ($fetch_visits['status'] == 'entered') {

                    echo '
                <div class="center">
                    <table class="styled-table">
                        <tbody>
                            <tr class="active-row">
                                <td>Visiting ID</td>
                                <td>' . $visitingId . '</td>
                            </tr>
                            <tr>
                                <td>Purpose</td>
                                <td>' . $purpose . '</td>
                            </tr>
                            <tr class="active-row">
                                 <td>Person to Meet</td>
                                <td>' . $personToMeet . ' (' . $dep_name . ')</td>
                            </tr>
                            <tr>
                                <td>DateOfVisit</td>
                                <td>' . $date_of_visit . '</td>
                            </tr>
                            <!-- and so on... -->
                        </tbody>
                    </table>
                </div>

                <div class="user-details">
                    <div class="update_profile">

                        <form action="sendOTP.php" method="post" enctype="multipart/form-data">
                            <div id="imageViewer" class="viewer">
                                <span class="closebtn" onclick="closeViewer()">&times;</span>
                                <img class="viewer-content" id="viewerImage">
                            </div>
                            <div class="flex">
                                <div class="inputbox">
                                    <span>Name:</span>
                                    <input type="text" disabled class="box" name="update_name" value=" ' . $fetch["u_name"] . '">

                                    <span>Username:</span>
                                    <input type="text" disabled class="box" name="update_username" value="' . $fetch["u_userName"] . '  (' . $fetch['userType'] . ') ">

                                    <span>Email:</span> ' . msg($fetch_visits) . '
                                    <div id="loader" class="">
                                        <div class="status draw"></div>
                                    </div>
                                    <input type="text" disabled class="box" name="update_email" value=" ' . $fetch["email"] . '">
                        
                                    <div id="verify-otp">
                                        <!-- 
                                        <input class="otp-input" type="text" name="otp" placeholder="Enter OTP" /> 
                                            <button type="submit" class="otp-btn" name="otp-verification"> Verify</button>
                                            <div> 
                                                 <button class="txt-btn" name="resend-otp">Resend</button>
                                            </div>;
                                        -->
                                    </div>

                                    <span>Phone:</span>
                                    <input type="text" disabled class="box" name="update_phone" value=" ' . $fetch["phone"] . '">
                                    ' . $field . '

                                </div>
                                <div class="inputbox">
                                    <span>Aadhar:</span>    
                                    <img class="box " src="../images/aadhar/' . $fetch["idProof"] . '" alt="your aadhar" onclick="openViewer(this)">
                                    <br/>
                                    <br/>
                                    <br/>
                                    <div class="ok">
                                        <!--
                                        <button class="otp-btn elongate greenBtn" name="isOK" >OK</button>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                ';


                } else {

                    echo '
                <div class="center">
                    <table class="styled-table">
                        <tbody>
                            <tr class="active-row">
                                <td>Visiting ID</td>
                                <td>' . $visitingId . '</td>
                            </tr>
                            <tr>
                                <td>Purpose</td>
                                <td>' . $purpose . '</td>
                            </tr>
                            <tr class="active-row">
                                 <td>Person to Meet</td>
                                <td>' . $personToMeet . ' (' . $dep_name . ')</td>
                            </tr>
                            <tr>
                                <td>DateOfVisit</td>
                                <td>' . $date_of_visit . '</td>
                            </tr>
                            <!-- and so on... -->
                        </tbody>
                    </table>
                </div>

                <div class="user-details">
                    <div class="update_profile">

                        <form action="sendOTP.php" method="post" enctype="multipart/form-data">
                            <div id="imageViewer" class="viewer">
                                <span class="closebtn" onclick="closeViewer()">&times;</span>
                                <img class="viewer-content" id="viewerImage">
                            </div>
                            <div class="flex">
                                <div class="inputbox">
                                    <span>Name:</span>
                                    <input type="text" disabled class="box" name="update_name" value=" ' . $fetch["u_name"] . '">

                                    <span>Username:</span>
                                    <input type="text" disabled class="box" name="update_username" value="' . $fetch["u_userName"] . '  (' . $fetch['userType'] . ') ">

                                    <span>Email:</span> ' . msg($fetch_visits) . '
                                    <div id="loader" class="">
                                        <div class="status draw"></div>
                                    </div>
                                    <input type="text" disabled class="box" name="update_email" value=" ' . $fetch["email"] . '">
                                    <button class="otp-btn" id="send-otp" name="send-otp">OTP</button>
                        
                                    <div id="verify-otp">
                                        <!-- 
                                        <input class="otp-input" type="text" name="otp" placeholder="Enter OTP" /> 
                                            <button type="submit" class="otp-btn" name="otp-verification"> Verify</button>
                                            <div> 
                                                 <button class="txt-btn" name="resend-otp">Resend</button>
                                            </div>;
                                        -->
                                    </div>

                                    <span>Phone:</span>
                                    <input type="text" disabled class="box" name="update_phone" value=" ' . $fetch["phone"] . '">
                                    ' . $field . '

                                </div>
                                <div class="inputbox">
                                    <span>Aadhar:</span>    
                                    <img class="box " src="../images/aadhar/' . $fetch["idProof"] . '" alt="your aadhar" onclick="openViewer(this)">
                                    <br/>
                                    <br/>
                                    <br/>
                                    <div class="ok">
                                        <!--
                                        <button class="otp-btn elongate greenBtn" name="isOK" >OK</button>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                ';

                }

            } else if ($staffData['role'] == 'teacher') {

                echo 'you did it, im proud of you. Very good';

                echo '
                <div class="center">
                    <table class="styled-table">
                        <tbody>
                            <tr class="active-row">
                                <td>Visiting ID</td>
                                <td>' . $visitingId . '</td>
                            </tr>
                            <tr>
                                <td>Purpose</td>
                                <td>' . $purpose . '</td>
                            </tr>
                            <tr class="active-row">
                                 <td>Person to Meet</td>
                                <td>' . $personToMeet . ' (' . $dep_name . ')</td>
                            </tr>
                            <tr>
                                <td>DateOfVisit</td>
                                <td>' . $date_of_visit . '</td>
                            </tr>
                            <!-- and so on... -->
                        </tbody>
                    </table>
                    <a href="generatePass.php" name="pass"><img src="../images/pass.png" /></a>
                    
                </div>

                <div class="user-details">
                    <div class="update_profile">

                        <form action="endMeeting.php" method="post" enctype="multipart/form-data">
                            <div id="imageViewer" class="viewer">
                                <span class="closebtn" onclick="closeViewer()">&times;</span>
                                <img class="viewer-content" id="viewerImage">
                            </div>
                            <div class="flex">
                                <div class="inputbox">
                                    <span>Name:</span>
                                    <input type="text" disabled class="box" name="update_name" value=" ' . $fetch["u_name"] . '">

                                    <span>Username:</span>
                                    <input type="text" disabled class="box" name="update_username" value="' . $fetch["u_userName"] . '  (' . $fetch['userType'] . ') ">

                                    <span>Email:</span>
                                    <input type="text" disabled class="box" name="update_email" value=" ' . $fetch["email"] . '">

                                    <span>Phone:</span>
                                    <input type="text" disabled class="box" name="update_phone" value=" ' . $fetch["phone"] . '">
                                    ' . $field . '

                                </div>
                                <div class="inputbox">
                                    <span>Aadhar:</span>    
                                    <img class="box " src="../images/aadhar/' . $fetch["idProof"] . '" alt="your aadhar" onclick="openViewer(this)">
                                    <br/>
                                    <br/>
                                    <br/>
                                    <div class="ok">
                                        <button class="otp-btn elongate redBtn" name="end-meeting" >End meeting</button>
                                        <div id="loader" class="">
                                            <div class="status draw"></div>
                                        </div>
                                        ' . msg($fetch_visits) . '
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                ';

            }

        }

        // destroying session at the end of page
        unset($_SESSION['fromOTP']);
        unset($_SESSION['fromEmail']);
        unset($_SESSION['fromOTPVerification']);
        unset($_SESSION['fromEndMeeting']);
        unset($_SESSION['network-error']);
        ?>


    </section>

    </div>

    </a>




    <!-- <a href="#">

            <div class="card-container">
                <div class="box box-down blue">
                    <h2>Name</h2>
                    <p> purpose </p>
                    <img src="../images/default-avatar.png" alt="profile photo">

                </div>
            </div>

        </a> -->




    <script type="text/javascript" src="../profilePage/editPro.js"></script>
    <script type="text/javascript" src="staff.js"></script>
    <script type="text/javascript" src="staff_security.js"></script>

</body>

</html>