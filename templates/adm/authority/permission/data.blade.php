@extends('adm.layout')

@section('content')
    <section class="content-header">
        <h1>
            权限管理
            <small>@if(empty($info))创建@else编辑@endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Simple</li>
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
                    <form role="form" method="post" action="{{ admUrl('/permission') }}">
                        <input type="hidden" name="id" value="{{ $info->id or 0 }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>权限名称</label>
                                <input type="text" class="form-control" name="name" value="{{ $info->name or '' }}" placeholder="请输入权限名称">
                            </div>
                            <div class="form-group">
                                <label>权限标识</label>
                                <input type="text" class="form-control" name="slug" value="{{ $info->slug or '' }}" placeholder="请输入权限标识">
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