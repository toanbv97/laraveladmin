<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            \session(['module_active' => 'role', 'active' => 'Quyền quản trị']);
            return $next($request);
        });
    }

    public function index()
    {
        $this->authorize('view', Role::class);
        $roles = Role::all();
        $permissionParents = Permission::where('parent_id', 0)->get();
        return \view('admin.role.index', \compact('roles', 'permissionParents'));
    }

    public function create()
    {
        $this->authorize('create', Role::class);
        $permissionParents = Permission::where('parent_id', 0)->get();
        return \view('admin.role.create', \compact('permissionParents'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'desc' => 'required|string|max:255',
            ],
            [
                'max' => ':attribute dài tối đa 255 ký tự',
            ],
            [
                'name' => 'Tên quyền',
                'desc' => 'Mô tả quyền',
            ],
        );
        $data = [
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
        ];
        $role = Role::create($data);
        $role->permissions()->attach($request->input('permission_id'));
        return \redirect()->route('role.list')->with('success', 'Thêm thành công quyền quản trị mới!');
    }

    public function edit($id)
    {
        $this->authorize('update', Role::class);
        $role = Role::find($id);
        $permissionParents = Permission::where('parent_id', 0)->get();
        return \view('admin.role.update', \compact('permissionParents', 'role'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
        ];
        Role::where('id', $id)->update($data);
        $role = Role::find($id);
        $role->permissions()->sync($request->input('permission_id'));
        return \redirect()->route('role.list')->with('success', "Cập nhật quyền quản trị thành công!");
    }

    public function delete(Request $request)
    {
        $this->authorize('delete', Role::class);
        $data = $request->all();
        $id = $data['id'];
        $role = Role::find($id);
        $role->permissions()->sync([]);
        Role::where('id', $id)->delete();
    }

}
