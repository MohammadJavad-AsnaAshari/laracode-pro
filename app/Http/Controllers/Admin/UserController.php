<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:edit-user,user")->only(["edit"]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query();

        if ($keyword = \request("search")) {
            $users->where(function ($query) use ($keyword) {
                $query->where("email", "like", "%{$keyword}%")
                    ->orWhere("name", "like", "%{$keyword}%")
                    ->orWhere("id", $keyword);
            });
        }

        if (\request("admin")) {
            $users->where(function ($query) {
                $query->where("is_superuser", 1)
                    ->orWhere("is_staff", 1);
            });
        }

        $users = $users->latest()->paginate(10);
        return view("admin.users.all", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($data);

        if ($request->has("verify")) {
            $user->markEmailAsVerified();
        }

        Alert::success('User Account Successfully Create :)', 'Success Message');
        return redirect(route("admin.users.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
//        if (Gate::allows("edit-user", $user)) {
//            return view("admin.users.edit", compact("user"));
//        }
//        abort(403);

//        if (Gate::denies("edit-user", $user)) {
//            abort(403);
//        }
//        return view("admin.users.edit", compact("user"));

//        $this->authorize("edit-user", $user);
//        return view("admin.users.edit", compact("user"));

//        if (auth()->user()->can("edit-user", $user)) {
//            return view("admin.users.edit", compact("user"));
//        }
//        abort(403);

        return view("admin.users.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique("users")->ignore($user->id)],
        ]);

        if (!is_null($request->password)) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $data["password"] = $request->password;
        }

        $user->update($data);

        if ($request->has("verify")) {
            $user->markEmailAsVerified();
        }

        Alert::success('User Account Successfully Update :)', 'Success Message');
        return redirect(route("admin.users.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        $user->delete();

        Alert::success('User Account Successfully Delete !', 'Warning Message');
        return back();
    }
}
