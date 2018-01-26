@extends('adm.layout')

@section('content')
    <section class="content-header">
        <h1>
            问题反馈
            <small>@if(empty($info->id))创建@else编辑@endif</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admUrl('/') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="{{ admUrl('/feedback') }}">问题反馈</a></li>
            <li class="active">@if(empty($info->id))创建@else编辑@endif</li>
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
                    <form role="form" method="post" action="{{ admUrl('/feedback') }}">
                        <input type="hidden" name="id" value="{{ $info->id or 0 }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>姓名</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name', $info->name) }}" placeholder="请输入姓名">
                            </div>
                            <div class="form-group">
                                <label>邮箱</label>
                                <input type="text" class="form-control" name="email"
                                       value="{{ old('email', $info->email) }}" placeholder="请输入邮箱">
                            </div>
                            <div class="form-group">
                                <label>反馈内容</label>
                                <textarea name="content" class="form-control" rows="4"
                                          placeholder="请输入反馈内容">{{ old('content', $info->content) }}</textarea>
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
@endsection