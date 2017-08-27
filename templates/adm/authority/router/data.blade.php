@extends('adm.layout')

@section('content')
    <section class="content-header">
        <h1>
            路由管理
            <small>@if(empty($info->id))创建@else编辑@endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admUrl('/') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="{{ admUrl('/router') }}">路由管理</a></li>
            <li class="active">@if(empty($info->id))创建@else编辑@endif路由</li>
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
                    <form role="form" method="post" action="{{ admUrl('/router') }}">
                        <input type="hidden" name="id" value="{{ $info->id or 0 }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>路由名称</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $info->name) }}" placeholder="请输入路由名称">
                            </div>
                            <div class="form-group">
                                <label>路由标识</label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug', $info->slug) }}" placeholder="请输入路由标识">
                            </div>
                            <div class="form-group">
                                <label>路由地址</label>
                                <input type="text" name="path" value="{{ old('path', $info->path) }}" class="form-control" placeholder="请输入路由地址">
                            </div>
                            <div class="form-group">
                                <label>查询参数</label>
                                <input type="text" name="query" value="{{ old('query', $info->query) }}" class="form-control" placeholder="请输入查询参数">
                                <small>如:slug=abc&keyword=张三</small>
                            </div>
                            <div class="form-group">
                                <label>启用状态</label>
                                <select name="status" class="form-control select2">
                                    <option value="T">启用</option>
                                    <option value="F" @if(old('status', $info->status) == 'F') selected="selected" @endif>禁用</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>排序</label>
                                <input type="text" name="sort" value="{{ old('sort', $info->sort) }}" class="form-control" placeholder="排序值">
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