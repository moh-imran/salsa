@extends('admin.layouts.master')
@section('css')
    <style>
        .slider-toggle {display: none; visibility: hidden;}
        .slider-button,.slider-content,.slider {-webkit-transition: all 500ms ease-in-out;-moz-transition: all 500ms ease-in-out;-ms-transition: all 500ms ease-in-out;-o-transition: all 500ms ease-in-out;transition: all 500ms ease-in-out;}
        .slider-viewport {border: 1px solid #858585;display: block;height: 22px;overflow: hidden;width: 94px;position: relative;cursor: pointer;border-radius: 3px;color: #fff;float: right;-webkit-touch-callout:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;}
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
    School
@endsection
@section('breadcrumbs')
    School
@endsection
@section('content')
    {{--<div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/school/create')}}" class="btn btn-success">Create New School</a></div>--}}
    <div id="school" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                    <label for="search" class="col-xs-3 mt-5">Search:</label>
                    <div class="col-xs-9 input-group">
                        <input @keyup.enter="loadSchoolList()" v-model="search" id="search" type="text" class="form-control">
                        <span @click="loadSchoolList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                    <div class="col-xs-12 col-sm-4"></div>
                    <div class="col-xs-12 col-sm-4 pr-5">
                        <label for="search" class="col-xs-3 mt-5">Order By:</label>
                        <div class="col-xs-9">
                            <select v-model="orderBy" @change="loadSchoolList()" class="form-control">
                                <option value="" disabled>Select option</option>
                                <option value="code,asc">Code Ascending</option>
                                <option value="code,desc">Code Descending</option>
                                <option value="title,asc">Title Ascending</option>
                                <option value="title,desc">Title Descending</option>
                                <option value="community_title,asc">Community Title Ascending</option>
                                <option value="community_title,desc">Community Title Descending</option>
                                <option value="is_public,asc">Type Ascending</option>
                                <option value="is_public,desc">Type Descending</option>
                                <option value="street_address,asc">Street Address Ascending</option>
                                <option value="street_address,desc">Street Address Descending</option>
                                <option value="post_number,asc">Post Number Ascending</option>
                                <option value="post_number,desc">Post Number Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Community Title</th>
                        <th>Type</th>
                        <th>Street Address</th>
                        <th>Post Number</th>
                        <th>Post Area</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr v-for="(school, index) in schools">
                            <td>@{{school.code}}</td>
                            <td>@{{school.title}}</td>
                            <td>@{{school.community_title}}</td>
                            <td>@{{school.is_public}}</td>
                            <td>@{{school.street_address}}</td>
                            <td>@{{school.post_number}}</td>
                            <td>@{{school.post_area}}</td>
                            <td>
                                <div v-if="school.status == 1">
                                    <input @change="changeStatus(0, index)" type="checkbox" class="slider-toggle" checked v-bind:id="school.id" />
                                    <label class="slider-viewport light" v-bind:for="school.id">
                                        <div class="slider">
                                            <div class="slider-button">&nbsp;</div>
                                            <div class="slider-content left"><span>Active</span></div>
                                            <div class="slider-content right"><span>Inactive</span></div>
                                        </div>
                                    </label>
                                </div>
                                <div v-else>
                                    <input @change="changeStatus(1, index)" type="checkbox" class="slider-toggle" v-bind:id="school.id" />
                                    <label class="slider-viewport light" v-bind:for="school.id">
                                        <div class="slider">
                                            <div class="slider-button">&nbsp;</div>
                                            <div class="slider-content left"><span>Active</span></div>
                                            <div class="slider-content right"><span>Inactive</span></div>
                                        </div>
                                    </label>
                                </div>

                            </td>
                            <td>
                                <ul class="icons-list">
                                    <li class="text-primary-600">
                                        <a v-bind:href="'/admin/school/'+school.id+'/edit'"><i class="icon-pencil7"></i></a>
                                    </li>
                                    {{--<li class="text-danger-600"><a v-on:click="deleteSchool(school.id)"><i class="icon-trash"></i></a></li>--}}
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="schools.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadSchoolList('/admin/get-school?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadSchoolList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadSchoolList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadSchoolList('/admin/get-school?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadSchoolList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadSchoolList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadSchoolList('/admin/get-school?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/school.js') }}"></script>
@endsection