<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="/admin/content/img/favicon.png">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Icons -->
    <link href="/admin/content/css/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="/admin/content/css/font-awesome/css/fontawesome.css" rel="stylesheet">
    <link href="/admin/content/css/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="/admin/content/css/style.css" rel="stylesheet">

    <link href="/admin/content/css/custom.css" rel="stylesheet"/>
    <!-- Styles required by this views -->

    <link type="text/css" rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">


</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden" >
<header class="app-header navbar">

    <?php echo $__env->yieldContent('app-header'); ?>
</header>

<div class="app-body" id="app">
    <div class="sidebar">

        <?php echo $__env->yieldContent('app-body-sidebar'); ?>
    </div>

    <!-- Main content -->
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">خانه</li>
            <li class="breadcrumb-item"><a href="#">ادمین</a></li>
            <li class="breadcrumb-item active">داشبورد</li>

            <!-- Breadcrumb Menu-->
            <li class="breadcrumb-menu d-md-down-none">
                <div class="btn-group" role="group" aria-label="دکمه های گروهی">
                    <a class="btn" href="#"><i class="icon-speech"></i></a>
                    <a class="btn" href="./"><i class="icon-graph"></i> &nbsp;داشبود</a>
                    <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;تنظیمات</a>
                </div>
            </li>
        </ol>
        <?php echo $__env->yieldContent('app-body-main-content'); ?>
    </main>

    <aside class="aside-menu">
        <?php echo $__env->yieldContent('app-body-aside-menu'); ?>

    </aside>

</div>

<footer class="app-footer">

    <span>کلیه حقوق مال آرین © 2020 .</span>

</footer>

<!-- Bootstrap and necessary plugins -->









<!-- Plugins and scripts required by all views -->


<!-- main scripts -->


<script src="<?php echo e(asset('admin/content/js/jquery.min.js')); ?>" ></script>











<script src="<?php echo e(asset('js/main.js')); ?>" ></script>
<script src="<?php echo e(asset('js/app.js')); ?>" ></script>


</body>
</html>

<?php /**PATH C:\Club\cc\resources\views/layouts/coreui/admin.blade.php ENDPATH**/ ?>