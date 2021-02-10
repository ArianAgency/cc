<button class="navbar-toggler mobile-sidebar-toggler d-lg-none ml-auto" type="button">
    <span class="navbar-toggler-icon"></span>
</button>
<a class="navbar-brand" href="#"></a>
<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
    <span class="navbar-toggler-icon"></span>
</button>

<ul class="nav navbar-nav d-md-down-none">
    <li class="nav-item px-3">
        <a class="nav-link" href="#">داشبورد</a>
    </li>
    <li class="nav-item px-3">
        <a class="nav-link" href="#">کاربران</a>
    </li>
    <li class="nav-item px-3">
        <a class="nav-link" href="#">تنظیمات</a>
    </li>
</ul>
<ul class="nav navbar-nav mr-auto">
    <li class="nav-item d-md-down-none">
        <a class="nav-link" href="#"><i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span></a>
    </li>
    <li class="nav-item d-md-down-none">
        <a class="nav-link" href="#"><i class="icon-list"></i></a>
    </li>
    <li class="nav-item d-md-down-none">
        <a class="nav-link" href="#"><i class="icon-location-pin"></i></a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <img src="admin/content/img/avatars/6.jpg" class="img-avatar" alt="<?php echo e(Auth::user()->name); ?>">
        </a>
        <div class="dropdown-menu dropdown-menu-left">
            <div class="dropdown-header text-center">
                <strong>حساب کاربری</strong>
            </div>
            <a class="dropdown-item" href="#"><i class="fa fa-bell-o"></i> بروزرسانی<span
                    class="badge badge-info">42</span></a>
            <a class="dropdown-item" href="#"><i class="fa fa-envelope-o"></i> پیام ها<span class="badge badge-success">42</span></a>
            <a class="dropdown-item" href="#"><i class="fa fa-tasks"></i> کارهای محول شده<span
                    class="badge badge-danger">42</span></a>
            <a class="dropdown-item" href="#"><i class="fa fa-comments"></i> نظرات<span
                    class="badge badge-warning">42</span></a>
            <div class="dropdown-header text-center">
                <strong>تنظیمات</strong>
            </div>
            <a class="dropdown-item" href="#"><i class="fa fa-user"></i> پروفایل</a>
            <a class="dropdown-item" href="#"><i class="fa fa-wrench"></i> تنظیمات</a>
            <a class="dropdown-item" href="#"><i class="fa fa-usd"></i> پرداختها<span
                    class="badge badge-secondary">42</span></a>
            <a class="dropdown-item" href="#"><i class="fa fa-file"></i> پروژه ها<span
                    class="badge badge-primary">42</span></a>
            <div class="divider"></div>
            <a class="dropdown-item" href="#"><i class="fa fa-shield"></i> بستن حساب کاربری </a>
            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"><i class="fa fa-lock"></i> خروج</a>
        </div>
    </li>
</ul>
<button class="navbar-toggler aside-menu-toggler" type="button">
    <span class="navbar-toggler-icon"></span>
</button>


<?php /**PATH C:\Club\cc\resources\views/admin/main/app-header.blade.php ENDPATH**/ ?>