<?php

session_start();
date_default_timezone_set("Asia/Kolkata");
include "../config.php";
include "../sendEmail/sendEmail.php";

$go = "document.location.href = 'home.php' ";
$fetch = $_SESSION['fetch'];

if (isset($_POST['schedule-visit'])) {

    $username = $_SESSION['username'];
    $today = date('d/m/Y', strtotime('now'));
    $tomorrow = date('d/m/Y', strtotime('tomorrow'));
    $select = mysqli_query($conn, "SELECT * FROM visits WHERE userName = '$username' AND (date_of_visit = '$today' OR date_of_visit = '$tomorrow') ");

    if (mysqli_num_rows($select)) {
        $fetch = mysqli_fetch_assoc($select);
        $_SESSION['already_have_visit'] = '
        <div style="text-align : center" >
        <h3>You already have scheduled visit with <i>' . $fetch['personToMeet'] . '</i>!!</h3>
        <strong>On ' . $fetch['date_of_visit'] . '</strong>
        <br>
        check your <a target="_blank" href="https://mail.google.com">email</a> if you don\'t know
        </div>
        ';
        echo '
        <script>
            document.location.href = "home.php";
        </script>
        ';

    } else {

        $dep = mysqli_real_escape_string($conn, $_POST["dep"]);
        if($_POST["person-to-meet"]){
            $person_to_meet = mysqli_real_escape_string($conn, $_POST["person-to-meet"]);

        }else{
            $person_to_meet = 'not specified';

        }
        $fpurpose = mysqli_real_escape_string($conn, $_POST["purpose"]);
        $when = $_POST['date'];
        $date_of_schedule = date('d/m/Y h:i:sa', strtotime('now'));

        switch ($when) {
            case 'today':
                $date_of_visit = date('d/m/Y', strtotime('today'));
                break;
            case 'tomorrow':
                $date_of_visit = date('d/m/Y', strtotime('tomorrow'));
                break;
            default:
                $date_of_visit = date('d/m/Y', strtotime('today'));
        }

        $visiting_id = date('Ymd') . rand();
        $select = mysqli_query($conn, "SELECT dep_id FROM department WHERE depName = '$dep' ") or die('query failed');
        if (mysqli_num_rows($select)) {
            $fetch_dep = mysqli_fetch_assoc($select);
            $dep_id = $fetch_dep['dep_id'];
        }

        $select = mysqli_query($conn, "SELECT id FROM visits ORDER BY timeStamp DESC LIMIT 1 ");
        if ( mysqli_num_rows($select)) {
            $row = mysqli_fetch_assoc($select);
            $id = $row['id'];
            $id++;
        }else{
            $id = 1;
        }


        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
        $insert = mysqli_query($conn, " INSERT INTO visits (id, visiting_id, purpose, personToMeet, date_of_visit, date_of_schedule, userName, meet_staff_dep_id) values($id, '$visiting_id', '$fpurpose', '$person_to_meet', '$date_of_visit', '$date_of_schedule', '$username', '$dep_id') ") or die('query failed');
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");


        if ($insert) {
            $select = mysqli_query($conn, "SELECT * FROM visits WHERE visiting_id = '$visiting_id' ");

            if (mysqli_num_rows($select)) {
                $fetch_visits = mysqli_fetch_assoc($select);

                $visitingId = $fetch_visits['visiting_id'];
                $purpose = $fetch_visits['purpose'];
                $personToMeet = $fetch_visits['personToMeet'];
                $date_of_visit = $fetch_visits['date_of_visit'];
                $date_of_schedule = $fetch_visits['date_of_schedule'];

                $subject = 'Your visit has been scheduled successfully at Vaze college';
                $message = '
        <p>Here are your Visiting details</p>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
        *{
            font-family: "Poppins", sans-serif;
        }

        .styled-table {
            border-collapse: collapse;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead th {
            background-color: #064d99;
            color: #ffffff;
            text-align: center;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #064d99;
        }

        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #064d99;
        }
    </style>
</head>

<body>
    <div class="center">
        <table class="styled-table">
             <thead>
                <th colspan="2">Details</th>
            </thead>
        </table>
        <table class="styled-table">
            <tbody>
                <tr>
                    <td>Visiting ID</td>
                    <td>' . $visitingId . '</td>
                </tr>
                <tr class="active-row">
                    <td>UserName</td>
                    <td>' . $username . '</td>
                </tr>
                <tr>
                    <td>Purpose</td>
                    <td>' . $purpose . '</td>
                </tr>
                <tr class="active-row">
                    <td>PersonToMeet</td>
                    <td>' . $personToMeet . ' (' . $dep . ')</td>
                </tr>
                <tr>
                    <td>DateOfVisit</td>
                    <td> ' . $date_of_visit . '</td>
                </tr>
                <!-- and so on... -->
            </tbody>
        </table>
    </div>
    <br>
    Don\'t forget to bring physical copy of your identification.<br>
    It could be Aadhar card, Driving license, PAN card, VoterId, etc.
    <h4>You will not get permitted if you don\'t have physical proof</h4>
    <p>Thank you for visiting Vaze Security.</p>
    <p>Regards,<br>V.G.Vaze College</p>

</body>
</html>
';
                $go = "home.php";
                sendEmail($subject, $message, $go);

            } else {
                echo
                    '
        <script>
            alert("Something went wrong, please try Again.");
            ' . $go . '
        </script>
        ';
            }

        } else {
            echo
                '
    <script>
        alert("Your data has not been stored!! Please try Again.");
        ' . $go . '
    </script>
    ';
        }
    }

} else {
    echo
        '
    <script>
        alert("Something went wrong, please try Again.");
        ' . $go . '
    </script>
    ';
}