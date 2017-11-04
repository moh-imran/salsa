@extends('admin.layouts.master')
@section('page-title')
    Customer
@endsection
@section('breadcrumbs')
    Customer
@endsection
@section('content')

    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/client')}}" class="btn btn-success">Back</a></div>
    <div class="panel panel-flat" id="customer_edit">
        <div class="panel-heading">
            <h5 class="panel-title text-center">Edit Customer</h5>
            <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
        @if (count($errors) > 0)
            <div class="alert alert-danger col-xs-6 col-md-offset-3">
                <ul> 
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel-body">
            <!--{!! Form::model($client, ['route' => ['admin.client.update', $client->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}-->
            @include('admin.client.partials.clientForm')
<!--            {!! Form::close() !!}-->
        </div>
    </div>
    <script src="{{asset('js/user/vuejs/customer_edit.js')}}"></script>
@endsection