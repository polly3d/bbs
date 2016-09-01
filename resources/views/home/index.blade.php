@extends('layout.app')

@section('content')
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h1>Laravel Post</h1>
        <p>
            This is a laravel Post site.You can create edit and delete you post.You Also can comment the post.Enjoy youself!
        </p>
        <p>
            <a class="btn btn-lg btn-primary" href="{{ route('post.create') }}" role="button">Create Post</a>
        </p>
    </div>
    <div class="container">
        @include('layout.success')
        @include('layout.error')
        <ul>
            @foreach($posts as $post)
                <li>
                    <a href="{{ route('post.show',$post->id) }}">{{ $post->title }}</a>
                    <p>{{ $post->created_at }}</p>
                </li>
            @endforeach
        </ul>
        {{ $posts->links() }}
    </div>
@stop