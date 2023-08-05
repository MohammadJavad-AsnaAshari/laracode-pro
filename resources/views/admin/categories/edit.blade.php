@php use App\Models\Category; @endphp
@component("admin.layouts.content", ["title" => "ویرایش دسته"])
    @slot("breadcrumb")
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route("admin.categories.index") }}">لیست دسته ها</a></li>
    @endslot

    @slot("script")
        <script>
            $("#categories").select2({"placeholder": "دسترسی مورد نظر را انتخاب کنید"})
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include("admin.layouts.errors")
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش دسته</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal"
                      action="{{route("admin.categories.update", ["category" => $category->id])}}"
                      method="POST">
                    @csrf
                    @method("patch")

                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">نام دسته</label>
                            <input type="text" name="name" class="form-control" id="inputEmail3"
                                   placeholder="نام دسته را وارد کنید" value="{{old("name", $category->name)}}">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">دسته مرتبط</label>
                            <select name="parent_id" id="categories" class="form-control">
                                @foreach(Category::all() as $cat)
                                    <option
                                        value="{{$cat->id}}" {{$cat->id === $category->parent_id ? 'selected' : ''}}>{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش دسته</button>
                        <a href=" {{route("admin.categories.index")}} " type="submit"
                           class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

