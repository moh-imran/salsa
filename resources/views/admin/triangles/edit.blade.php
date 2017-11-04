@extends('admin.layouts.master')
@section('css')
    <style>
        .slider-toggle {display: none; visibility: hidden;}
        .slider-button,.slider-content,.slider {-webkit-transition: all 500ms ease-in-out;-moz-transition: all 500ms ease-in-out;-ms-transition: all 500ms ease-in-out;-o-transition: all 500ms ease-in-out;transition: all 500ms ease-in-out;}
        .slider-viewport {border: 1px solid #858585;display: block;height: 22px;overflow: hidden;width: 94px;position: relative;cursor: pointer;border-radius: 3px;color: #fff;float: left;-webkit-touch-callout:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;}
        .slider {height: 100%;position: relative;width: 200%;}
        .slider-button {background-size: 100%;background: #e6e6e6;background: -moz-linear-gradient(top, #e6e6e6 0%, #fff 99%);-webkit-box-shadow: 0px 0px 3px #000;box-shadow: 0px 0px 3px #000;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: absolute;display: block;top: 0;height: 20px;width: 30px;cursor: pointer;-webkit-border-radius: 2px;border-radius: 2px;}
        .slider-content {cursor: pointer;display: inline-block;float: left;height: 100%;width: 64px;font-size: 11px;font-weight: bold;text-transform: uppercase;top: 10px;}
        .slider-content span {text-shadow: rgba(0, 0, 0, 0.1) 1px 1px 2px;height: 100%;line-height: 20px;float: left;}
        .left {background: #3b679e;background-size: 100%;}
        .slider-viewport.light .left {background: #aebcbf;}
        .left span {margin: 0 10px;}
        .right {background: #fff;color: #595959;background-size: 100%;}
        .right span {float: right;margin: 0 2px;}
        .slider-toggle + .slider-viewport > .slider {left: -100%;}
        .slider-toggle + .slider-viewport .slider-button {left: 90px;}
        .slider-toggle + .slider-viewport .slider-content {width: 90px;}
        .slider-toggle + .slider-viewport .left {margin-left: 0;}
        .slider-toggle:checked + .slider-viewport > .slider {left: 0;}
        .slider-toggle:checked + .slider-viewport .slider-button {left: 62px;}
        .slider-toggle:checked + .slider-viewport .left {margin-left: 0; background-color: #228B22;}
    </style>
@endsection
@section('page-title')
    Edit Triangle
@endsection
@section('breadcrumbs')
    edit-triangle
@endsection
@section('content')
    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/triangles')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Color Code Information</h5>
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
            {!! Form::model($triangle, ['route' => ['admin.triangles.update', $triangle->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
            @include('admin.triangles.partials.triangleForm')
            {!! Form::close() !!}
        </div>
    </div>
@endsection