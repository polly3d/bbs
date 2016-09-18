@extends('layout.app')

@section('content')
    @include('layout.success')
    <div class="col-md-9">
        <div class="panel panel-default post">
            <div class="panel-heading">
                <h1 class="panel-title">{{ $post->title }}</h1>
                <div class="post-info">
                    <a href="{{ route('category',$post->category_id) }}">[{{ $post->category->name }}]</a>
                    <a href="{{ route('user.show',$post->user->id) }}">{{ $post->user->name }}</a>
                    <span>{{ $post->created_at }}</span> ⋅ <span>{{ $post->click_count }}阅读</span>
                    @if(Auth::check() && $post->user_id == Auth::id())
                        <a href="{{ route('post.edit',$post->id) }}">修改</a>
                        <a href="#" data-toggle="modal" data-target="#deleteModal">
                           删除
                        </a>
                        @include('home.post.partial._delete_confirm')
                        </form>
                    @endif
                </div>
            </div>
            <div class="panel-body">
                <div class="markdown-body" id="emojify">
                    {!! $post->content !!}
                </div>
                <div class="vote-btn">
                    <a href="{{ route('votePost',$post->id) }}" class="btn btn-primary btn-lg">
                        <i class="glyphicon glyphicon-thumbs-up"></i>
                        点赞
                    </a>
                </div>
                 @if($post->isExcellent())
                    <p class="red">本贴已经被设置为精华</p>
                @endif

                @if(Auth::id() == 1)
                    <div class="pull-right">
                        <span>管理员操作：</span>
                        <span>
                            <a href="{{ route('toExcellent',$post->id) }}">
                                @if($post->isExcellent())
                                取消设为精华
                                @else
                                设为精华
                                @endif
                            </a>
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">点赞的人</h3>
            </div>
            <div class="panel-body">
                @foreach($post->votes as $vote)
                    <a href="{{ route('user.show',$vote->user->id) }}">{{ $vote->user->name}}</a>
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
                        <span>点赞数：{{ $comment->votes()->count() }}</span>
                        <span>
                            <a href="{{ route('voteComment',$comment->id) }}">
                                <i class="glyphicon glyphicon-thumbs-up"></i>
                            </a>
                        </span>
                        <div class="media-body markdown-reply content-body">
                            {!! $comment->content !!}
                        </div>
                    </li>
                    @endforeach
                </ul>

            </div>
        </div>

        <div class="comment-box">
            <form action="{{ route('comment.store') }}" method="post">
                <div class="form-group">
                    <textarea class="form-control" name="content_md" id="" cols="30" rows="10"></textarea>
                </div>
                <input type="text" value="{{ $post->id }}" name="post_id" hidden>
                {{ csrf_field() }}
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