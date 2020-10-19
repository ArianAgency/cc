<nav class="sidebar-nav">
    <ul class="nav">
        {{--        @if()--}}

        {{--        @endif--}}
        <li class="nav-divider">
        <li class="nav-item">
            <a class="nav-link" href="{{route('panel') }}"><i class="icon-speedometer"></i> داشبورد <span
                    class="badge badge-primary">جدید</span></a>
        </li>

        <li class="nav-divider"></li>

        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-diamond"></i> کسب وکار</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/business"><i class="fa fa-building-o"></i> ثبت نام
                            شده</a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="nav-divider"></li>

        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-diamond"></i> سرویس ها</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/service"><i class="fa fa-building-o"></i> ثبت
                            شده</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/xsenses"><i class="fa fa-building-o"></i>X-Sens </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin-panel/services_xsense "><i class="fa fa-building-o"></i>سرویس و
                            X-sens</a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="nav-divider"></li>

        @if(checkRolesAccessLevel(  Auth::user()->role_id ,2))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i> کاربران</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="/admin-panel/user" class="nav-link"><i class="icon-user-follow"></i> ثبت نام شده</a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="nav-divider"></li>

        @if(checkRolesAccessLevel(  Auth::user()->role_id ,6))
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i> مشتریان</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="/admin-panel/customer" class="nav-link"><i class="icon-user-follow"></i> ثبت نام
                            شده</a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="divider"></li>
        <li class="nav-title">
            تراکنش ها
        </li>
        <li class="nav-item">
            <a class="btn btn-success active btn-block " href="/admin-panel/purchase"><i
                    class="fas fa-shopping-cart ml-2"></i>خرید</a>
        </li>


    </ul>
</nav>
<button class="sidebar-minimizer brand-minimizer" type="button"></button>
