<nav class="sidebar-nav">
    <ul class="nav">
        {{--        @if()--}}

        {{--        @endif--}}
        <li class="nav-divider">
        <li class="nav-item">
            <a class="nav-link" href="{{route('panel') }}"><i class="icon-speedometer"></i> پیشخوان <span
                    class="badge badge-primary">جدید</span></a>
        </li>

        <li class="nav-divider"></li>

        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i>مدیریت کاربران</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="/admin-panel/user" class="nav-link"><i class="icon-user-follow"></i> ثبت نام شده</a>
                    </li>
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a href="/admin-panel/user/view/instant-charge" class="nav-link"><i class="icon-plus"></i>شارژ--}}
                    {{--                            سریع</a>--}}
                    {{--                    </li>--}}
                </ul>
            </li>
        @endif
        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-diamond"></i> کسب وکار</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/business"><i class="fa fa-building-o"></i> ثبت نام
                            شده</a>
                    </li>

                    {{--                    <li class="nav-divider"></li>--}}
                    {{--                    <li class="nav-title">--}}
                    {{--                        همکاری در فروش--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a href="#" class="nav-link"><i class="icon-user-follow"></i>مدیریت همکاران</a>--}}
                    {{--                    </li>--}}
                </ul>
            </li>
        @endif
        @if(checkRolesAccessLevel(  Auth::user()->role_id ,6))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i>مدیریت مشتریان</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="/admin-panel/customer/view/list" class="nav-link">
                            <i class="fas fa-list"></i>
                            لیست مشتریان
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/customer/view/add" class="nav-link">
                            <i class="icon-user-follow"></i>
                            ثبت نام جدید
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/customer/view/category" class="nav-link"><i class="fas fa-tag"></i>
                            دسته بندی مشتریان
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/customer/view/tag" class="nav-link"><i class="fas fa-tags"></i>
                            تگ مشتریان
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/customer/view/instant-charge" class="nav-link"><i class="icon-plus"></i>
                            شارژ سریع
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/customer/view/card" class="nav-link"><i class="far fa-credit-card"></i>چاپ
                            کارت</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/customer/view/group-card" class="nav-link"><i
                                class="fas fa-credit-card"></i>چاپ گروهی</a>
                    </li>
                    <li class="nav-divider"></li>
                    <li class="nav-title">
                        تحلیل
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/report/view/main" class="nav-link"><i class="icon-user-follow"></i>رفتار مشتریان</a>
                    </li>
                </ul>
            </li>
        @endif
        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-diamond"></i>مدیریت فروش</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/service/view/list">
                            <i class="fas fa-list"></i>
                            لیست محصولات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/service/view/add">
                            <i class="fas fa-plus"></i>
                            ثبت محصولات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/service/view/category" class="nav-link"><i class="fas fa-tag"></i>دسته
                            بندی ها</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/service/view/tag" class="nav-link"><i class="fas fa-tags"></i>نشانه ها</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/purchase/purchase" class="nav-link">
                            <i class="fas fa-shopping-cart"></i> فروش
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin-panel/purchase/history" class="nav-link">
                            <i class="fas fa-truck"></i>فاکتورها
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-building-o"></i>تنظیمات فروش</a>
                    </li>
                </ul>
            </li>
        @endif
        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i>بازاریابی و جشنواره</a>
                <ul class="nav-dropdown-items">

                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/xsenses"><i class="fa fa-building-o"></i>ساخت شرط</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/services_xsense "><i class="fa fa-building-o"></i>انتصاب
                            شرط و محصول
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/score_convertor/view/table">
                            <i class="fas fa-star-half-alt"></i>
                            لیست تبدیل امتیاز
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/score_convertor/view/form">
                            <i class="fas fa-star-half-alt"></i>
                            ایجاد تبدیل امتیاز
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="icon-user-follow"></i>نظر سنجی</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="icon-user-follow"></i>کوپن</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="icon-user-follow"></i>قرعه کشی</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="icon-user-follow"></i>کمپین</a>
                    </li>
                </ul>
            </li>
        @endif
        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))

            <ul class="nav-items">
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="icon-user-follow"></i>ارتباطات</a>
                </li>
            </ul>

        @endif


        <li class="nav-item">
            <a class="btn btn-success active btn-block " href="/admin-panel/purchase/purchase"><i
                    class="fas fa-shopping-cart ml-2"></i>خرید</a>
        </li>


    </ul>
</nav>
<button class="sidebar-minimizer brand-minimizer" type="button"></button>
