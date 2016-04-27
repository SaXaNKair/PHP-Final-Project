<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/6/16
 * Time: 10:39 PM
 */

if($_POST['f_name'] && $_POST['l_name'] && $_POST['email'] && $_POST['password']){

    //establishing the connection to MySQL database
    require_once('../mysql-connect.php');
    require_once('Classes/Student.php');

    //SQL query to select all the students (potential sequrity issue)
    $query = "SELECT email FROM College.Student";

    //storing the info about the students in an array
    $respounse = mysqli_query($dbc, $query);

    //checking if such email is already taken
    $email_taken = false;
    while($row = mysqli_fetch_array($respounse)){
        if($row['email'] == $_POST['email'])
            $email_taken = true;
    }

    //if email not taken, insert a new student into the database
    if(!$email_taken){
        $query_insert = "INSERT INTO  `College`.`Student` (
        `student_id` , `f_name` , `l_name` , `email` , `password`)
        VALUES (NULL ,  '".$_POST['f_name']."',  '".$_POST['l_name']."',  '".$_POST['email']."',  '".$_POST['password']."')";

        mysqli_query($dbc, $query_insert);
        session_start();
        $student = Student::initStudent($dbc, $_POST['email'], $_POST['password']);
        $_SESSION['LOGGEDIN'] = true;
        $_SESSION['STUD_ID'] = $student->getId();
        header("Location: http://localhost/PHP-Final-Project/php/StudentProfile.php");
    }else{
        echo "This email is already taken. <a href='../index.html'>Try again...</a>";
    }
}else{
    echo "You must fill out every field of the form. <a href='../index.html'>Back...</a>";
}


?>