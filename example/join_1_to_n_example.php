<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/Course.php';
require 'Models/Student.php';
require 'Models/StudentCourse.php';

use Example\Models\Student;
use Example\Models\Course;

$student = (new Student())->findById(1);
$course = (new Course())->findById(3);

echo "<p>The {$course->name} course is preferred by: </p>";
var_dump($course->studentsWhoPrefer());