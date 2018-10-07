<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Http\Requests\UserRequest;
use Corp\Repositories\RoleRepository;
use Corp\Repositories\UserRepository;
use Corp\User;
use Illuminate\Support\Facades\Gate;

class UserController extends AdminController
{
    public function __construct(RoleRepository $rol_rep, UserRepository $u_rep)
    {
        parent::__construct();

        $this->rol_rep = $rol_rep;
        $this->u_rep = $u_rep;
        $this->template = 'admin.general';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('view', new User())) {
//            abort(403);
            $key = 'custom.VIEW_ADMIN_USERS';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $this->title = "Управление пользователями";

        $users = $this->getUsers();
        $this->content_view = view(config('settings.theme') . '.admin.users_content')
            ->with('users', $users)
            ->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
/*        if (Gate::denies('create', new User())) {
            abort(403);
        }*/

        $this->title = "Создание нового пользователя";

        $roles = $this->getRoles();
        $this->content_view = view(config('settings.theme') . '.admin.users_edit_content')
            ->with('roles', $roles)
            ->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $result = $this->u_rep->addUser($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.users.index')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
/*        if (Gate::denies('update', $user)) {
            abort(403);
        }*/

        $this->title = "Редактирование пользователя – " . $user->title;

        $roles = $this->getRoles();

        $this->content_view = view(config('settings.theme') . '.admin.users_edit_content')
            ->with(['roles' => $roles, 'user' => $user])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $result = $this->u_rep->updateUser($request, $user);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.users.index')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $this->u_rep->destroyUser($user);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.users.index')->with($result);
    }

    public function getUsers()
    {
        return $this->u_rep->get(['id', 'login', 'name', 'email']);
    }

    public function getRoles()
    {
        $currentRoleId = \Auth::user()->roles->sortBy('id')->values()->first()->id;
        $rolesAll = $this->rol_rep->get(['id', 'name']);
        $roles = $rolesAll->reduce(function ($carry, $item) use ($currentRoleId) {
            if ($item->id >= $currentRoleId) {
                return array_add($carry, $item->id, $item->name);
            } else {
                return $carry;
            }
        }, []);
        return $roles;
    }
}
