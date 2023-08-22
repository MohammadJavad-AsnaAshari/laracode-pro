@php use App\Models\Order;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Route; @endphp
<div class="sidebar" style="direction: ltr">
    <div style="direction: rtl">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/img/the-journey-within-kamdon-simmons.jpg"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview ">
                    <a href="{{route("admin.")}}"
                       class="nav-link {{isActive("admin.")}}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            پنل مدیریت
                        </p>
                    </a>
                </li>

                @can("show-users")
                    <li class="nav-item has-treeview {{isActive(["admin.users.index", "admin.users.create", "admin.users.edit"], "menu-open")}}">
                        <a href="#"
                           class="nav-link {{isActive(["admin.users.index", "admin.users.create", "admin.users.edit"])}}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                کاربران
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route("admin.users.index")}}"
                                   class="nav-link {{isActive(["admin.users.index", "admin.users.create", "admin.users.edit"])}}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست کاربران</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany(["show-permissions", "show-roles"])
                    <li class="nav-item has-treeview {{isActive(["admin.permissions.index", "admin.roles.index", "admin.permissions.create", "admin.permissions.edit" , "admin.roles.create", "admin.roles.edit"], "menu-open")}}">
                        <a href="#"
                           class="nav-link {{isActive(["admin.permissions.index", "admin.roles.index", "admin.permissions.create", "admin.permissions.edit" , "admin.roles.create", "admin.roles.edit"])}}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                اجازه دسترسی ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        @can("show-permissions")
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route("admin.permissions.index", "admin.permissions.create", "admin.permissions.edit")}}"
                                       class="nav-link {{isActive(["admin.permissions.index", "admin.permissions.create", "admin.permissions.edit"])}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>همه دسترسی ها</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can("show-roles")
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route("admin.roles.index", "admin.roles.create", "admin.roles.edit")}}"
                                       class="nav-link {{isActive(["admin.roles.index", "admin.roles.create", "admin.roles.edit"])}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>همه مقام ها</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                    </li>
                @endcanany
                @can("show-products")
                    <li class="nav-item has-treeview {{isActive(["admin.products.index", "admin.products.create", "admin.products.edit"], "menu-open")}}">
                        <a href="#"
                           class="nav-link {{isActive(["admin.products.index", "admin.products.create", "admin.products.edit"])}}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                محصولات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route("admin.products.index")}}"
                                   class="nav-link {{isActive(["admin.products.index", "admin.products.create", "admin.products.edit"])}}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست محصولات</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can("show-products")
                    <li class="nav-item has-treeview {{isActive(["admin.categories.index", "admin.categories.create", "admin.categories.edit"], "menu-open")}}">
                        <a href="#"
                           class="nav-link {{isActive(["admin.categories.index", "admin.categories.create", "admin.categories.edit"])}}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                دسته بندی ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route("admin.categories.index")}}"
                                   class="nav-link {{isActive(["admin.categories.index", "admin.categories.create", "admin.categories.edit"])}}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست دسته بندی ها</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany(["show-comments", "show-unapproved"])
                    <li class="nav-item has-treeview {{isActive(["admin.comments.index", "admin.comments.unapproved"], "menu-open")}}">
                        <a href="#"
                           class="nav-link {{isActive(["admin.comments.index", "admin.comments.unapproved"])}}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                نظرات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        @can("show-comments")
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route("admin.comments.index")}}"
                                       class="nav-link {{isActive(["admin.comments.index"])}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>نظرات تایید شده</p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can("show-unapproved")
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route("admin.comments.unapproved")}}"
                                       class="nav-link {{isActive(["admin.comments.unapproved"])}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>نظرات تایید نشده</p>
                                    </a>
                                </li>
                            </ul>
                @endcan
                <li class="nav-item has-treeview {{ isActive(['admin.orders.index',] , 'menu-open') }}">
                    <a href="#" class="nav-link {{ isActive(['admin.orders.index']) }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            بخش سفارشات
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index' , ['type' => 'unpaid']) }}"
                               class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'unpaid'])) }} ">
                                <i class="fa fa-circle-o nav-icon text-warning"></i>
                                <p>پرداخت نشده
                                    <span
                                        class="badge badge-warning right">{{ Order::whereStatus('unpaid')->count() }}</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index' , ['type' => 'paid']) }}"
                               class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'paid'])) }}">
                                <i class="fa fa-circle-o nav-icon text-info"></i>
                                <p>پرداخت شده
                                    <span
                                        class="badge badge-info right">{{ Order::whereStatus('paid')->count() }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index'  , ['type' => 'preparation']) }}"
                               class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'preparation'])) }}">
                                <i class="fa fa-circle-o nav-icon text-primary"></i>
                                <p>در حال پردازش
                                    <span
                                        class="badge badge-primary right">{{ Order::whereStatus('preparation')->count() }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index' , ['type' => 'posted']) }}"
                               class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'posted'])) }}">
                                <i class="fa fa-circle-o nav-icon text text-light"></i>
                                <p>ارسال شده
                                    <span
                                        class="badge badge-light right">{{ Order::whereStatus('posted')->count() }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index' , ['type' => 'received']) }}"
                               class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'received'])) }}">
                                <i class="fa fa-circle-o nav-icon text-success"></i>
                                <p>دریافت شده
                                    <span
                                        class="badge badge-success right">{{ Order::whereStatus('received')->count() }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index' , ['type' => 'canceled']) }}"
                               class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'canceled'])) }}">
                                <i class="fa fa-circle-o nav-icon text-danger"></i>
                                <p>کنسل شده
                                    <span
                                        class="badge badge-danger right">{{ Order::whereStatus('canceled')->count() }}</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <li class="nav-item has-treeview ">
                            <a href="{{route("admin.modules.index")}}"
                               class="nav-link {{isActive("admin.modules.index")}}">
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    مدیریت ماژول ها
                                </p>
                            </a>
                        </li>
                    </ul>
                @endcanany
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</div>
