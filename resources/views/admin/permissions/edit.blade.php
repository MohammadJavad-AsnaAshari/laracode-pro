@component("admin.layouts.contenct", ["title" => "ویرایش دسترسی"])
    @slot("breadcrumb")
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route("admin.permissions.index") }}">دسترسی ها</a></li>
    @endslot
    <div class="row">
        <div class="col-lg-12">
            @include("admin.layouts.errors")
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route("admin.permissions.update", ["permission" => $permission->id])}}"
                      method="POST">
                    @csrf
                    @method("patch")

                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">نام دسترسی</label>
                            <input type="text" name="name" class="form-control" id="inputEmail3"
                                   placeholder="نام دسترسی را وارد کنید" value="{{old("name", $permission->name)}}">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">توضیح دسترسی</label>
                            <input type="text" name="label" class="form-control" id="inputEmail3"
                                   placeholder="توضیح دسترسی را وارد کنید" value="{{old("label", $permission->label)}}">
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش دسترسی</button>
                        <a href=" {{route("admin.permissions.index")}} " type="submit"
                           class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

