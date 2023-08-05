@php use App\Models\Category; @endphp
@component("admin.layouts.content", ["title" => "ایجاد دسته جدید"])
    @slot("breadcrumb")
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route("admin.categories.index") }}">لیست دسته بندی ها</a></li>
    @endslot
    <div class="row">
        <div class="col-lg-12">
            @include("admin.layouts.errors")
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد دسته</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route("admin.categories.store")}}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">نام دسته</label>
                            <input type="text" name="name" class="form-control" id="inputEmail3"
                                   placeholder="نام دسته را وارد کنید" value="{{old("name")}}">
                        </div>
                        @if(request("parent_id"))
                            @php
                                $parent_id = Category::find(request("parent_id"));
                            @endphp
                            <label for="inputEmail3" class="col-sm-2 control-label">دسته مرتبط</label>
                            <input type="text" class="form-control" id="inputEmail3" disabled value="{{$parent_id->name}}">
                            <input type="hidden" name="parent_id" value="{{$parent_id->id}}">
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت دسته</button>
                        <a href=" {{route("admin.categories.index")}} " type="submit"
                           class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

