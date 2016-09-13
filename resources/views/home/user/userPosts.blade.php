@extends('home.user.partials._userLayout')

@section('rightSection')
    <div class="panel panel-default">
        <div class="panel-heading">
            Ta发布的帖子
        </div>
        <div class="panel-body">
            <ul>
                @foreach($userPosts as $post)
                    <li><a href="{{ route('post.show',$post->id) }}">{{ $post->title }} [{{ $post->category->name }}] {{ $post->vote_count }}点赞 ⋅ {{ $post->comment_count }}回复 {{ $post->created_at }}</a></li>
                @endforeach
            </ul>
            {!! $userPosts->render() !!}
        </div>
    </div>
@stop