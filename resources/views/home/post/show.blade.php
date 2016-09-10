@extends('layout.app')

@section('content')
    <div class="col-md-9">
        <div class="panel panel-default post">
            <div class="panel-heading">
                <h1 class="panel-title">{{ $post->title }}</h1>
                <div class="post-info">
                    <a href="">[{{ $post->category->name }}]</a>
                    <a href="{{ route('user.show',$post->user->id) }}">{{ $post->user->name }}</a>
                    <span>{{ $post->created_at }}</span> ⋅ <span>{{ $post->click_count }}阅读</span>
                </div>
            </div>
            <div class="panel-body">
                <div class="markdown-body" id="emojify">
                    {{ $post->content }}
                </div>
                <div class="vote-btn">
                    <a href="" class="btn btn-primary btn-lg">
                        <i class="glyphicon glyphicon-thumbs-up"></i>
                        点赞
                    </a>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">点赞的人</h3>
            </div>
            <div class="panel-body">
                @foreach($post->votes as $vote)
                    <a href="">{{ $vote->user->name}}</a>
                    <span>&nbsp;&nbsp;</span>
                @endforeach
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">回复数量：{{ $post->comment_count }}</h3>
            </div>
            <div class="panel-body">
                <ul class="comment">
                    @foreach($post->comments as $comment)
                    <li>
                        <h4><a href="{{ route('user.show',$comment->user->id) }}">{{ $comment->user->name }}</a></h4>
                        <span>#{{ $loop->index }} {{ $comment->created_at }}</span>
                        <div class="media-body markdown-reply content-body">
                            {{ $comment->content }}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="comment-box">
            <form action="">
                <div class="form-group">
                    <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
                </div>
                <button class="btn btn-primary">
                    回复
                </button>
            </form>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <span class="">作者：{{ $post->user->name }}</span>
            </div>
            <div class="panel-body">
                作者好懒，暂时没有什么东西
                Email:{{ $post->user->email }}
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <span class="">{{ $post->user->name }} 的其他话题</span>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($post->user->posts as $post)
                        <li class="text-no-wrap"><a href="{{ route('post.show',$post->id) }}">{{ $post->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <span class="">分类下的其他主题</span>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($categoryPosts as $post)
                        <li class="text-no-wrap"><a href="{{ route('post.show',$post->id) }}">{{ $post->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop