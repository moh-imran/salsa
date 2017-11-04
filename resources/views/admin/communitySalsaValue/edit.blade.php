@extends('admin.layouts.master')
@section('page-title')
    Community Salsa Value
@endsection
@section('breadcrumbs')
    Community salsa value
@endsection
@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/community-salsa-value')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Community Salsa Value Information</h5>
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

            {!! Form::model($communitySalsaValue, ['route' => ['admin.community-salsa-value.update', $communitySalsaValue->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
            <fieldset class="content-group">
            <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <label class="control-label col-lg-3">Community</label>
                <div class="col-lg-9">
                    {!! Form::text('community_title', null ,['class'=> 'form-control', 'disabled' => 'disabled']) !!}
                </div>
            </div>
            @include('admin.communitySalsaValue.partials.communitySalsaValueForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection