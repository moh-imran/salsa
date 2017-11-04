@extends('admin.layouts.master')
@section('page-title')
    School Pupil Teacher Stat
@endsection
@section('breadcrumbs')
    School pupil teacher stat
@endsection
@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/school-pupil-teacher-stat')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">School Pupil Teacher Stat Information</h5>
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
            {!! Form::model($schoolPupilTeacherStat, ['route' => ['admin.school-pupil-teacher-stat.update', $schoolPupilTeacherStat->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
            <fieldset class="content-group">
            <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <label class="control-label col-lg-3">School</label>
                <div class="col-lg-9">
                    {!! Form::text('', $schoolPupilTeacherStat->school->title ,['class'=> 'form-control', 'disabled' => 'disabled']) !!}
                </div>
            </div>
            @include('admin.schoolPupilTeacherStat.partials.schoolPupilTeacherStatForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection