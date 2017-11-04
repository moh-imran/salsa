@extends('admin.layouts.master')
@section('page-title')
    Customer
@endsection
@section('breadcrumbs')
    Customer
@endsection
@section('css')
    <style>
        @media screen and (max-width:991px){
            .hide_991{
                display:none
            }
        }
    </style>
@endsection

@section('content')

        <div id="client" class="panel panel-flat">
            <div class="panel-heading">
                <div class="panel-body">
                    <div class="col-md-6 form-group">
                        <div class="row">
                            <div class="col-xs-5"><strong>Name</strong></div>
                            <div class="col-xs-7">{{$client->name}}</div>
                        </div>
                    </div>
                    <div class="col-md-6 hide_991 form-group">
                        <div class="row">
                            <div class="col-xs-5">&nbsp;</div>
                            <div class="col-xs-7">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="row">
                            <div class="col-xs-5"><strong>Email</strong></div>
                            <div class="col-xs-7">{{$client->email}}</div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class="row">
                            <div class="col-xs-5"><strong>Phone</strong></div>
                            <div class="col-xs-7">{{$client->phone}}</div>
                        </div>
                    </div>

                    @if($client->user_subscription->isNotEmpty())
                        <div class="col-md-6 form-group">
                            <div class="row">
                                <div class="col-xs-5"><strong>Subscription start</strong></div>
                                <div class="col-xs-7">{{date('d-m-Y', strtotime($client->user_subscription[0]->updated_at))}}</div>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div class="row">
                                <div class="col-xs-5"><strong>Subscription Ends</strong></div>
                                <div class="col-xs-7">{{date('d-m-Y', strtotime($client->user_subscription[0]->subscription_ends_at))}}</div>
                            </div>
                        </div>
                    @endif

                    @if($client->user_children)
                        @if($client->user_children->child_1_age)
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-xs-5"><strong>Child 1 Age</strong></div>
                                    <div class="col-xs-7">{{$client->user_children->child_1_age}}</div>
                                </div>
                            </div>
                        @endif
                        @if($client->user_children->child_2_age)
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-xs-5"><strong>Child 2 Age</strong></div>
                                    <div class="col-xs-7">{{$client->user_children->child_2_age}}</div>
                                </div>
                            </div>
                        @endif
                        @if($client->user_children->child_3_age)
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-xs-5"><strong>Child 3 Age</strong></div>
                                    <div class="col-xs-7">{{$client->user_children->child_3_age}}</div>
                                </div>
                            </div>
                        @endif
                        @if($client->user_children->child_4_age)
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-xs-5"><strong>Child 4 Age</strong></div>
                                    <div class="col-xs-7">{{$client->user_children->child_4_age}}</div>
                                </div>
                            </div>
                        @endif
                        @if($client->user_children->child_5_age)
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-xs-5"><strong>Child 5 Age</strong></div>
                                    <div class="col-xs-7">{{$client->user_children->child_5_age}}</div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="text-right" style="margin-bottom: 10px">
                        <a href="{{url('admin/client/'.$client->id.'/edit')}}" class="btn btn-primary">Edit Client</a>
                        <a href="{{url('admin/client')}}" class="btn btn-success">Back to Clients</a>
                    </div>


                </div>
            </div>
        </div>
@endsection