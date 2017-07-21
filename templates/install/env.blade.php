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
                                <span class="label label-success">T</span>
                                @else
                                <span class="label label-danger">F</span>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a href="{{ url('/install/welcome') }}" type="button" class="btn btn-default btn-flat">上一步</a>
                    <a href="{{ url('/install/database') }}" class="btn btn-primary btn-flat @if(!session('install.env', true)) disabled @endif">下一步</a>
                </div>
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
@endsection