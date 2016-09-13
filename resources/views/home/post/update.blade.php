@extends('layout.app')

@section('content')
@include('layout.success')
@include('layout.error')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>修改帖子</h3>
    </div>
    <div class="panel-body">
        <form action="{{ route('post.update',$id) }}" method="post">
            @include('home.post.partial._form')
            {{ method_field('PUT') }}
            <button class="btn btn-primary">提交</button>
        </form>
    </div>
</div>
@stop


@section('script')
<script>
    $('#category').val({{ $category_id or old('content_md') }})
</script>
@stop