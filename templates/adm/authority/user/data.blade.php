@extends('adm.layout')

@section('content')
    <section class="content-header">
        <h1>
            用户管理
            <small>@if(empty($info->id))创建@else编辑@endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admUrl('/') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="{{ admUrl('/user') }}">用户管理</a></li>
            <li class="active">@if(empty($info->id))创建@else编辑@endif用户</li>
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
                    <form role="form" method="post" action="{{ admUrl('/user') }}">
                        <input type="hidden" name="id" value="{{ $info->id or 0 }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>账号</label>
                                <input type="text" class="form-control" name="username"
                                       value="{{ old('username', $info->username) }}" placeholder="请输入登录账号">
                            </div>

                            <div class="form-group">
                                <label>密码</label>
                                <input type="password" class="form-control" name="password"
                                       value="{{ old('password', '') }}" placeholder="请输入账号密码">
                            </div>

                            <div class="form-group">
                                <label>邮箱</label>
                                <input type="text" name="email" value="{{ old('email', $info->email) }}"
                                       class="form-control" placeholder="请输入邮箱地址">
                            </div>

                            <div class="form-group">
                                <label>昵称</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name', $info->name) }}" placeholder="请输入昵称">
                            </div>
                            <div class="form-group">
                                <label>头像</label>
                                <div>
                                    <input type="hidden" name="avatar" value="{{ $info->avatar or '' }}"/>
                                    @if(!empty($info['avatar']))
                                        <img src="{{ iAsset($info['avatar']) }}" style="height:125px;margin-bottom:5px;"
                                             class="upload-view">
                                    @else
                                        <img src="{{ iAsset($info['avatar']) }}"
                                             style="height:125px;margin-bottom:5px;display:none;"
                                             class="upload-view">
                                    @endif
                                    <input type="file" data-action="upload"
                                           data-upload-url="{{ url('public/upload') }}">
                                </div>

                            </div>
                            <div class="form-group">
                                <label>角色</label>
                                <div>
                                    @foreach($roles as $role)
                                        <label style="font-weight:normal;">
                                            <input @if(in_array($role->id, old("roles", $info["roles"] ?: []))) checked="checked"
                                                   @endif type="checkbox" name="roles[]" value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label>路由</label>
                                <div>
                                    @foreach($routers as $router)
                                        <label style="font-weight:normal;">
                                            <input @if(in_array($router->id, old('routers', $info['routers'] ?: []))) checked="checked"
                                                   @endif type="checkbox" name="routers[]" value="{{ $router->id }}">
                                            {{ $router->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label>锁定状态</label>
                                <select name="is_lock" class="form-control select2">
                                    <option value="F">正常</option>
                                    <option value="T"
                                            @if(old('status', $info->status) == 'T') selected="selected" @endif>锁定
                                    </option>
                                </select>
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
    <!-- iCheck -->
    <script src="{{ admAsset('plugins/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('input:checkbox').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            $("input[data-action='upload']").on("uploadComplete", function (e, status, data) {
                $("input[name='avatar']").val(data.file);
                $("img.upload-view").attr("src", data.view).show();
            });
        });
    </script>
@endsection