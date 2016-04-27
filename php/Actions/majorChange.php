<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/17/16
 * Time: 1:57 PM
 */
session_start();
require_once('../../mysql-connect.php');

if($_SESSION['LOGGEDIN']){
    $query_check = "SELECT * FROM `College`.`student-major` WHERE `student-major`.`student_id` =".$_SESSION['STUD_ID'];
    if($query_check) {
        $query_new_major = "UPDATE  `College`.`student-major` SET  `major_id` =  '" . $_POST['major_id'] . "' 
    WHERE  `student-major`.`student_id` =" . $_SESSION['STUD_ID'] . ";";
        $change_major = mysqli_query($dbc, $query_new_major);
    } else {
        $query_change_major = "INSERT INTO `College`.`student-major` (`student_id`, `major_id`) 
        VALUES ('".$_SESSION['STUD_ID']."', '" . $_POST['major_id'] . "');";
        $change_major = mysqli_query($dbc, $query_change_major);
    }

    header("Location: http://localhost/PHP-Final-Project/php/StudentProfile.php");
}

?>