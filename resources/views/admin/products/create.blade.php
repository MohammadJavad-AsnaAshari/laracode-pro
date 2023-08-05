@component("admin.layouts.content", ["title" => "ایجاد محصول جدید"])
    @slot("breadcrumb")
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route("admin.products.index") }}">لیست محصولات</a></li>
    @endslot
    <div class="row">
        <div class="col-lg-12">
            @include("admin.layouts.errors")
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route("admin.products.store")}}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">نام محصول</label>
                            <input type="text" name="title" class="form-control" id="title"
                                   placeholder="نام محصول را وارد کنید" value="{{old("title")}}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیح محصول</label>
                            <textarea name="description" class="form-control" id="description"
                                      rows="10">{{old("description")}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="inventory" class="col-sm-2 control-label">موجودی</label>
                            <input type="number" name="inventory" class="form-control" id="inventory"
                                   placeholder="تعداد موجودی را وارد کنید" value="{{old("inventory")}}">
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>
                            <input type="number" name="price" class="form-control" id="price"
                                   placeholder="قیمت را وارد کنید" value="{{old("price")}}">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class=" card-footer">
                        <button type="submit" class="btn btn-info">ثبت محصول</button>
                        <a href=" {{route("admin.products.index")}} " type="submit"
                           class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

