@component("admin.layouts.content", ["title" => "لیست محصولات"])
    @slot("breadcrumb")
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست محصولات</li>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم محصولات</h3>

                    <div class="card-tools d-flex">

                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو"
                                       value="{{request("search")}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="btn-group-sm mr-2">
                            @can("create-product")
                                <a href="{{route("admin.products.create")}}" class="btn btn-info">ایجاد محصول جدید</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی محصول</th>
                            <th>نام محصول</th>
                            <th>توضیح محصول</th>
                            <th>تعداد موجودی</th>
                            <th>تعداد بازدید</th>
                            <th>قیمت</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->title}}</td>
                                <td>{{$product->description}}</td>
                                <td>{{$product->inventory}}</td>
                                <td>{{$product->view_count}}</td>
                                <td>{{$product->price}}</td>

                                <td class="d-flex">
                                    @can("edit-product")
                                        <a href="{{route("admin.products.edit" , ["product" => $product->id])}}"
                                           class="btn btn-primary btn-sm">ویرایش
                                        </a>
                                    @endcan
                                    @can("delete-product")
                                        <form action="{{route("admin.products.destroy", ["product" => $product->id])}}"
                                              method="post">
                                            @csrf
                                            @method("delete")
                                            <button class="btn btn-danger btn-sm mr-1">حذف</button>
                                        </form>
                                    @endcan
                                    {{--                                    <a href="" class="btn btn-danger btn-sm">حذف</a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{$products->appends(["search" => request("search")])->render()}}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent


