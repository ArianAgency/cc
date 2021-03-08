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
    <title>@yield('title')</title>
    <!-- Icons -->
    <link href="/admin/content/css/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="/admin/content/css/font-awesome/css/fontawesome.css" rel="stylesheet">
    <link href="/admin/content/css/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <link href="/css/pos.css" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="/admin/content/css/style.css" rel="stylesheet">

    <link href="/admin/content/css/custom.css" rel="stylesheet"/>
    <!-- Styles required by this views -->

    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">



</head>

<body class="app  sidebar-fixed aside-menu-fixed aside-menu-hidden" >
<div id="app">


    @yield('main-app-body')


</div>
<footer class="app-footer fixed-bottom" id="pos-footer">

    <span>کلیه حقوق مال آرین © 2020 .</span>

</footer>

<!-- Bootstrap and necessary plugins -->
{{--<script src="public/admin/content/js/jquery.min.js"></script>--}}
{{--<script src="public/admin/content/js/popper.min.js"></script>--}}
{{--<script src="public/admin/content/js/bootstrap.min.js"></script>--}}
{{--<script src="public/admin/content/js/pace.min.js"></script>--}}
{{--<script src="public/admin/content/js/Chart.min.js"></script>--}}
{{--<script src="public/admin/content/js/app.js"></script>--}}
{{--<script src="/admin/content/js/app.js"></script>--}}


<!-- Plugins and scripts required by all views -->
{{--<script src="/admin/content/js/Chart.min.js"></script>--}}

<!-- main scripts -->

{{--<script src="/admin/content/js/app.js"></script>--}}
<script src="{{ asset('admin/content/js/jquery.min.js') }}" ></script>
{{--<script src="{{ asset('admin/content/js/popper.min.js') }}" ></script>--}}
{{--<script src="{{ asset('admin/content/js/bootstrap.min.js') }}" ></script>--}}
{{--<script src="{{ asset('admin/content/js/pace.min.js') }}" ></script>--}}
{{--<script src="{{ asset('admin/content/js/Chart.min.js') }}" ></script>--}}
{{--<script src="{{ asset('admin/content/js/app.js') }}" ></script>--}}

{{--<script src="{{ asset('js/jquery.min.js') }}" ></script>--}}
{{--<script src="{{ asset('js/popper.min.js') }}" ></script>--}}
{{--<script src="{{ asset('js/bootstrap.min.js') }}" ></script>--}}
{{--<script src="{{ asset('js/pace.min.js') }}" ></script>--}}
{{--<script src="{{ asset('js/Chart.min.js') }}" ></script>--}}
<script src="{{ asset('js/main.js') }}" ></script>
<script src="{{ asset('js/app.js') }}" ></script>
{{--<script src="/public/admin/content/js/views/main.js"></script>--}}

</body>
</html>

