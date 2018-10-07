<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 10.09.2018
 * Time: 20:46
 */

namespace Corp\Repositories;


use Corp\Permission;
use Illuminate\Support\Facades\Gate;
use Request;

class PermissionRepository extends Repository
{
    protected $rol_rep;

    public function __construct(Permission $model, RoleRepository $rol_rep)
    {
        $this->model = $model;
        $this->rol_rep = $rol_rep;
    }

    public function changePermission($request)
    {
        if (Gate::denies('update', $this->model)) {
//            abort(403);
            $key = 'custom.EDIT_PERMISSIONS';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $data = $request->except('_token');
        $roles = $this->rol_rep->get(['id']);
        foreach ($roles as $role) {
            if (isset($data['roles'][$role->id])) {
                $role->savePermissions($data['roles'][$role->id]);
            } else {
                $role->savePermissions([]);
            }
        }

        return ['status' => 'Права обновлены'];
    }
}