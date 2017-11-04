@extends('admin.layouts.master')
@section('css')
    <style>
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            padding: 5px;
        }
        #import .btn{ min-width: 80px;}
        .url a{
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 450px;
            display: block;
            overflow: hidden;
        }
        #success-msg, #error-msg {display: none;}
    </style>
@endsection
@section('page-title')
    Import Data
@endsection
@section('breadcrumbs')
    Import data
@endsection
@section('content')

    <div class="alert bg-success" id="success-msg">
        <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Success: <span class="completed-msg">Process completed successfully!</span></span>
    </div>
    <div class="alert bg-danger" id="error-msg">
        <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
        <span class="text-semibold">Error: Process does not complete, please try again.</span>
    </div>

    <div id="school" class="panel panel-flat">
        <div class="panel-heading">
            <div class="table-responsive" id="import">
                <div id="img" class="text-center" style="margin-bottom: 10px; display: none;"><img src="{{asset('assets/images/loader.gif')}}"></div>

                <div class="text-right" style="margin-bottom: 10px">
                    <span><small>Download files for {{ $CURRENT_YEAR }} </small></span>&nbsp;
                    <a @click="downloadfiles()" href="#" class="btn btn-success">
                    <i class="fa fa-cloud-download" aria-hidden="true"></i>
                    Download Recent Files</a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th style="min-width: 150px;">Title</th>
                        <th style="min-width: 250px;">File Name</th>
                        <th style="min-width: 100px;">Storage Path & Download URL</th>
                        <th style="min-width: 70px;">Status</th>
                        <th colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    {{-- Import Schools --}}
                    <tr>
                        <td>{{$files['schools']->title_key}}</td>
                        <td>{{$files['schools']->key}}</td>
                        <td class="url">{{$files['schools']->relative_path_on_server}}
                            <br /><a href="{{$files['schools']->download_url}}">{{$files['schools']->download_url}}</a></td>
                        <td class="school_status">{{$files['schools']->status}}</td>
                        <td><a v-bind:href="'/admin/import/edit-file/' + {{$files['schools']['id']}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a></td>
                        <td>
                            <a v-on:click="importSchools()" href="#" class="btn btn-success">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Import</a>
                        </td>
                    </tr>

                    {{-- Import Schools Pupil Teachers Stats --}}
                    <tr>
                        <td>{{$files['pupil_teachers']['school_counts']->title_key}}</td>
                        <td>{{$files['pupil_teachers']['school_counts']->key}}</td>
                        <td class="url">{{$files['pupil_teachers']['school_counts']->relative_path_on_server}}
                            <br /><a href="{{$files['pupil_teachers']['school_counts']->download_url}}">{{$files['pupil_teachers']['school_counts']->download_url}}</a>
                        </td>
                        <td class="teacher_status">{{$files['pupil_teachers']['school_counts']->status}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['pupil_teachers']['school_counts']->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                        <td rowspan="2">
                            <a v-on:click="importpupilstats()" href="#" class="btn btn-success">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Import</a>
                        </td>
                    </tr>

                    {{-- Import Schools Pupil Teachers Stats --}}
                    <tr>
                        <td>{{$files['pupil_teachers']['school_degrees']->title_key}}</td>
                        <td>{{$files['pupil_teachers']['school_degrees']->key}}</td>
                        <td class="url">{{$files['pupil_teachers']['school_degrees']->relative_path_on_server}}
                            <br /><a href="{{$files['pupil_teachers']['school_degrees']->download_url}}">{{$files['pupil_teachers']['school_degrees']->download_url}}</a></td>
                        <td class="teacher_status">{{$files['pupil_teachers']['school_degrees']->status}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['pupil_teachers']['school_degrees']->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                    </tr>

                    {{-- Import National Results --}}
                    <tr>
                        <td>{{$files['national_results']['so_results']->title_key}}</td>
                        <td>{{$files['national_results']['so_results']->key}}</td>
                        <td class="url">{{$files['national_results']['so_results']->relative_path_on_server}}
                            <br /><a href="{{$files['national_results']['so_results']->download_url}}">{{$files['national_results']['so_results']->download_url}}</a></td>
                        <td class="national_status">{{$files['national_results']['so_results']->status}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['national_results']['so_results']->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                        <td rowspan="3">
                            <a v-on:click="importnationalresults()" href="#" class="btn btn-success">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Import</a>
                        </td>
                    </tr>

                    {{-- Import National Results --}}
                    <tr>
                        <td>{{$files['national_results']['no_results']->title_key}}</td>
                        <td>{{$files['national_results']['no_results']->key}}</td>
                        <td class="url">{{$files['national_results']['no_results']->relative_path_on_server}}
                            <br /><a href="{{$files['national_results']['no_results']->download_url}}">{{$files['national_results']['no_results']->download_url}}</a></td>
                        <td class="national_status">{{$files['national_results']['no_results']->status}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['national_results']['no_results']->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                    </tr>

                    {{-- Import National Results --}}
                    <tr>
                        <td>{{$files['national_results']['ap9_results']->title_key}}</td>
                        <td>{{$files['national_results']['ap9_results']->key}}</td>
                        <td class="url">{{$files['national_results']['ap9_results']->relative_path_on_server}}
                            <br /><a href="{{$files['national_results']['ap9_results']->download_url}}">{{$files['national_results']['ap9_results']->download_url}}</a></td>
                        <td class="national_status">{{$files['national_results']['ap9_results']->status}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['national_results']['ap9_results']->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                    </tr>

                    {{-- Import Qualified upper secondary Data --}}
                    <tr>
                        <td>{{$files['qualified_upper_sec']->title_key}}</td>
                        <td>{{$files['qualified_upper_sec']->key}}</td>
                        <td class="url">{{$files['qualified_upper_sec']->relative_path_on_server}}
                            <br /><a href="{{$files['qualified_upper_sec']->download_url}}">{{$files['qualified_upper_sec']->download_url}}</a></td>
                        <td class="qualified_status">{{$files['qualified_upper_sec']->status}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['qualified_upper_sec']->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                        <td>
                            <a v-on:click="importuppersecdata()" href="#" class="btn btn-success">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Import</a>
                        </td>
                    </tr>

                    {{-- Import Grades Per Subject Data --}}
                    <tr>
                        <td>{{$files['grade9_file']->title_key}}</td>
                        <td>{{$files['grade9_file']->key}}</td>
                        <td class="url">{{$files['grade9_file']->relative_path_on_server}}
                            <br /><a href="{{$files['grade9_file']->download_url}}">{{$files['grade9_file']->download_url}}</a></td>
                        <td class="grade9_status">{{$files['grade9_file']->status}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['grade9_file']->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                        <td>
                            <a v-on:click="importgrade9data()" href="#" class="btn btn-success">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Import</a>
                        </td>
                    </tr>

                    {{-- Import Schools and community salsa values Results --}}
                    <tr>
                        <td>{{$files['salsa_values'][0]->title_key}}</td>
                        <td>{{$files['salsa_values'][0]->key}}</td>
                        <td class="url">{{$files['salsa_values'][0]->relative_path_on_server}}
                            <br /><a href="{{$files['salsa_values'][0]->download_url}}">{{$files['salsa_values'][0]->download_url}}</a></td>
                        <td class="salsa_status">{{($files['salsa_values'][0]->status == 2)? 'Processed':'Pending'}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['salsa_values'][0]->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                        <td rowspan="3">
                            <a v-on:click="importschoolsalsavalues()" href="#" class="btn btn-success">
                                <i class="fa fa-retweet" aria-hidden="true"></i> Import</a>
                        </td>
                    </tr>

                    {{-- Import Schools and community salsa values Results --}}
                    <tr>
                        <td>{{$files['salsa_values'][1]->title_key}}</td>
                        <td>{{$files['salsa_values'][1]->key}}</td>
                        <td class="url">{{$files['salsa_values'][1]->relative_path_on_server}}
                            <br /><a href="{{$files['salsa_values'][1]->download_url}}">{{$files['salsa_values'][1]->download_url}}</a></td>
                        <td class="salsa_status">{{($files['salsa_values'][1]->status == 2)? 'Processed':'Pending'}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['salsa_values'][1]->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                    </tr>

                    {{-- Import Schools and community salsa values Results --}}
                    <tr>
                        <td>{{$files['salsa_values'][2]->title_key}}</td>
                        <td>{{$files['salsa_values'][2]->key}}</td>
                        <td class="url">{{$files['salsa_values'][2]->relative_path_on_server}}
                            <br /><a href="{{$files['salsa_values'][2]->download_url}}">{{$files['salsa_values'][2]->download_url}}</a></td>
                        <td class="salsa_status">{{($files['salsa_values'][2]->status == 2)? 'Processed':'Pending'}}</td>
                        <td>
                            <a v-bind:href="'/admin/import/edit-file/' + {{$files['salsa_values'][2]->id}}" class="btn btn-primary"><i class="icon-pencil7"></i> Edit</a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

           <div>
                {{--<div id="img" class="text-center" style="margin-bottom: 10px; display: none;"><img src="{{asset('assets/images/loader.gif')}}"></div>
                <div class="text-center" style="margin-bottom: 10px"><a v-on:click="importCommunities()" style="width:200px" href="#" class="btn btn-success">Import Communities</a></div>
                <div class="text-center" style="margin-bottom: 10px;"><a v-on:click="importSchools()" style="width:200px" href="#" class="btn btn-success">Import Schools</a></div>
                <div class="text-center" style="margin-bottom: 10px"><a v-on:click="importschoolsalsavalues()" style="width:200px" href="#" class="btn btn-success">Import School Salsa Values</a></div>
                --}}{{--<div class="text-center" style="margin-bottom: 10px"><a style="width:200px" href="{{url('import/pupil-stats')}}" class="btn btn-success">Import School Salsa Values</a></div>--}}
                {{--<div class="text-center" style="margin-bottom: 10px"><a style="width:200px" href="{{url('import/national-results')}}" class="btn btn-success">Import School Salsa Values</a></div>--}}
                {{--<div class="text-center" style="margin-bottom: 10px"><a style="width:200px" href="{{url('import/upper-sec-data')}}" class="btn btn-success">Import School Salsa Values</a></div>--}}
                {{--<div class="text-center" style="margin-bottom: 10px"><a style="width:200px" href="{{url('import/grade9-data')}}" class="btn btn-success">Import School Salsa Values</a></div>--}}
           </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/import.js') }}"></script>
@endsection