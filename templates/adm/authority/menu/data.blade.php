@extends('adm.layout')

@section('content')
    <section class="content-header">
        <h1>
            菜单管理
            <small>@if(empty($info->id))创建@else编辑@endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admUrl('/') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="{{ admUrl('/menu') }}">菜单管理</a></li>
            <li class="active">@if(empty($info->id))创建@else编辑@endif菜单</li>
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
                    <form role="form" method="post" action="{{ admUrl('/menu') }}">
                        <input type="hidden" name="id" value="{{ $info->id or 0 }}">
                        <div class="box-body">

                            <div class="form-group">
                                <label>所属上级</label>
                                <select name="pid" class="form-control select2">
                                    <option value="0">ROOT</option>
                                    @foreach($menus as $menu)
                                        <option @if($menu['id'] == old('pid', $info['pid'])) selected="selected" @endif value="{{ $menu['id'] }}">
                                            {{ str_repeat('　　', $menu['lev']) }}
                                            {{ $menu['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>菜单名称</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name', $info->name) }}" placeholder="请输入菜单名称">
                            </div>

                            <div class="form-group">
                                <label>路由地址</label>
                                <select name="router_id" class="form-control select2">
                                    <option value="0">无路由</option>
                                    @foreach($routers as $router)
                                        <option @if($router->id == old('router_id', $info['router_id'])) selected="selected" @endif value="{{ $router->id }}">
                                            {{ $router->name }}
                                            ====>
                                            {{ admUrl($router->path, $router->query) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>排序</label>
                                <input type="text" class="form-control" name="sort"
                                       value="{{ old('sort', $info->sort) }}" placeholder="请输入排序值">
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