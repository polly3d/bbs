@extends('layout.app')

@section('content')
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                {{ $user->name }}
            </div>
            <div class="panel-body">
                <p>帖子：{{ $user->posts->count() }}</p>
                <p>回复：{{ $user->comments->count() }}</p>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                与Ta有相关
            </div>
            <div class="panel-body">
                <ul>
                    <li>
                        <a href="">Ta发布的话题</a>
                    </li>
                    <li>
                        <a href="">Ta发表的回复</a>
                    </li>
                    <li>
                        <a href="">Ta赞过的话题</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                最近话题
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($userPosts as $post)
                    <li><a href="{{ route('post.show',$post->id) }}">{{ $post->title }} [{{ $post->category->name }}] {{ $post->vote_count }}点赞 ⋅ {{ $post->comment_count }}回复 {{ $post->created_at }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                最近回复
            </div>
            <div class="panel-body">
                <ul class="comment">
                    @foreach($userComments as $comment)
                    <li>
                        <a href="">{{ $comment->post->title }} {{ $comment->created_at }}</a>
                        <div class="media-body markdown-reply content-body">
                            {{ $comment->content }}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop