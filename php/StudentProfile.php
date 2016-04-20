<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/6/16
 * Time: 10:39 PM
 */

require_once('../mysql-connect.php');
require_once ('Student.php');
require_once ('Course.php');
require_once ('Major.php');
session_start();
?>
    <!DOCTYPE html>
    <html >
    <head>
        <meta charset="UTF-8">
        <title>Student Profile</title>
        <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/table.css" type="text/css">
    </head>

    <body>
    <a href="logout.php" id="logout">LOG OUT</a><br>
<?php
    //Initiation of the student object when first logged in
    $student = Student::initStudent($dbc, $_POST['email'], $_POST['password']);
    //Reinitialize student when coming back to this page during te same session
    if(!$student && $_SESSION['LOGGEDIN']){
        $student = Student::initStudentId($dbc, $_SESSION['STUD_ID']);
    }

    if($student) {
        $_SESSION['LOGGEDIN'] = true;
        $_SESSION['STUD_ID'] = $student->getId();
        //Once you're logged in ---->
        echo "You are logged in as " . $student->getFName() . " " . $student->getLName() . "<br/>";

        //Creating a Major object of our student and getting its name
        echo "<h2>Major:</h2>";
        $major = $student->getMajor($dbc);
        if(!$major->getMajorId()){
            echo "<p>You didn't choose major yet</p>";
        }else{
            echo "<h2>".$major->getName()."</h2>";
        }
        //Button to change major
        echo "<form action='majorList.php' method='post'>";
        echo "<input name='id' value='".$student->getId()."' hidden >";
        echo "<input type='submit' value='Change major'>";
        echo "</form>";

        //retrieving an array of current courses from the student
        $currentCourses = $student->getCurrentCourses($dbc);
        if(!$currentCourses){
            echo "<h2>You are not enrolled in any courses</h2>";

        }else {
            //show current courses and drop
            echo "<h2>Your current courses</h2>";
            echo "<div class=\"CSSTableGenerator\">";
            echo "<table>";
            echo "<thead><td>Course name</td><td>Course Description</td><td>Time</td><td>Units</td><td>Drop</td>";

            foreach ($currentCourses as $course) {
                echo "<tr>";
                echo "<td>" . $course->getName() . "</td>" . "<td>" . $course->getDescription() . "</td>" . "<td>" . $course->getTime() . "</td>" .
                    "</td>" . "<td>" . $course->getUnits() . "</td><td><a href='deletingCourse.php?id=" . $course->getId() . "' >DROP</a></td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
        }
            //Add class button
            echo "<form action='courseList.php' method='post'>";
            echo "<input name='id' value='".$student->getId()."' hidden >";
            echo "<input type='submit' value='Add Course'>";
            echo "</form>";
            

            $pastCourses = $student->getPastCourses($dbc);

            //Displaying table with student's past courses
            if(!$pastCourses){
                echo "<h2>You do not have any past courses</h2>";
            }else {
                //show past courses and drop
                echo "<h2>Your past courses</h2>";
                echo "<div class=\"CSSTableGenerator\">";
                echo "<table>";
                echo "<thead><td>Course name</td><td>Course Description</td><td>Semester</td><td>Units</td><td>Grade</td>";

                foreach ($pastCourses as $course) {
                    echo "<tr>";
                    echo "<td>" . $course->getName() . "</td>" . "<td>" . $course->getDescription() . "</td>" . "<td>" . $course -> getSemester() . "</td>" .
                        "</td>" . "<td>" . $course->getUnits() . "</td><td>".$course->getGrade()."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            }

        //Computing GPA
        $allunits = 0.0;
        $allcredits = 0.0;
        foreach ($pastCourses as $course){
            switch ($course->getGrade()){
                case 'A': $credits = 4;
                    break;
                case 'B': $credits = 3;
                    break;
                case 'C': $credits = 1;
                    break;
                default: $credits = 0;
            }
            $allunits += $course->getUnits();
            $allcredits += $credits * $course->getUnits();
        }
        $gpa = (double) $allcredits / $allunits;
        $gpa = ((int)($gpa * 100))/100.0;
        echo "<h2>GPA: $gpa</h2>";


    } else {
        //if not logged in
        echo "You must enter a valid email and password to login. ";
        echo "<a href='../index.html' >Go Back...</a>";
}
?>
</body>
</html>
