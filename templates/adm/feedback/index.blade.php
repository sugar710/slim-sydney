@extends('adm.layout')

@section('content')
    <section class="content-header">
        <h1>
            问题反馈
            {{--<small>角色管理</small>--}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admUrl('/') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li class="active">问题反馈</li>
        </ol>
    </section>
    <section class="content">
        <!-- /.row -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        {{--<h3 class="box-title">Responsive Hover Table</h3>--}}
                        <div class="box-actions">
                            <div class="btn-group pull-left" style="margin-right:10px;">
                                <button type="button" class="btn btn-default btn-sm">操作</button>
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="javascript:;" data-action="check-all">全部选中</a></li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:;" data-action="clear-all">全部清选</a></li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:;" data-href="{{ admUrl('/feedback/delete') }}"
                                           data-action="batch-del">批量删除</a></li>
                                </ul>
                            </div>
                            <a href="{{ admUrl('/feedback/data') }}" class="btn btn-default btn-sm pull-left"
                               style="margin-right:10px;">我要反馈</a>
                            <a data-href="{{ admUrl('/feedback/delete') }}" class="btn btn-danger btn-sm pull-left"
                               data-action="batch-del">删除</a>
                        </div>
                        <div class="box-tools clearfix">
                            <form action="{{ admUrl('/feedback') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 180px;">
                                    <input type="text" name="keyword" value="{{ $req["keyword"] or '' }}"
                                           class="form-control pull-right" placeholder="搜索">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{ admUrl('/feedback') }}" class="btn btn-default">全部</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>姓名</th>
                                <th>邮箱</th>
                                <th>反馈内容</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                            </tr>
                            @foreach($list as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->email }}
                                    </td>
                                    <td>{{ $item->content }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                </tr>
                            @endforeach
                            @if($list->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">
                                        暂无数据
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {!! $page->render() !!}
                    </div>
                </div>
                <!-- /.box -->

            </div>
        </div>
    </section>
@endsection