<?php

namespace Example\Models;

use CoffeeCode\DataLayer\DataLayer;

class Course extends DataLayer
{
    /**
     * Course constructor.
     */
    public function __construct()
    {
        parent::__construct("courses", ["name"], "id", false);
    }

    public function studentsWhoPrefer()
    {
        $students = new Student();
        return $this
            ->select("*, courses.name as course_name")
            ->join(
                $students, 
                'courses.id', '=', 'students.preferred_course')
            ->where(
                'courses.id = :id', 
                "id={$this->id}")
            ->limit(5)
            ->fetch(true);
    }

    public function studentsThatFinished()
    {
        $students = new Student();
        $studentCourse = new StudentCourse();

        return $this
            ->select()
            ->join(
                $studentCourse,
                "courses.id", "=", "student_course.idcourse"
            )
            ->join(
                $students,
                "students.id", "=", "student_course.idstudent"
            )
            ->where(
                "courses.id = :id",
                "id={$this->id}"
            )
            ->fetch(true);
    }
}