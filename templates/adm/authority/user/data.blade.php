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
                                <label>角色</label>
                                <select name="roles[]" class="form-control select2" multiple="multiple">
                                    @foreach($roles as $role)
                                        <option @if(in_array($role->id, $info["roles"] ?: [])) selected="selected" @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
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

@section('js')
    {{ flash('action.error') }}
@endsection