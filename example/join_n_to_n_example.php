<?php

require 'db_config.php';
require '../vendor/autoload.php';

require 'Models/Course.php';
require 'Models/Student.php';
require 'Models/StudentCourse.php';

use Example\Models\Student;
use Example\Models\Course;

$student = (new Student())->findById(1);
$course = (new Course())->findById(1);

echo "<p>The student {$student->name} finished: </p>";
var_dump($student->doneCourses());

echo "<p>The course {$course->name} was finished by: </p>";
var_dump($course->studentsThatFinished());