@extends('admin::layouts.main')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">专题列表</h3>

                    <div class="btn-group pull-right">
                        <a href="{{ route('admin::topics.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>


                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>专题名</th>
                            <th>标签</th>
                            <th>会场数</th>
                            <th>状态</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($topics as $topic)
                            <tr>
                                <td>{{ $topic->id }}</td>
                                <td>{{ $topic->name }}</td>
                                <td>{{ $topic->label }}</td>
                                <td>{{$topic->meets->count()}}</td>
                                <td >@if($topic->status == 1 )<span class="btn btn-primary btn-sm">启动</span> @else <span class="btn btn-danger btn-sm">关闭</span> @endif </td>
                                <td>{{ $topic->created_at }}</td>
                                <td>{{ $topic->updated_at }}</td>
                                <td>
                                    <a href="{{ route('admin::topics.edit', $topic->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-id="{{ $topic->id }}" class="grid-row-delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{ $topics->links('admin::widgets.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::topics.index')])
@endsection