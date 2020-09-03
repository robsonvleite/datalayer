<?php

namespace Example\Models;

use CoffeeCode\DataLayer\DataLayer;

class Student extends DataLayer
{
    /**
     * Student constructor.
     */
    public function __construct()
    {
        parent::__construct("students", ["name", "birthdate"], "id", false);
    }

    /**
     * @return array|null
     */
    public function doneCourses(): ?array
    {
        $courses = new Course();
        $studentCourse = new StudentCourse();

        return $this
            ->select("*, students.name as student_name")
            ->join(
                $studentCourse,
                "students.id", "=", "student_course.idstudent"
            )
            ->join(
                $courses,   
                "courses.id", "=", "student_course.idcourse"
            )
            ->where(
                "student_course.idstudent = :id",
                "id={$this->id}"
            )
            ->fetch(true);
    }
}