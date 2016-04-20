<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/11/16
 * Time: 10:38 PM
 */

class Course
{
    private $id;
    private $name;
    private $description;
    private $semester;
    private $grade;
    private $units;
    private $time;

    /**
     * Course constructor.
     * @param $id
     * @param $name
     * @param $description
     * @param $semester
     * @param $grade
     * @param $units
     * @param $time
     */
    public function __construct($id, $name, $description, $semester, $grade, $units, $time)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->semester = $semester;
        $this->grade = $grade;
        $this->units = $units;
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

 

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param mixed $units
     */
    public function setUnits($units)
    {
        $this->units = $units;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param mixed $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param mixed $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    public static function getOfferedCourses($dbc){
        $query_get_courses = "SELECT * FROM `Course`";
        $get_courses = mysqli_query($dbc, $query_get_courses);
        $courses = array();
        while($row = mysqli_fetch_array($get_courses)){
            array_push($courses, new Course($row['course_id'], $row['name'], $row['description'], $row['semester'], null , $row['units'], $row['time']));
        }
        return $courses;
    }

}