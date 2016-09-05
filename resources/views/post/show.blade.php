@extends('layout.app')

@section('content')
    <div class="container">
        @include('layout.success')
        @include('layout.error')
        <h1>{{ $post->title }}</h1>
        @if(Auth::check() && Auth::user()->id == $post->user_id)
            <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('post.destroy',$post->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger">Delete</button>
            </form>
        @endif

        <p>
            <span>{{ $post->user->name }}</span>
            <span>crated_at:{{ $post->created_at }}</span>
        </p>
        <p>
            {{ $post->content }}
        </p>
        <hr>
        <h3>评论：</h3>
        <div class="row">
            <ul class="col-md-12">
                @foreach($comments as $comment)
                    <li>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    {{ $comment->content }}
                                </p>
                                <div>
                                    comment by: {{ $comment->user->name }}
                                    @if(Auth::check() && Auth::user()->id == $comment->user_id)
                                        <form action="{{ route('comment.destroy',$comment->id) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger">Delete Comment</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
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