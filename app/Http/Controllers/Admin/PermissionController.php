<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Permission;
use Corp\Repositories\PermissionRepository;
use Corp\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends AdminController
{
    protected $per_rep;
    protected $rol_rep;

    public function __construct(PermissionRepository $per_rep, RoleRepository $rol_rep)
    {
        parent::__construct();

        $this->per_rep = $per_rep;
        $this->rol_rep = $rol_rep;
        $this->template = 'admin.general';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('view', new Permission())) {
//            abort(403);
            $key = 'custom.VIEW_ADMIN_PERMISSIONS';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $this->title = "Управление правами";

        $roles = $this->getRoles();
        $permissions = $this->getPermissions()->sortByDesc('name');
        $this->content_view = view(config('settings.theme') . '.admin.permissions_content')
            ->with(['roles' => $roles, 'permissions' => $permissions])
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->per_rep->changePermission($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.permissions.index')->with($result);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getRoles()
    {
        return $this->rol_rep->get(['id', 'name']);
    }

    public function getPermissions()
    {
        return $this->per_rep->get(['id', 'name']);
    }
}
