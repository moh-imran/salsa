@extends('admin.layouts.master')
@section('page-title')
    Grade9 Data
@endsection
@section('breadcrumbs')
    Grade9 data
@endsection
@section('content')
    {{--<div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/grade9data/create')}}" class="btn btn-success">Create New Grade9 Data</a></div>--}}
    <div id="grade9data" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                        <label for="search" class="col-xs-3 mt-5">Search:</label>
                        <div class="col-xs-9 input-group">
                            <input @keyup.enter="loadGrade9dataList()" v-model="search" id="search" type="text" class="form-control">
                            <span @click="loadGrade9dataList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4"></div>
                    <div class="col-xs-12 col-sm-4 pr-5">
                        <label for="search" class="col-xs-3 mt-5">Order By:</label>
                        <div class="col-xs-9">
                            <select v-model="orderBy" @change="loadGrade9dataList()" class="form-control">
                            <option value="" disabled>Select option</option>
                            <option value="school_title,asc">School Ascending</option>
                            <option value="school_title,desc">School Descending</option>
                            <option value="subject_title,asc">Subject Ascending</option>
                            <option value="subject_title,desc">Subject Descending</option>
                            <option value="students_enrolled,asc">Students Enrolled Ascending</option>
                            <option value="students_enrolled,desc">Students Enrolled Descending</option>
                            <option value="merit_points,asc">Merit Points Ascending</option>
                            <option value="merit_points,desc">Merit Points Descending</option>
                            <option value="share_ae,asc">Share AE Ascending</option>
                            <option value="share_ae,desc">Share AE Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>School</th>
                        <th>Subject</th>
                        <th>Students Enrolled</th>
                        <th>Merit Points</th>
                        <th>Share AE</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="grade9data in grade9data">
                        <td>@{{grade9data.school_title}}</td>
                        <td>@{{grade9data.subject_title}}</td>
                        <td>@{{grade9data.students_enrolled}}</td>
                        <td>@{{grade9data.merit_points}}</td>
                        <td>@{{grade9data.share_ae}}</td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a v-bind:href="'/admin/grade9data/'+grade9data.id+'/edit'"><i class="icon-pencil7"></i></a>
                                </li>
                                {{--<li class="text-danger-600"><a v-on:click="deletegrade9data(grade9data.id)"><i class="icon-trash"></i></a></li>--}}
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="grade9data.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadGrade9dataList('/admin/get-grade9data?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadGrade9dataList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadGrade9dataList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadGrade9dataList('/admin/get-grade9data?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadGrade9dataList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadGrade9dataList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadGrade9dataList('/admin/get-grade9data?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
                <span aria-hidden="true">Last</span>
                <span class="sr-only">Last</span>
                </a>
                <label id="move-right" for="move-right">Go to:</label>
                <input onkeypress='return event.charCode >= 48 && event.charCode <= 57' v-model="page" @change="goto()" @keyup.enter="goto()"  id="move-right"
                style="padding: 10px;border: solid 1px gainsboro; height: 80%;width: 50px;" type="text">
            </div>
            <div class="text-center">@{{ pagingData.current_page }} out of @{{ pagingData.last_page }}<div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/grade9data.js') }}"></script>
@endsection