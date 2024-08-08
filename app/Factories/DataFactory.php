<?php

namespace App\Factories;

use App\Models\Data;

class DataFactory implements ModelFactoryInterface
{
    public function create()
    {
        return new Data();
    }
}
