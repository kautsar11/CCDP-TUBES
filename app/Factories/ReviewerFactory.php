<?php

namespace App\Factories;

use App\Models\Reviewer;

class ReviewerFactory implements ModelFactoryInterface
{
    public function create()
    {
        return new Reviewer();
    }
}
