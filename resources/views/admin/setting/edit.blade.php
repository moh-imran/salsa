@extends('admin.layouts.master')
@section('page-title')
    Setting
@endsection
@section('breadcrumbs')
    Setting
@endsection
@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/setting')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Setting Information</h5>
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
            {!! Form::model($setting, ['route' => ['admin.setting.update', $setting->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
            @include('admin.setting.partials.settingForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection