@extends('layout.app')

@section('content')
    @include('layout.success')
    @include('layout.error')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>新建帖子</h3>
        </div>
        <div class="panel-body">
            <form action="{{ route('post.store') }}" method="post">
                <div class="form-group">
                    <label for="">标题：</label>
                    <input name="title" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">分类：</label>
                    <select name="category_id" class="form-control">
                        <option value="">请选择分类</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">内容：</label>
                    <textarea name="content_md" class="form-control" cols="30" rows="10"></textarea>
                </div>
                {{ csrf_field() }}
                <button class="btn btn-primary">新建</button>
            </form>
        </div>
    </div>
@stop