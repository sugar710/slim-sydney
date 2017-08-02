@extends('install.install')

@section('install-content')
    <!-- /.login-logo -->
    <div class="install-box-body">
        <p class="install-box-msg">数据库配置</p>
        <form action="{{ url('/install/database/verify') }}" method="post" id="fm-install">
            <div class="form-group">
                <input type="text" class="form-control" name="dbhost" placeholder="数据库地址">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="dbname" placeholder="数据库名称">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="dbuser" placeholder="数据库用户">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="dbpassword" placeholder="数据库密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a href="{{ url('/install/env') }}" type="button" class="btn btn-default btn-flat">上一步</a>
                    <button type="submit" class="btn btn-primary btn-flat">下一步</button>
                </div>
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
@endsection
@section('install-js')
    <script type="text/javascript">
        $(function () {
            $("#fm-install").submit(function (e) {
                var fm = $(this);
                e.preventDefault();
                axios.post(fm.attr("action"), fm.serialize()).then(function (res) {
                    var data = res.data;
                    if (data.status === 1) {
                        window.location.href = "{{ url('install/account') }}";
                    } else {
                        toastr.error(data.info);
                    }
                }).catch(function (err) {
                    toastr.error(err);
                });
                return false;
            });
        });
    </script>
@endsection