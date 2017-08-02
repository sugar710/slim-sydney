@extends('install.install')

@section('install-content')
    <!-- /.login-logo -->
    <div class="install-box-body">
        <p class="install-box-msg">管理员账号</p>
        <form action="{{ url('/install/account/verify') }}" method="post" id="fm-install">

            <div class="form-group">
                <input type="text" class="form-control" name="admin_username" placeholder="管理员账号">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="admin_password" placeholder="管理员密码">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="admin_name" placeholder="昵称">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="admin_email" placeholder="邮箱地址">
            </div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a href="{{ url('/install/database') }}" type="button" class="btn btn-default btn-flat">上一步</a>
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
                        window.location.href = "{{ url('install/ready/go') }}";
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