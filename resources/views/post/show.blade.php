@extends('layout.app')

@section('content')
    <div class="container">
        @include('layout.success')
        @include('layout.error')
        <h1>{{ $post->title }}</h1>
        <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('post.destroy',$post->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn btn-danger">Delete</button>
        </form>
        <p>
            {{ $post->content }}
        </p>
        <hr>
        <h3>评论：</h3>
        <ul>
            @foreach($comments as $comment)
                <li>
                    <div class="row">
                        <div class="col-md-11">
                            {{ $comment->content }}
                        </div>
                        <div class="col-md-1">
                            <form action="{{ route('comment.destroy',$comment->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger">Delete Comment</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{ $comments->links() }}
        <form action="{{ route('comment.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group" id="comment">
                <label for="">评论内容：</label>
                <textarea name="content" rows="10" class="form-control"></textarea>
            </div>
            <input type="text" name="post_id" value="{{ $post->id }}" hidden>
            <button class="btn btn-primary">Comment</button>
        </form>
    </div>
@stop