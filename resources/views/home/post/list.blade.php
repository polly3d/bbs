@extends('layout.app')

@section('content')
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="list-inline post-filter">
                    {!! $nav !!}
                </ul>
            </div>
            <div class="panel-body">
                <ul class="row post-list">
                    @foreach($posts as $post)
                    <li>
                        <div class="col-md-2">
                            <p class="text-center">{{ $post->vote_count }}</p>
                            <p class="text-center">{{ $post->comment_count }}/{{ $post->click_count }}</p>
                        </div>
                        <div class="col-md-8">
                            [{{ $post->category->name }}]<a href="{{ route('post.show',$post->id) }}">{{ $post->title }}</a>
                        </div>
                        <div class="col-md-2">
                            {{ $post->created_at }}
                        </div>
                    </li>
                    @endforeach
                </ul>
                {!! $posts->render() !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <a href="{{ route('post.create') }}" class="btn btn-primary">新建帖子</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    活跃用户（名人堂）
                </div>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($activeUsers as $user)
                        <li><a href="{{ route('user.show',$user->id) }}">{{ $user->name }}</a></li>
                    @endforeach

                </ul>
            </div>
        </div>

        <div class="panel panel-default">
             <div class="panel panel-default">
                <div class="panel-heading text-center">
                    热门话题
                </div>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($hotPosts as $post)
                        <li class="text-no-wrap"><a href="{{ route('post.show',$post->id) }}">{{ $post->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop