<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\CourseEnrolment;
use App\Models\Student;
use App\Controllers\BaseController;

class EnrolmentController extends BaseController
{
    // Display the enrollment form with courses and students
    public function enrollmentForm()
    {
        $courseObj = new Course();
        $studentObj = new Student();

        $template = 'enrollment-form'; // This should match your view file name
        $data = [
            'courses' => $courseObj->all(),
            'students' => $studentObj->all()
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    // Handle the form submission and enroll the student in the course
    public function enroll()
    {
        // Retrieve form data from POST request
        $course_code = $_POST['course_code'];
        $student_code = $_POST['student_code'];
        $enrolment_date = $_POST['enrolment_date'];

        // Create a new instance of CourseEnrolment to handle enrollment
        $enrolmentObj = new CourseEnrolment();
        
        // Insert the enrollment record into the course_enrollments table
        $enrolmentObj->enroll($course_code, $student_code, $enrolment_date);

        // Redirect the user to the course details page after successful enrollment
        header("Location: /courses/{$course_code}");
        exit();
    }
}
