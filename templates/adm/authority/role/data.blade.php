@extends('adm.layout')

@section('content')
    <section class="content-header">
        <h1>
            角色管理
            <small>@if(empty($info->id))创建@else编辑@endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admUrl('/') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="{{ admUrl('/role') }}">角色管理</a></li>
            <li class="active">@if(empty($info->id))创建@else编辑@endif角色</li>
        </ol>
    </section>
    <section class="content">
        <!-- /.row -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                {{-- <div class="box-header with-border">
                     <h3 class="box-title">Quick Example</h3>
                 </div>--}}
                <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{ admUrl('/role') }}">
                        <input type="hidden" name="id" value="{{ $info->id or 0 }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>角色名称</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name', $info->name) }}" placeholder="请输入角色名称">
                            </div>
                            <div class="form-group">
                                <label>角色标识</label>
                                <input type="text" class="form-control" name="slug"
                                       value="{{ old('slug', $info->slug) }}" placeholder="请输入角色标识">
                            </div>
                            <div class="form-group">
                                <label>路由权限</label>
                                <div>
                                    <label style="font-weight:normal;">
                                        <input type="checkbox" name="checkall" /> 全选
                                    </label>
                                    @foreach($routers as $route)
                                        <label style="font-weight:normal;">
                                            <input @if(in_array($route->id, $info['routers'] ?: [])) checked="checked" @endif type="checkbox" name="routers[]" value="{{ $route->id }}">
                                            {{ $route->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ admAsset('plugins/iCheck/square/blue.css') }}">
@endsection
@section('js')
    {{ flash('action.error') }}
    <!-- iCheck -->
    <script src="{{ admAsset('plugins/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('input:checkbox').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            $("input:checkbox[name='checkall']").on("ifChecked", function(e) {
                $("input[name='routers[]']").iCheck('check');
            }).on("ifUnchecked", function(e) {
                $("input[name='routers[]']").iCheck('uncheck');
            });

        });
    </script>
@endsection