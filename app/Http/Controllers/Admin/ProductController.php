<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware("can:show-products")->only("index");
        $this->middleware("can:create-product")->only(["create", "store"]);
        $this->middleware("can:edit-product")->only(["edit", "update"]);
        $this->middleware("can:delete-product")->only("destroy");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query();

        if ($keyword = \request("search")) {
            $products->where(function ($query) use ($keyword) {
                $query->where("title", "like", "%{$keyword}%")
                    ->orWhere("description", "like", "%{$keyword}%")
                    ->orWhere("id", $keyword);
            });
        }

        $products = $products->latest()->paginate(10);
        return view("admin.products.all", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.products.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255', "unique:products,title"],
            'description' => ['required', 'string'],
            'inventory' => ['required', 'string'],
            'price' => ['required', 'string'],
            'categories' => ["required"],
            "attributes" => ["array"],
            "image" => ["required", "mimes:png,jpg,jpeg", "max:2048"]
        ]);

        $file = $request->file("image");
        $destinationPath = "/image/" . now()->year . "/" . now()->month . "/" . now()->day . "/";
        $file->move(public_path($destinationPath), $file->getClientOriginalName());

        $data["image"] = $destinationPath . $file->getClientOriginalName();

        $product = auth()->user()->products()->create($data);
        $product->categories()->sync($data["categories"]);

        if (isset($data["attributes"])) {
            $this->attachAttributesToProducts($product, $data);
        }

        Alert::success('Product Successfully Create :)', 'Success Message');
        return redirect(route("admin.products.index"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view("admin.products.edit", compact("product"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique("products")->ignore($product->id)],
            'description' => ['required', 'string'],
            'inventory' => ['required', 'string'],
            'price' => ['required', 'string'],
            'categories' => ["required"],
            "attributes" => ["array"],
        ]);

        $product->update($data); // Update the specific product instance
        $product->categories()->sync($data["categories"]);

        $product->attributes()->detach();

        $this->attachAttributesToProducts($product, $data);

        Alert::success('Product Successfully Edit :)', 'Success Message');
        return redirect(route("admin.products.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        Alert::success('User Account Successfully Delete !', 'Warning Message');
        return back();
    }

    /**
     * @param Product $product
     * @param array $data
     * @return void
     */
    protected function attachAttributesToProducts(Product $product, array $data): void
    {
        $attributes = collect($data["attributes"]);
        $attributes->each(function ($item) use ($product) {
            if (is_null($item["name"]) || is_null($item["value"])) return;

            $attr = Attribute::firstOrCreate([
                    "name" => $item["name"]]
            );

            $attr_value = $attr->values()->firstOrCreate([
                    "value" => $item["value"]]
            );

            $product->attributes()->attach($attr->id, ["value_id" => $attr_value->id]);
        });
    }
}
