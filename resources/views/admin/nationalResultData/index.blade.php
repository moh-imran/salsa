@extends('admin.layouts.master')
@section('page-title')
    National Result Data
@endsection
@section('breadcrumbs')
    National result data
@endsection
@section('content')
{{--    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/national-result-data/create')}}" class="btn btn-success">Create New National Result Data</a></div>--}}
    <div id="nationalResultData" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                        <label for="search" class="col-xs-3 mt-5">Search:</label>
                        <div class="col-xs-9 input-group">
                            <input @keyup.enter="loadNationalResultDataList()" v-model="search" id="search" type="text" class="form-control">
                            <span @click="loadNationalResultDataList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4"></div>
                    <div class="col-xs-12 col-sm-4 pr-5">
                        <label for="search" class="col-xs-3 mt-5">Order By:</label>
                        <div class="col-xs-9">
                            <select v-model="orderBy" @change="loadNationalResultDataList()" class="form-control">
                            <option value="" disabled>Select option</option>
                            <option value="school_title,asc">School Ascending</option>
                            <option value="school_title,desc">School Descending</option>
                            <option value="subject_title,asc">Subject Ascending</option>
                            <option value="subject_title,desc">Subject Descending</option>
                            <option value="students_participated,asc">Students Participated Ascending</option>
                            <option value="students_participated,desc">Students Participated Descending</option>
                            <option value="merit_points,asc">Merit Points Ascending</option>
                            <option value="merit_points,desc">Merit Points Descending</option>
                            <option value="share_ae,asc">Share AE Ascending</option>
                            <option value="share_ae,desc">Share AE Descending</option>
                            <option value="share_participated,asc">Share Participated Ascending</option>
                            <option value="share_participated,desc">Share Participated Descending</option>
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
                        <th>Students Participated</th>
                        <th>Merit Points</th>
                        <th>Share AE</th>
                        <th>Share Participated</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="nationalResultData in nationalResultData">
                        <td>@{{nationalResultData.school_title}}</td>
                        <td>@{{nationalResultData.subject_title}}</td>
                        <td>@{{nationalResultData.students_participated}}</td>
                        <td>@{{nationalResultData.merit_points}}</td>
                        <td>@{{nationalResultData.share_ae}}</td>
                        <td>@{{nationalResultData.share_participated}}</td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a v-bind:href="'/admin/national-result-data/'+nationalResultData.id+'/edit'"><i class="icon-pencil7"></i></a>
                                </li>
                                {{--<li class="text-danger-600"><a v-on:click="deleteNationalResultData(nationalResultData.id)"><i class="icon-trash"></i></a></li>--}}
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="nationalResultData.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadNationalResultDataList('/admin/get-national-result-data?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadNationalResultDataList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadNationalResultDataList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadNationalResultDataList('/admin/get-national-result-data?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadNationalResultDataList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadNationalResultDataList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadNationalResultDataList('/admin/get-national-result-data?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/nationalResultData.js') }}"></script>
@endsection