@extends('admin.layouts.master')
@section('page-title')
    Grade9 Data
@endsection
@section('breadcrumbs')
    Grade9 data
@endsection
@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/grade9data')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Grade9 Data Information</h5>
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
            {!! Form::open(['route' => 'admin.grade9data.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            @include('admin.grade9data.partials.grade9dataForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection