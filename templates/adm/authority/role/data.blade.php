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
                                <input type="text" class="form-control" name="name" value="{{ old('name', $info->name) }}" placeholder="请输入角色名称">
                            </div>
                            <div class="form-group">
                                <label>角色标识</label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug', $info->slug) }}" placeholder="请输入角色标识">
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