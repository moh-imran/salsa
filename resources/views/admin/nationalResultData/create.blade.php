@extends('admin.layouts.master')
@section('page-title')
    National Result Data
@endsection
@section('breadcrumbs')
    National result data
@endsection
@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/national-result-data')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">National Result Data Information</h5>
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
            {!! Form::open(['route' => 'admin.national-result-data.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            @include('admin.nationalResultData.partials.nationalResultDataForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection