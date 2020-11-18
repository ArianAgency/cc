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
                    <li class="nav-divider"></li>
                    <li class="nav-title">
                        مدیریت شعب
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="icon-user-follow"></i>مدیریت شعب</a>
                    </li>
                    <li class="nav-divider"></li>
                    <li class="nav-title">
                        همکاری در فروش
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="icon-user-follow"></i>مدیریت همکاران</a>
                    </li>
                </ul>
            </li>
        @endif
        @if(checkRolesAccessLevel(  Auth::user()->role_id ,6))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i>مدیریت مشتریان</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="/admin-panel/customer" class="nav-link"><i class="icon-user-follow"></i> ثبت نام
                            شده</a>
                    </li>
                    <li class="nav-divider"></li>
                    <li class="nav-title">
                        تحلیل
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="icon-user-follow"></i>رفتار مشتریان</a>
                    </li>
                </ul>
            </li>
        @endif
        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-diamond"></i>مدیریت فروش</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-title">
                        مدیریت محصولات
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/service"><i class="fa fa-building-o"></i> ثبت
                            شده</a>
                    <li class="nav-title">
                        مدیریت فروش
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-building-o"></i> فروش</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-building-o"></i>فاکتورها </a>
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
                        <a class="nav-link" href="/admin-panel/services_xsense "><i class="fa fa-building-o"></i>انتصاب شرط و محصول</a>
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
            <a class="btn btn-success active btn-block " href="/admin-panel/purchase"><i
                    class="fas fa-shopping-cart ml-2"></i>خرید</a>
        </li>


    </ul>
</nav>
<button class="sidebar-minimizer brand-minimizer" type="button"></button>
