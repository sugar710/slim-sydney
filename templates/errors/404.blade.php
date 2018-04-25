<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SlimLTE 2 | 500 Error</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ admAsset('bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admAsset('dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('slimLte/app.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left:0;">
        <!-- Main content -->
        <section class="content" style="padding-top:120px;">
            <div class="error-page">
                <h2 class="headline text-yellow">404</h2>
                <div class="error-content" style="padding-top:15px;">
                    <h3><i class="fa fa-warning text-yellow"></i> 哎呀！ 找不到网页.</h3>
                    <p>
                        请仔细检查访问网址是否正确.
                    </p>
                    <p>
                        <a href="javascript:;" onclick="history.back()" class="btn btn-link">
                            <i class="fa fa-arrow-left"></i>
                            返回
                        </a>
                    </p>
                </div>
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
</body>
</html>
