@extends('admin.layouts.master')
@section('page-title')
    Community
@endsection
@section('breadcrumbs')
    Community
@endsection
@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/community')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Community Information</h5>
            <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel-body">
            {!! Form::open(['route' => 'admin.community.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            @include('admin.community.partials.communityForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection