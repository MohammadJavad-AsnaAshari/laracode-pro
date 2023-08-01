<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:show-permissions")->only("index");
        $this->middleware("can:create-permission")->only(["create", "store"]);
        $this->middleware("can:edit-permission")->only(["edit", "update"]);
        $this->middleware("can:delete-permission")->only("destroy");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::query();

        if ($keyword = \request("search")) {
            $permissions->where(function ($query) use ($keyword) {
                $query->where("name", "like", "%{$keyword}%")
                    ->orWhere("label", "like", "%{$keyword}%")
                    ->orWhere("id", $keyword);
            });
        }

        $permissions = $permissions->latest()->paginate(10);
        return view("admin.permissions.all", compact("permissions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.permissions.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:permissions"],
            'label' => ['required', 'string', 'max:255'],
        ]);

        $permission = Permission::create($data);

        Alert::success('User Account Successfully Create :)', 'Success Message');
        return redirect(route("admin.permissions.index"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view("admin.permissions.edit", compact("permission"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique("permissions")->ignore($permission->id)],
            'label' => ['required', 'string', 'max:255'],
        ]);


        $permission->update($data);


        Alert::success('User Account Successfully Update :)', 'Success Message');
        return redirect(route("admin.permissions.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        Alert::success('User Account Successfully Delete !', 'Warning Message');
        return back();
    }
}
