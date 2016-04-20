<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/12/16
 * Time: 11:14 PM
 */
session_start();
require_once('../mysql-connect.php');
require_once ('Student.php');
require_once ('Course.php');

if($_SESSION['LOGGEDIN']){
    $query_delete_course = "DELETE FROM `College`.`student-course` WHERE 
                      `student-course`.`student_id` = ".$_SESSION['STUD_ID']." AND `student-course`.`course_id` = ".$_GET['id'];
    $delete_course = mysqli_query($dbc, $query_delete_course);
    header("Location: http://localhost/PHP-Final-Project/php/StudentProfile.php");
}


?>