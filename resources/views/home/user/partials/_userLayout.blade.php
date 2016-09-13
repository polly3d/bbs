@extends('layout.app')

@section('content')
    @include('home.user.partials._siderBar')
    <div class="col-md-9">
        @yield('rightSection')
    </div>
@stop