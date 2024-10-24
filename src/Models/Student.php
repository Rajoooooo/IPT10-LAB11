<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Student extends BaseModel
{
    // Attributes
    public $student_id;
    public $student_code;
    public $first_name;
    public $last_name;
    public $email;
    public $date_of_birth;
    public $sex;

    // Method to fetch all students
    public function all()
    {
        $sql = "SELECT * FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

    // Method to get the student's full name
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Method to get the student code
    public function getStudentCode()
    {
        return $this->student_code;
    }

    // Method to get the student email
    public function getEmail()
    {
        return $this->email;
    }

    // Method to find a student by their student code
    public function find($student_code)
    {
        $sql = "SELECT * FROM students WHERE student_code = :student_code LIMIT 1";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':student_code', $student_code, PDO::PARAM_STR);
        $statement->execute();
        $student = $statement->fetchObject('\App\Models\Student');

        return $student ?: null; // Return null if no student is found
    }
}
