<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class CourseEnrolment extends BaseModel
{
    // Enroll a student into a course
    public function enroll($course_code, $student_code, $enrolment_date)
    {
        $sql = "INSERT INTO course_enrolments (course_code, student_code, enrolment_date)
                VALUES (:course_code, :student_code, :enrolment_date)";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'course_code' => $course_code,
            'student_code' => $student_code,
            'enrolment_date' => $enrolment_date
        ]);
    }

    // Get all enrolled students in a course
    public function getEnrolleesByCourse($course_code)
    {
        $sql = "SELECT s.* FROM course_enrolments ce 
                JOIN students s ON ce.student_code = s.student_code 
                WHERE ce.course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
