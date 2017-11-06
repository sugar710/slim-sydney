@extends('adm.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>???</h3>

                        <p>文章数</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>???</h3>

                        <p>用户数</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>???</h3>

                        <p>订单数</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>????.??</h3>

                        <p>累计金额</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->

        <div class="row">

            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">最新日志</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>操作用户</th>
                                    <th>请求方式</th>
                                    <th>地址</th>
                                    <th>数据</th>
                                    <th>IP</th>
                                    <th>时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>
                                            @if(empty($log->user))
                                                --
                                            @else
                                                {{ $log->user->name }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $log->method }}
                                        </td>
                                        <td>
                                            {{ $log->path }}</td>
                                        <td>
                                            {{ $log->input }}
                                        </td>
                                        <td>
                                            {{ $log->ip }}
                                        </td>
                                        <td>
                                            {{ $log->updated_at }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </section>
            <section class="col-lg-5 connectedSortable">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">系统环境</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th colspan="4">基本信息</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>
                                        系　　统
                                    </td>
                                    <td>
                                        {{ PHP_OS }}
                                    </td>
                                    <td>
                                        运行方式
                                    </td>
                                    <td>
                                        {{ php_sapi_name() }}
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        PHP版本
                                    </td>
                                    <td>
                                        {{ PHP_VERSION }}
                                    </td>

                                    <td>
                                        域名
                                    </td>
                                    <td>
                                        {{ $_SERVER['HTTP_HOST'] }}
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        服务器IP
                                    </td>
                                    <td>
                                        {{ gethostbyname($_SERVER['SERVER_NAME']) }}
                                    </td>
                                    <td>
                                        客户端IP
                                    </td>
                                    <td>
                                        {{ $_SERVER['REMOTE_ADDR'] }}
                                    </td>
                                </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="4">限制</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Memory限制</td>
                                    <td>
                                        {{ ini_get('memory_limit') }}
                                    </td>
                                    <td>
                                        Upload限制
                                    </td>
                                    <td>
                                        {{ ini_get('upload_max_filesize') }}
                                    </td>
                                </tr>
                                <tr>

                                    <td>
                                        POST限制
                                    </td>
                                    <td>
                                        {{ ini_get('post_max_size') }}
                                    </td>
                                    <td>
                                        Execution超时
                                    </td>
                                    <td>
                                        {{ ini_get('max_execution_time') }}
                                    </td>
                                </tr>

                                <tr>

                                    <td>
                                        Input超时
                                    </td>
                                    <td>
                                        {{ ini_get('max_input_time') }}
                                    </td>
                                    <td>
                                        Socket超时
                                    </td>
                                    <td>
                                        {{ ini_get('default_socket_timeout') }}
                                    </td>
                                </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="4">组件</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>
                                        cURL组件
                                    </td>
                                    <td>
                                        {!! get_extension_funcs('curl') ? '<span class="label label-success">T</span>' : '<span class="label label-danger">F</span>'  !!}
                                    </td>
                                    <td>
                                        GD组件
                                    </td>
                                    <td>
                                        {!! get_extension_funcs('gd') ? '<span class="label label-success">T</span>' : '<span class="label label-danger">F</span>' !!}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        EXIF信息查看组件
                                    </td>
                                    <td>
                                        {!! get_extension_funcs('exif') ? '<span class="label label-success">T</span>' : '<span class="label label-danger">F</span>' !!}
                                    </td>
                                    <td>
                                        OpenSSL协议组件
                                    </td>
                                    <td>
                                        {!! get_extension_funcs('openssl') ? '<span class="label label-success">T</span>' : '<span class="label label-danger">F</span>' !!}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Mcrypt加密组件
                                    </td>
                                    <td>
                                        {!! get_extension_funcs('mcrypt') ? '<span class="label label-success">T</span>' : '<span class="label label-danger">F</span>' !!}
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
@endsection