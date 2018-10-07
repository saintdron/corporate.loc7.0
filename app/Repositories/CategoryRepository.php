<?php

namespace Corp\Repositories;

use Corp\Category;

class CategoryRepository extends Repository
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }
}