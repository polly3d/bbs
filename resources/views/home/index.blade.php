@extends('layout.app')

@section('content')
    <div class="container">
        <ul>
            @foreach($posts as $post)
                <li>
                    <a href="{{ route('post.show',$post->id) }}">{{ $post->title }}</a>
                    <p>{{ $post->created_at }}</p>
                </li>
            @endforeach
        </ul>
    </div>
@stop