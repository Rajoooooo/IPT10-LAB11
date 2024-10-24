<?php

require "vendor/autoload.php";
require "init.php";

// Database connection object (from init.php (DatabaseConnection))
global $conn;

try {

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Define routes
    $router->get('/students', '\App\Controllers\StudentController@list');
    $router->get('/courses', '\App\Controllers\CourseController@list');
    $router->get('/courses/{course_code}', '\App\Controllers\CourseController@viewCourse');
    $router->get('/enrollment-form', '\App\Controllers\EnrolmentController@enrollmentForm');
    $router->post('/enroll', '\App\Controllers\EnrolmentController@enroll');

    // Route for exporting course enrollees to PDF
    $router->get('/export-course/{course_code}', '\App\Controllers\CourseController@exportToPDF');

    // Run it!
    $router->run();

} catch (Exception $e) {
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
