<!DOCTYPE html>
<html lang="fa"  dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bootstrap 4 Admin Template">
    <meta name="author" content="Lukasz Holeczek">
    <meta name="keyword" content="Bootstrap 4 Admin Template">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->
    <title>Bootstrap 4 Admin Template</title>
    <!-- Icons -->
    <link href="/admin/content/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/admin/content/css/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="/admin/content/css/style.css" rel="stylesheet">
    <link href="/admin/content/css/custom.css" rel="stylesheet" />
    <!-- Styles required by this views -->
</head>

<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body p-4">
                    <h1>ثبت نام</h1>
                    <p class="text-muted">حساب کاربری خود را ایجاد نمایید</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="نام کاربری">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" class="form-control" placeholder="ایمیل">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="رمز عبور">
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="تکرار رمز عبور">
                    </div>

                    <button type="button" class="btn btn-block btn-success">ساخت حساب کاربری</button>


                    <button type="button" class="btn btn-primary btn-sm w-100 mt-2 " onclick="window.location.href='{{url('/login') }}'">قبلا ثبت نام کردم</button>

                </div>



                <div class="card-body ">
{{--                    <div class="row">--}}
{{--                        <div class="col-6">--}}
{{--                            <button class="btn btn-block btn-facebook" type="button">--}}
{{--                                <span>فیس بوک</span>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="col-6">--}}
{{--                            <button class="btn btn-block btn-twitter" type="button">--}}
{{--                                <span>توییتر</span>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap and necessary plugins -->
<script src="/admin/content/js/jquery.min.js"></script>
<script src="/admin/content/js/popper.min.js"></script>
<script src="/admin/content/js/bootstrap.min.js"></script>

</body>
</html>
