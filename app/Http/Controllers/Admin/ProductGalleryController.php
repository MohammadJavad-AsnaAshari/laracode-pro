<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $images = $product->galleries()->latest()->paginate(10);
        return view("admin.products.gallery.all", compact(["product", "images"]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view("admin.products.gallery.create", compact("product"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            "images.*.image" => "required",
            "images.*.alt" => "required|min:3"
        ]);

        collect($data["images"])->each(function ($image) use ($product) {
            $product->galleries()->create($image);
        });

        Alert::success('Product Gallery Successfully Create :)', 'Success Message');
        return redirect(route("admin.products.gallery.index", ['product' => $product->id]));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductGallery $gallery)
    {
        $gallery->delete();
        Alert::success('Product Gallery Successfully Delete :)', 'Success Message');
        return back();
    }
}
