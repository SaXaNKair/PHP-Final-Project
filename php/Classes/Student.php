<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/11/16
 * Time: 6:24 PM
 */
require("Course.php");

class Student
{
    private $id;
    private $f_name;
    private $l_name;
    private $email;
    private $password;
    private $major;

    /**
     * @param mixed $major
     */
    public function setMajor($major)
    {
        $this->major = $major;
    }

    /**
     * Student constructor.
     * @param $id
     * @param $f_name
     * @param $l_name
     * @param $email
     * @param $password
     */
    public function __construct($id, $f_name, $l_name, $email, $password)
    {
        $this->id;
        $this->f_name = $f_name;
        $this->l_name = $l_name;
        $this->email = $email;
        $this->password = $password;
    }
    
    public static function initStudent($dbc, $email, $password){
        $query = "SELECT * FROM College.Student";

        $respounse = mysqli_query($dbc, $query);
        $student = NULL;

        //check if user can log in with this email and password
        while($row = mysqli_fetch_array($respounse)){
            if($email == $row['email'] && $password == $row['password']){
                $student = new Student($row['student_id'], $row['f_name'], $row['l_name'], $row['email'], $row['password']);
                $student->setId($row['student_id']);
                return $student;
            }
        }
        return NULL;
    }

    public static function initStudentId($dbc, $id){
        $query = "SELECT * FROM College.Student";

        $respounse = mysqli_query($dbc, $query);
        $student = NULL;

        //check if user can log in with this email and password
        while($row = mysqli_fetch_array($respounse)){
            if($id == $row['student_id']){
                $student = new Student($row['student_id'], $row['f_name'], $row['l_name'], $row['email'], $row['password']);
                $student->setId($row['student_id']);
                return $student;
            }
        }
        return NULL;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFName()
    {
        return $this->f_name;
    }

    /**
     * @param mixed $f_name
     */
    public function setFName($f_name)
    {
        $this->f_name = $f_name;
    }

    /**
     * @return mixed
     */
    public function getLName()
    {
        return $this->l_name;
    }

    /**
     * @param mixed $l_name
     */
    public function setLName($l_name)
    {
        $this->l_name = $l_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * @return Major
     */
    public function getMajor($dbc){
        $query_get_major = "SELECT * FROM `student-major` INNER JOIN `Major` ON `student-major`.major_id = `Major`.major_id 
            WHERE `student-major`.student_id = " . $this->id;
        $get_major = mysqli_query($dbc, $query_get_major);
        $major = new Major(0, "no major");
        while ($row = mysqli_fetch_array($get_major)) {
            $major = new Major($row['major_id'], $row['major_name']);
        }
        $this->major = $major;
        return $major;
    }

    /**
     * @return array()
     */
    public function getCurrentCourses($dbc){
        $query_get_courses = "SELECT * FROM `student-course` INNER JOIN `Course` WHERE `student-course`.student_id = ".
            $this->getId(). " AND `student-course`.course_id = Course.course_id AND `student-course`.grade IS NULL 
            ORDER BY `student-course`.semester DESC";
        $get_courses = mysqli_query($dbc, $query_get_courses);
        $courses = array();
        while($row = mysqli_fetch_array($get_courses)){
            array_push($courses, new Course($row['course_id'], $row['name'], $row['description'], $row['semester'], $row['grade'] , $row['units'], $row['time']));
        }
        return $courses;
    }

    public function getPastCourses($dbc){
        $query_get_courses = "SELECT * FROM `student-course` INNER JOIN `Course` WHERE `student-course`.student_id = ".
            $this->id. " AND `student-course`.course_id = Course.course_id AND `student-course`.grade IS NOT NULL 
            ORDER BY `student-course`.semester DESC";
        $get_courses = mysqli_query($dbc, $query_get_courses);
        $courses = array();
        while($row = mysqli_fetch_array($get_courses)){
            array_push($courses, new Course($row['course_id'], $row['name'], $row['description'], $row['semester'], $row['grade'] , $row['units'], $row['time']));
        }
        return $courses;
    }

    public function getCoursesIds($dbc){
        $query_get_courses = "SELECT * FROM `student-course` INNER JOIN `Course` WHERE `student-course`.student_id = ".
            $this->id. " AND `student-course`.course_id = Course.course_id ORDER BY `student-course`.semester DESC";
        $get_courses = mysqli_query($dbc, $query_get_courses);
        $courses = array();
        while($row = mysqli_fetch_array($get_courses)){
            array_push($courses, $row['course_id']);
        }
        return $courses;
    }


}