<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 14.09.2018
 * Time: 12:23
 */

namespace Corp\Repositories;


use Corp\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function addUser($request)
    {
        if (Gate::denies('create', $this->model)) {
//            abort(403);
            $key = 'custom.CREATE_' . strtoupper(class_basename($this->model)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $data = $request->all();

        $user = $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'login' => $data['login']
        ]);


        // Создавать только Guest!!!
        $data['role_id'] = 3;

        if ($user) {
            $user->roles()->attach($data['role_id']);
            return ['status' => 'Пользователь добавлен'];
        } else {
            return ['error' => 'Не удалось добавить пользователя'];
        }
    }

    public function updateUser($request, $user)
    {
        if (Gate::denies('update', $user)) {
//            abort(403);
            $key = 'custom.UPDATE_' . strtoupper(class_basename($user)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $data = $request->all();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data)->update();

        // Оставлять ту же роль!!!
//        $user->roles()->sync([$data['role_id']]);

        return ['status' => 'Пользователь изменен'];
    }

    public function destroyUser($user)
    {
        if (Gate::denies('delete', $user)) {
//            abort(403);
            $key = 'custom.DELETE_' . strtoupper(class_basename($user)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $user->roles()->detach();

        if ($user->delete()) {
            return ['status' => 'Пользователь удален'];
        }
    }
}