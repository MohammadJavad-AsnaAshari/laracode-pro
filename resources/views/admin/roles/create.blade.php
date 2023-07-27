@php use App\Models\Permission; @endphp
@component("admin.layouts.contenct", ["title" => "ایجاد مقام جدید"])
    @slot("breadcrumb")
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route("admin.roles.index") }}">مقام ها</a></li>
    @endslot
    <div class="row">
        <div class="col-lg-12">
            @include("admin.layouts.errors")
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد مقام</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route("admin.roles.store")}}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">نام مقام</label>
                            <input type="text" name="name" class="form-control" id="inputEmail3"
                                   placeholder="نام مقام را وارد کنید" value="{{old("name")}}">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">توضیح مقام</label>
                            <input type="text" name="label" class="form-control" id="inputEmail3"
                                   placeholder="توضیح مقام را وارد کنید" value="{{old("label")}}">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">دسترسی ها</label>
                            <select name="permissions[]" id="" class="form-control" multiple>
                                @foreach(Permission::all() as $permission)
                                    <option value="{{$permission->id}}">{{$permission->name}}
                                        // {{$permission->label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت مقام</button>
                        <a href=" {{route("admin.roles.index")}} " type="submit"
                           class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

