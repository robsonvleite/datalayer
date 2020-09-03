<?php

namespace Example\Models;

use CoffeeCode\DataLayer\DataLayer;

class StudentCourse extends DataLayer
{
    /**
     * StudentCourse constructor.
     */
    public function __construct()
    {
        parent::__construct("student_course", ["idstudent", "idcourse"], "id", false);
    }
}