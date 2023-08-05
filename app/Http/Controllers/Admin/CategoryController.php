<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ToDo search engine

        $categories = Category::where("parent_id", 0)->latest()->paginate(10);
        return view("admin.categories.all", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|min:3",
        ]);

        if ($request->parent_id) {
            $data["parent_id"] = $request->validate([
                "parent_id" => "exists:categories,id"
            ])["parent_id"];
        }

        $category = Category::create($data);

        Alert::success('Category Successfully Create :)', 'Success Message');
        return redirect(route("admin.categories.index"));
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
    public function edit(Category $category)
    {
        return view("admin.categories.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            "name" => "required|min:3",
        ]);

        if ($request->parent_id) {
            $data["parent_id"] = $request->validate([
                "parent_id" => "exists:categories,id"
            ])["parent_id"];
        }

        $category->update($data);

        Alert::success('Category Successfully Update :)', 'Success Message');
        return redirect(route("admin.categories.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Alert::success('Category Successfully Delete !', 'Success Message');
        return back();
    }
}
