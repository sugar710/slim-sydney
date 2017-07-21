@extends('install.install')

@section('install-content')
    <!-- /.login-logo -->
    <div class="install-box-body">
        <p class="install-box-msg">环境检测</p>
        <form action="{{ url('/install/agree') }}" method="post" id="fm-install">
            <div class="row">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>项目</th>
                        <th>所需配置</th>
                        <th>当前配置</th>
                        <th>状态</th>
                    </tr>
                    @foreach($base as $item)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $item["name"] }}</td>
                        <td>
                            {{ $item["condition"] }}
                        </td>
                        <td>
                            {{ $item["current"] }}
                        </td>
                        <td>
                            @if($item["result"] === "T")
                                <span class="label label-success">Y</span>
                                @else
                                <span class="label label-danger">N</span>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <button type="button" class="btn btn-default btn-flat">上一步</button>
                    <button type="submit" class="btn btn-primary btn-flat">下一步</button>
                </div>
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