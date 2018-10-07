<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 02.10.2018
 * Time: 20:35
 */

namespace Corp\Repositories;


use Corp\Filter;

class FilterRepository extends Repository
{
    public function __construct(Filter $model)
    {
        $this->model = $model;
    }
}