<?php

namespace App\Models;

use App\Models\BaseModel;
use PDO;

class Course extends BaseModel
{
    // Fetch all courses and the number of enrolled students per course
    public function all()
    {
        $sql = "SELECT c.*, COUNT(ce.student_code) AS enrollees_count
                FROM courses AS c
                LEFT JOIN course_enrolments AS ce ON c.course_code = ce.course_code
                GROUP BY c.course_code";
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
        return $result;
    }

    // Find a course by course code
    public function find($course_code)
    {
        $sql = "SELECT * FROM courses WHERE course_code = :course_code LIMIT 1";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':course_code', $course_code, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchObject('\App\Models\Course');
        return $result;
    }

    // Get all enrollees for a specific course
    public function getEnrolees($course_code)
    {
        $sql = "SELECT s.*
                FROM course_enrolments AS ce
                LEFT JOIN students AS s ON s.student_code = ce.student_code
                WHERE ce.course_code = :course_code";
        
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'course_code' => $course_code
        ]);
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }
}
