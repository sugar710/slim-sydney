@extends('install.install')

@section('install-content')
    <!-- /.login-logo -->
    <div class="install-box-body">
        <p class="install-box-msg">安装进行中...</p>
        <hr style="margin-top:0;">
        <form action="javascript:;" method="post" id="fm-install">

            <div id="msg-list" class="row install-message">

            </div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    {{--<a href="{{ url('/install/database') }}" type="button" class="btn btn-default btn-flat">上一步</a>--}}
                    <a href="{{ url('/admin/login') }}" class="btn btn-primary btn-flat">完成</a>
                </div>
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
@endsection
@section('install-js')
    <script type="text/javascript">
        function showMsg(content, status) {
            var list = $("#msg-list"), cls = 'text-info', tip = '';
            switch(status) {
                case 'ok':
                    tip = "成功";
                    cls = "text-success";
                    break;
                case 'error':
                    tip = "失败";
                    cls = "text-danger";
                    break;
            }
            list.append("<p>"+content+" <span class='"+cls+"'>"+tip+"</span></p>");
            list.scrollTop(list.scrollTop() + 30);
        }
    </script>
@endsection