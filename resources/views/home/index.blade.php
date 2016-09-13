@extends('layout.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">社区精华贴</h3>
        </div>
        <div class="panel-body">
            <ul class="row index-post">
                @foreach($posts as $post)
                <li class="col-md-6">


                    <div class="pull-left avatar">
                        <a href="{{ route('user.show',$post->user->id) }}">[{{ $post->user->name }}]</a>
                    </div>
                    <div class="meta">
                        <a href="{{ route('post.show',$post->id) }}">{{ $post->vote_count }}点赞 ⋅ {{ $post->comment_count }}回复</a>
                    </div>
                    <div class="post-title" style="white-space:nowrap;overflow: hidden;text-overflow: ellipsis;">
                        [{{ $post->category->name }}]
                        <a href="{{ route('post.show',$post->id) }}">{{ $post->title }}</a>
                    </div>

                </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop