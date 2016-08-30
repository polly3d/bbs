@extends('layout.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p>
            {{ $post->content }}
        </p>
        <hr>
        <h3>评论：</h3>
        <ul>
            @foreach($comments as $comment)
                <li>
                    {{ $comment->content }}
                </li>
            @endforeach
        </ul>
    </div>
@stop