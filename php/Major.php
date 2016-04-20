<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/16/16
 * Time: 12:36 AM
 */
class Major
{
    private $courseList = array();
    private $name;
    private $major_id;

    /**
     * major constructor.
     * @param $name
     */
    public function __construct($major_id, $name)
    {
        $this->name = $name;
        $this->major_id = $major_id;
    }

    /**
     * @return array
     */
    public function getCourseList()
    {
        return $this->courseList;
    }

    /**
     * @param array $courseList
     */
    public function setCourseList($courseList)
    {
        $this->courseList = $courseList;
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

    public function getReqClassesIDs($dbc){
        //method returns an array of IDs of classes that required for this major
        $query_get_reqClasses = "SELECT * FROM `major-course` INNER JOIN Course ON `major-course`.course_id = Course.course_id 
                            WHERE `major-course`.major_id = ". $this->major_id ;
        $get_reqClasses = mysqli_query($dbc, $query_get_reqClasses);
        $reqClasses = array();
        while($row = mysqli_fetch_array($get_reqClasses)) {
            array_push($reqClasses, $row['course_id']);
        }
        return $reqClasses;
        
    }

    public static function getOfferedMajors($dbc){
        
        $query_get_major = "SELECT * FROM Major";
        $get_major = mysqli_query($dbc, $query_get_major);
        $majors = array();
        while($row = mysqli_fetch_array($get_major)){
            array_push($majors, new Major($row['major_id'], $row['major_name']));
        }
        return $majors;
    }

    /**
     * @return mixed
     */
    public function getMajorId()
    {
        return $this->major_id;
    }


}