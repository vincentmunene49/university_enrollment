<?php
require_once 'config.php';
require_once 'db.php';
$db = connect(DB_SERVER, USER, PASSWORD, DB_NAME);

$admNumber = $_POST["adm_number"];
$password = $_POST["password"];

ob_start();
session_start();

$check = 0;

$my_file = "StudentData.txt";
if ($admNumber === "admin") {

    $adminData = selectForAdmin($db);

    foreach ($adminData as $val) {

        if ($val['pass'] === $password) {
            $_SESSION['firstName'] = $val['fname'];
            $_SESSION['lastName'] = $val['lname'];
            $_SESSION['profilePhoto'] = $val['profile_picture'];
            $_SESSION['admissionNum'] = $val['adm_number'];
            $_SESSION['password'] = $val['pass'];

            //  selectRecords($db);
            echo "
                    <script>
                    window.location.href='../html/adminProfile.php';
                    </script>";
        } else {
            echo "
                        <script>
                        alert('Check password and try again');
                        window.location.href='../html/SIGNIN.html';
                        </script>";
            break;
        }
    }
} else {


    //  $obtainedData = json_decode(file_get_contents($my_file), true);
    $data = selectRecords($db);

    // $keys = array_keys($obtainedData);

    //select and display each student
    foreach ($data as  $val) {
        // if ($admNumber == "admin") {
        // }
        if ($val['adm_number'] === $admNumber) {
            $check++;
            if ($val['pass'] === $password) {
                $_SESSION['firstName'] = $val['fname'];
                $_SESSION['lastName'] = $val['lname'];
                $_SESSION['profilePhoto'] = $val['profile_picture'];
                $_SESSION['admissionNum'] = $val['adm_number'];
                $_SESSION['password'] = $val['pass'];
                $_SESSION['completion'] = $val['completion'];
                $_SESSION['userid'] = $val['ID'];
                // echo  $_SESSION['userid'];

                echo "
                    <script>
                    window.location.href='../html/userprofile.php';
                    </script>";


                break;
            } else {
                echo "
                        <script>
                        alert('Check password and try again');
                        window.location.href='../html/SIGNIN.html';
                        </script>";
                break;
            }
            //check if admin exitsts and display all students details
        }
    }

    if ($check === 0) {
        echo "User Has not Signed up";
    }
}
