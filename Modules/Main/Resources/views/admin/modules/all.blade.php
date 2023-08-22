@component('admin.layouts.content' , ['title' => 'مدیریت ماژول ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">مدیریت ماژول ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ماژول ها</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @foreach($modules as $module)
                            @php
                                $moduleData = new \Nwidart\Modules\Json($module->getPath() . "/module.json");
                            @endphp
                            <div class="col-sm-2">
                                <div class="mt-4">
                                    <h4>{{$moduleData->alias}}</h4>
                                    <p>{{$moduleData->description}}</p>
                                </div>
                                @if(\Module::isEnabled($module))
                                    <a href="#" class="btn btn-sm btn-danger">غیر فعالسازی</a>
                                @else
                                    <a href="" class="btn btn-sm btn-primary">فعالسازی</a>
                                @endif
                            </div>
                            {{--                            <div class="col-sm-2">--}}
                            {{--                                <a href="{{ url($image['image']) }}">--}}
                            {{--                                    <img src="{{ url($image['image']) }}" class="img-fluid mb-2" alt="{{ url($image['alt']) }}">--}}
                            {{--                                </a>--}}
                            {{--                                <form action="{{ route('admin.products.gallery.destroy' , ['product' => $product->id , 'gallery' => $image->id]) }}" id="image-{{ $image->id }}" method="post">--}}
                            {{--                                    @method('delete')--}}
                            {{--                                    @csrf--}}
                            {{--                                </form>--}}
                            {{--                                <a href="{{ route('admin.products.gallery.edit' , ['product' => $product->id , 'gallery' => $image->id]) }}" class="btn btn-sm btn-primary">ویرایش</a>--}}
                            {{--                                <a href="#" class="btn btn-sm btn-danger" onclick="document.getElementById('image-{{ $image->id }}').submit()">حذف</a>--}}
                            {{--                            </div>--}}
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{--                    {{ $images->render() }}--}}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent
