<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/12/16
 * Time: 10:43 PM
 */
session_start();
require_once('../../mysql-connect.php');

if($_SESSION['LOGGEDIN']){
    $query_add_course = "INSERT INTO `College`.`student-course` (`student_id`, `course_id`, `semester`, `grade`) 
                            VALUES ('".$_SESSION['STUD_ID']."', '".$_GET['id']."', 's2016', NULL);";
    $add_course = mysqli_query($dbc, $query_add_course);
    header("Location: http://localhost/PHP-Final-Project/php/StudentProfile.php");
}

?>