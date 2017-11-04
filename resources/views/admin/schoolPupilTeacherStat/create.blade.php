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
            {!! Form::open(['route' => 'admin.school-pupil-teacher-stat.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                <label class="control-label col-lg-2">School</label>
                <div class="col-lg-10">
                    {!! Form::select('school_code', $schools, null, ['placeholder' => 'Select a school', 'class' => 'form-control']) !!}
                </div>
            </div>
            @include('admin.schoolPupilTeacherStat.partials.schoolPupilTeacherStatForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection