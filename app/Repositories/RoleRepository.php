<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 10.09.2018
 * Time: 20:47
 */

namespace Corp\Repositories;


use Corp\Role;

class RoleRepository extends Repository
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }
}