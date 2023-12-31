@component("admin.layouts.content", ["title" => "لیست نظرات"])
    @slot("breadcrumb")
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست نظرات</li>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم نظرات</h3>

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

                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی نظر</th>
                            <th>نام کاربر</th>
                            <th>متن نظر</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{$comment->id}}</td>
                                <td>{{$comment->user->name}}</td>
                                <td>{{$comment->comment}}</td>

                                <td class="d-flex">
                                    @can("delete-comment")
                                        <form action="{{route("admin.comments.destroy", ["comment" => $comment->id])}}"
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
                    {{$comments->appends(["search" => request("search")])->render()}}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent


