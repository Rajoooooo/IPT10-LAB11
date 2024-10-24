<?php

namespace App\Controllers;

use App\Models\Course;
use App\Controllers\BaseController;
use Fpdf\Fpdf;

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

    public function exportToPDF($course_code)
    {
        $courseObj = new Course();
        
        // Assuming 'find()' returns an object, not an array
        $course = $courseObj->find($course_code);
        
        // Extract course details
        $course_code = $course->course_code;
        $course_name = $course->course_name;
        $description = $course->description;
        $credits = $course->credits;
    
        // Retrieve enrollees
        $enrollees = $courseObj->getEnrolees($course_code);
    
        // Create a new PDF instance
        $pdf = new Fpdf();
        $pdf->AddPage();
    
        // Set title
        $pdf->SetY(20); // Move down for title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Course Information', 0, 1, 'C');
        $pdf->Ln(10); // Add space after title
    
        // Course details
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Course Code: ' . $course_code, 0, 1);
        $pdf->Cell(0, 10, 'Course Name: ' . $course_name, 0, 1);
        $pdf->Cell(0, 10, 'Description: ' . $description, 0, 1);
        $pdf->Cell(0, 10, 'Credits: ' . $credits, 0, 1);
        $pdf->Ln(10);
    
        // Enrollees section
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'List of Enrollees', 0, 1, 'C');
        $pdf->Ln(5);
    
        // Table header
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, 'Student Code', 1);
        $pdf->Cell(50, 10, 'First Name', 1);
        $pdf->Cell(50, 10, 'Last Name', 1);
        $pdf->Cell(60, 10, 'Email', 1);
        $pdf->Ln();
    
        // Table body
        $pdf->SetFont('Arial', '', 12);
        if (!empty($enrollees)) {
            foreach ($enrollees as $student) {
                // Access student properties correctly as an object
                $pdf->Cell(30, 10, $student->student_code, 1);
                $pdf->Cell(50, 10, $student->first_name, 1);
                $pdf->Cell(50, 10, $student->last_name, 1);
                $pdf->Cell(60, 10, $student->email, 1);
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(0, 10, 'No students enrolled.', 0, 1);
        }
    
        // Output the PDF to the browser (inline display)
        $pdf->Output('I', 'course_enrollees_' . $course_code . '.pdf');
    }
    

}
