<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/17/16
 * Time: 1:29 PM
 */
session_start();
require_once('../mysql-connect.php');
require_once('Classes/Major.php')
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>List of Classes</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/table.css" type="text/css">
</head>

<body>

<?php
if($_SESSION['LOGGEDIN']){
    echo "<h2>Majors</h2>";

    $majors = Major::getOfferedMajors($dbc);

    if($majors) {
        foreach ($majors as $major) {
            echo "<form action='Actions/majorChange.php' method='post'>";
            echo "<input name='major_id' value='" . $major->getMajorId() . "' hidden>";
            echo "<input type='submit' value='" . $major->getName() . "'>";
            echo "</form>";
        }
    }else{
        echo "Couldn't get any majors out of the database";
    }

    echo "<form action='StudentProfile.php' method='post'>";
    echo "<input type='submit' value='Cancel'>";
    echo "</form>";


} else {
    echo "You must <a href='../index.html'>Log In</a> to add classes";
}

?>

</body>
</html>
