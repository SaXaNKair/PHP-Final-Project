<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/12/16
 * Time: 11:49 PM
 */

session_start();
unset($_SESSION["LOGGEDIN"]);
unset($_SESSION["STUD_ID"]);
header("Location: http://localhost/PHP-Final-Project/index.html");
?>