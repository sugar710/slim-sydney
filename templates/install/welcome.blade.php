@extends('install.install')

@section('install-content')
    <!-- /.login-logo -->
    <div class="install-box-body">
        <p class="install-box-msg">安装协议</p>
        <form action="{{ url('/install/agree') }}" method="post" id="fm-install">
            <div class="row">
                <div class="install-agreement-box">
                    1. 本项目只为测试gitflow开发流程<br/>
                    2. 本项目只为编写Slim测试案例;<br/>
                    3. 本项目只为测试Web安装流程;<br/>
                    4. 本项目只为自用slim脚手架;<br/>
                    5. 因安装或使用本项目所产生的所有影响与本人无关;<br/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="agreement" value="T"> 同意协议
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">下一步</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
@endsection

@section('install-js')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            $("#fm-install").submit(function () {
                var fm = $(this);
                axios.post(fm.attr("action"), fm.serialize()).then(function (res) {
                    if (res.data.status === 1) {
                        window.location.href = "{{ url('/install/env') }}";
                    } else {
                        toastr.error(res.data.info);
                    }
                });
                return false;
            });
        });
    </script>
@endsection