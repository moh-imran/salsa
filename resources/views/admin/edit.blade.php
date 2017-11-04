@extends('admin.layouts.master')
@section('page-title')
    Admin
@endsection
@section('breadcrumbs')
    Admin
@endsection
@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Admin Information</h5>
            <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>

        <div class="panel-body">
            {!! Form::model($user, ['route' => ['admin.user.update', $user->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
            @include('admin.partials.adminForm')
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Update Admin <i class="icon-arrow-right14 position-right"></i></button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection