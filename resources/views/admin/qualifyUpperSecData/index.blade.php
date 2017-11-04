@extends('admin.layouts.master')
@section('page-title')
    Qualify Upper Sec Data
@endsection
@section('breadcrumbs')
    Qualify upper sec data
@endsection
@section('content')
{{--    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/qualify-upper-sec-data/create')}}" class="btn btn-success">Create New National Result Data</a></div>--}}
    <div id="qualifyUpperSecData" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                        <label for="search" class="col-xs-3 mt-5">Search:</label>
                        <div class="col-xs-9 input-group">
                            <input @keyup.enter="loadQualifyUpperSecDataList()" v-model="search" id="search" type="text" class="form-control">
                            <span @click="loadQualifyUpperSecDataList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4"></div>
                    <div class="col-xs-12 col-sm-4 pr-5">
                        <label for="search" class="col-xs-3 mt-5">Order By:</label>
                        <div class="col-xs-9">
                            <select v-model="orderBy" @change="loadQualifyUpperSecDataList()" class="form-control">
                            <option value="" disabled>Select option</option>
                            <option value="school_title,asc">School Ascending</option>
                            <option value="school_title,desc">School Descending</option>
                            <option value="share_qualify_vocational_program,asc">Share Qualify Vocational Program Ascending</option>
                            <option value="share_qualify_vocational_program,desc">Share Qualify Vocational Program Descending</option>
                            <option value="share_qualify_arts_aestetichs_program,asc">Share Qualify Arts Aestetichs Program Ascending</option>
                            <option value="share_qualify_arts_aestetichs_program,desc">Share Qualify Arts Aestetichs Program Descending</option>
                            <option value="share_qualify_econ_philos_socialsc_program,asc">Share Qualify Econ Philos Socialsc Program Ascending</option>
                            <option value="share_qualify_econ_philos_socialsc_program,desc">Share Qualify Econ Philos Socialsc Program Descending</option>
                            <option value="share_qualify_natural_science_tech_program,asc">Share Qualify Natural Science Tech Program Ascending</option>
                            <option value="share_qualify_natural_science_tech_program,desc">Share Qualify Natural Science Tech Program Descending</option>
                            <option value="share_not_qualified,asc">Share Not Qualified Ascending</option>
                            <option value="share_not_qualified,desc">Share Not Qualified Descending</option>
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
                        <th>Qualified For Vocational Program</th>
                        <th>Qualified For Arts Aestetichs Program</th>
                        <th>Qualified For Econ Philos Socialsc Program</th>
                        <th>Qualified For Natural Science Tech Program</th>
                        <th>Not Qualified</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="qualifyUpperSecData in qualifyUpperSecData">
                        <td>@{{qualifyUpperSecData.school_title}}</td>
                        <td>@{{qualifyUpperSecData.share_qualify_vocational_program}}</td>
                        <td>@{{qualifyUpperSecData.share_qualify_arts_aestetichs_program}}</td>
                        <td>@{{qualifyUpperSecData.share_qualify_econ_philos_socialsc_program}}</td>
                        <td>@{{qualifyUpperSecData.share_qualify_natural_science_tech_program}}</td>
                        <td>@{{qualifyUpperSecData.share_not_qualified}}</td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a v-bind:href="'/admin/qualify-upper-sec-data/'+qualifyUpperSecData.id+'/edit'"><i class="icon-pencil7"></i></a>
                                </li>
                                {{--<li class="text-danger-600"><a v-on:click="deleteQualifyUpperSecData(qualifyUpperSecData.id)"><i class="icon-trash"></i></a></li>--}}
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="qualifyUpperSecData.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadQualifyUpperSecDataList('/admin/get-qualify-upper-sec-data?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadQualifyUpperSecDataList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadQualifyUpperSecDataList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadQualifyUpperSecDataList('/admin/get-qualify-upper-sec-data?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadQualifyUpperSecDataList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadQualifyUpperSecDataList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadQualifyUpperSecDataList('/admin/get-qualify-upper-sec-data?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/qualifyUpperSecData.js') }}"></script>
@endsection