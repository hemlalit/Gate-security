<?php
session_start();
include '../config.php';

$username = $_SESSION['username'];

if (!isset($username)) {
    header('location:../logPage/login.php');
}

$select = mysqli_query($conn, "SELECT * FROM visits WHERE userName = '$username' ORDER BY id DESC ");
// echo mysqli_num_rows($select);


// $id = ['headingOne', 'headingTwo', 'headingThree', 'headingFour'];
// $collapse = ['collapseOne', 'collapseTwo', 'collapseThree', 'collapseFour'];
// $num = 1;

echo '
        <label id="head">
        <span>Date</span>
        </label>
    ';

while ($row = mysqli_fetch_assoc($select)) {
    $date = $row['date_of_visit'];
    $date1 = $row['date_of_schedule'];
    // this has been done bcz strtotime() requires date in format of [d-m-y]
    $date = strtr($date, '/', '-');
    $date1 = strtr($date1, '/', '-');

    $date_of_visit = date("d/m/Y", strtotime($date));
    $date_of_schedule = date("d/m/Y", strtotime($date1));

    echo '
    <button class="accordion"><span id="date">: ' . $date_of_schedule . ' </span></button>
    <div class="panel">
        <table class="styled-table">
            <tbody>
                <tr class="active-row"><td>' . 'Visiting ID</td><td>' . $row['visiting_id'] . '</td></tr>
                <tr><td>' . 'Purpose</td><td>' . $row['purpose'] . '</td></tr>
                <tr class="active-row"><td>' . 'PersonToMeet</td><td>' . $row['personToMeet'] . '</td></tr>
            </tbody>
        </table>
    </div>
    ';

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <title>Vaze Security | Visits</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: "Poppins", sans-serif;
        }

        .center {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .styled-table {
            border-collapse: collapse;
            margin: 20px;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 350px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead th,
        #head {
            background-color: #064d99;
            color: #ffffff;
            text-align: center;
        }

        .styled-table th,
        .styled-table td,
        #head {
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

        #date {
            margin-left: 2%;
        }

        #head {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        #head span {
            margin: 0 7% 0 2%;
            font-size: 20px;
        }

        .accordion {
            background-color: #eee;
            color: #064d99;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active,
        .accordion:hover {
            background-color: #ccc;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .accordion:after {
            content: '\2335';
            color: #777;
            font-weight: bold;
            float: right;
            margin-left: 5px;
            transition: .3s ease-in;
            transform: rotate(180deg);
        }

        .active:after {
            /* content: "\25BC"; */
            transform: rotate(360deg);
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
            border-bottom: 1px solid #064d99;
        }

        @media(max-width : 500px) {
            .styled-table {}
        }
    </style>
</head>

<body>

</body>

<script type="text/javascript">
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
</script>

</html>