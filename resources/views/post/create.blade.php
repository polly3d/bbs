@extends('layout.app')

@section('content')
    @include('layout.success')
    @include('layout.error')
    <h1>Create Post</h1>
    <form action="{{ route('post.store') }}" method="post">
        @include('post.partials._form')
        <button class="btn btn-primary">create</button>
    </form>
@stop