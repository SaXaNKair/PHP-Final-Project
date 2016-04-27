<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/11/16
 * Time: 6:22 PM
 */
session_start();
require_once('../mysql-connect.php');
require_once('Classes/Student.php');
require_once('Classes/Course.php');
require_once('Classes/Major.php')
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>List of Class</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

<body>

<?php
    if($_SESSION['LOGGEDIN']){
        //Initiating the logged in student, his major and classes
        $student = Student::initStudentId($dbc, $_POST['id']);
        $major = $student->getMajor($dbc);
        $reqClasses = $major->getReqClassesIDs($dbc);
        $Courses = Course::getOfferedCourses($dbc);
        $takenCourses = $student->getCoursesIds($dbc);

        //table of courses that are required for the major 
        echo "<h2>Required for ".$major->getName()."</h2>";
        echo "<div class=\"CSSTableGenerator\">";
        echo "<table>";
        echo "<thead><td>Course name</td><td>Course Description</td><td>Time</td><td>Units</td><td>Add</td>";

        foreach ($Courses as $course) {
            if(!in_array($course->getId(), $takenCourses) && in_array($course->getId(), $reqClasses)){
                echo "<tr>";
                echo "<td>".$course->getName()."</td><td>".$course->getDescription()."</td><td>".$course->getTime().
                    "</td><td>".$course->getUnits()."</td><td><a href='Actions/addingClass.php?id=".$course->getId()."' >ADD</a></td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        echo "</div>";

        //table of other offered courses
        echo "<h2>Other classes</h2>";

        echo "<div class=\"CSSTableGenerator\">";
        echo "<table>";
        echo "<thead><td>Course name</td><td>Course Description</td><td>Time</td><td>Units</td><td>Add</td>";

        foreach ($Courses as $course) {
            if(!in_array($course->getId(), $takenCourses) && !in_array($course->getId(), $reqClasses)){
                echo "<tr>";
                echo "<td>".$course->getName()."</td><td>".$course->getDescription()."</td><td>".$course->getTime().
                    "</td><td>".$course->getUnits()."</td><td><a href='Actions/addingClass.php?id=".$course->getId()."' >ADD</a></td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        echo "</div>";
        
        echo "<form action='StudentProfile.php' method='post'>";
        echo "<input type='submit' value='Cancel'>";
        echo "</form>";


    } else {
        echo "You must <a href='../index.html'>Log In</a> to add classes";
    }

?>

</body>
</html>
