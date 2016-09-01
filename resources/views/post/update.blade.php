@extends('layout.app')

@section('content')
    @include('layout.success')
    @include('layout.error')
    <h1>Edit Post</h1>
    <form action="{{ route('post.update',$id) }}" method="post">
        @include('post.partials._form')
        {{ method_field('PUT') }}
        <button class="btn btn-primary">Update Post</button>
    </form>
@stop