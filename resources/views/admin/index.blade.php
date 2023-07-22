@component("admin.layouts.contenct", ["title" => "پنل مدیریت"])
    @slot("breadcrumb")
        <li class="breadcrumb-item active">پنل مدیریت</li>
        <li class="breadcrumb-item"><a href="{{ route("admin.users.index") }}">لیست کاربران</a></li>
    @endslot
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto asperiores eaque fugit illo in nemo nulla
        omnis repudiandae sed sint. Assumenda, autem consequuntur illum ipsum nihil nostrum reiciendis voluptatum. Ad
        deleniti dolor dolore est et ex fugiat, iure nulla odio repellendus sit, veritatis, vero. Deserunt facere
        mollitia provident velit veritatis.</p>
@endcomponent
