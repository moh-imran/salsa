@extends('admin.layouts.master')
@section('page-title')
    School Salsa Value
@endsection
@section('breadcrumbs')
    School salsa value
@endsection
@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/school-salsa-value')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">School Salsa Value Information</h5>
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
            {!! Form::open(['route' => 'admin.school-salsa-value.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            @include('admin.schoolSalsaValue.partials.schoolSalsaValueForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection