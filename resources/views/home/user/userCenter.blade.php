@extends('home.user.partials._userLayout')

@section('rightSection')
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
                    {!! $comment->content !!}
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@stop
