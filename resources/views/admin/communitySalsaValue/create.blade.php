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

            {!! Form::open(['route' => 'admin.community-salsa-value.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                <label class="control-label col-lg-2">Community</label>
                <div class="col-lg-10">
                    {!! Form::select('community_code', $communities, null,  ['placeholder' => 'Select a Community', 'class' => 'form-control']) !!}
                </div>
            </div>
            @include('admin.communitySalsaValue.partials.communitySalsaValueForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection