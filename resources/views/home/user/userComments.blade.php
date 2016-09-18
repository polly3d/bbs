@extends('home.user.partials._userLayout')

@section('rightSection')
    <div class="panel panel-default">
        <div class="panel-heading">
            Ta发表的回复
        </div>
        <div class="panel-body">
            <ul>
                @foreach($userComments as $comment)
                    <li>
                        <a href="">{{ $comment->post->title }} {{ $comment->created_at }}</a>
                        <div class="media-body markdown-reply content-body">
                            {!! $comment->content !!}
                        </div>
                    </li>
                @endforeach
            </ul>
            {!! $userComments->render() !!}
        </div>
    </div>
@stop