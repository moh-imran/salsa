@extends('admin.layouts.master')
@section('page-title')
    Dashboard
@endsection
@section('breadcrumbs')
    Dashboard
@endsection
@section('content')
    <!-- Dashboard content -->
    <div class="row" id="app">
        <div class="col-lg-8">

            <!-- Quick stats boxes -->
            <div class="row">

                <div class="col-lg-4">

                    <!-- Current server load -->
                    <div class="panel bg-pink-400">
                        <div class="panel-body">

                            @if (!stristr(PHP_OS, 'win'))
                                <h3 class="no-margin"><?php $avgLoad = sys_getloadavg(); echo $avgLoad[0]; ?>%</h3>
                                <br/><strong>Current Server Load Real time</strong><br/><br/>
                                <div class="text-bolder"><strong><?php $avgLoad = sys_getloadavg(); echo $avgLoad[1]; ?>% Average</strong></div>
                            @else
                                <h3 class="no-margin">0%</h3>
                                <br/><strong>Current Server Load Real time</strong><br/><br/>
                                <div class="text-bolder"><strong>0% Average</strong></div>
                            @endif
                            <br/>
                        </div>

                        <div id="server-load"></div>
                    </div>


                </div>
                <div class="col-lg-6">
                </div>


            </div>
            <!-- /quick stats boxes -->


        </div>

        <div class="col-lg-4">

        </div>
    </div>

        <!-- /dashboard content -->

        {{--@include('dashboard-widgets')--}}
        <script type="text/javascript" src="{{ asset('/js/admin/dashboard.js') }}"></script>
@endsection
