<?php

namespace App\Controllers;

use App\Models\Course;
use App\Controllers\BaseController;

class CourseController extends BaseController
{
    // Display the list of all courses
    public function list()
    {
        $obj = new Course();
        $courses = $obj->all();

        $template = 'courses'; // The HTML template for the course list
        $data = [
            'items' => $courses
        ];

        $output = $this->render($template, $data);
        return $output;
    }

    // View a single course along with its enrollees
    public function viewCourse($course_code)
    {
        $courseObj = new Course();
        $course = $courseObj->find($course_code);
        $enrollees = $courseObj->getEnrolees($course_code);

        $template = 'single-course'; // The HTML template for a single course and its enrollees
        $data = [
            'course' => $course,
            'enrollees' => $enrollees
        ];

        $output = $this->render($template, $data);
        return $output;
    }
}
