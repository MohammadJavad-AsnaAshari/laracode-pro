@php use App\Models\Category; @endphp
@component("admin.layouts.content", ["title" => "ویرایش محصول"])
    @slot("breadcrumb")
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route("admin.products.index") }}">لیست محصولات</a></li>
    @endslot

    @slot("script")
        <script>
            $("#categories").select2({"placeholder": "دسته بندی مورد نظر را انتخاب کنید"})
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include("admin.layouts.errors")
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route("admin.products.update", ["product" => $product->id])}}"
                      method="POST">
                    @csrf
                    @method("patch")

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">نام محصول</label>
                            <input type="text" name="title" class="form-control" id="title"
                                   placeholder="نام محصول را وارد کنید" value="{{old("title", $product->title)}}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیح محصول</label>
                            <textarea name="description" class="form-control" id="description"
                                      rows="10">{{old("description", $product->description)}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="inventory" class="col-sm-2 control-label">موجودی</label>
                            <input type="number" name="inventory" class="form-control" id="inventory"
                                   placeholder="تعداد موجودی را وارد کنید"
                                   value="{{old("inventory", $product->inventory)}}">
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>
                            <input type="number" name="price" class="form-control" id="price"
                                   placeholder="قیمت را وارد کنید" value="{{old("price", $product->price)}}">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">دسترسی ها</label>
                            <select name="categories[]" id="categories" class="form-control" multiple>
                                @foreach(Category::all() as $category)
                                    <option value="{{$category->id}}"
                                        {{in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : ''}}>
                                        {{$category->name}} - {{$category->label}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش محصول</button>
                        <a href=" {{route("admin.products.index")}} " type="submit"
                           class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

