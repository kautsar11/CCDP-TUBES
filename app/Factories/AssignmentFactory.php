<?php

namespace App\Factories;

use App\Models\Assignment;

class AssignmentFactory implements ModelFactoryInterface
{
    public function create()
    {
        return new Assignment();
    }
}
