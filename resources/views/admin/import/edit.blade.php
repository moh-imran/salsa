@extends('admin.layouts.master')

@section('page-title')
    Edit {{$file->title_key}} File Information
@endsection
@section('breadcrumbs')
    edit-file
@endsection
@section('css')
    <style>
        .bold {font-weight: bold;}
        .mb-20 {margin-bottom: 20px;}
    </style>
@endsection

@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/import/community')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">{{$file->title_key}}</h5>
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

            {!! Form::model($file, ['route' => ['update-file', $file->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
            @include('admin.import.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection