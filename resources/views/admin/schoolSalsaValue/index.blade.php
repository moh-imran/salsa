@extends('admin.layouts.master')
@section('page-title')
    School Salsa Value
@endsection
@section('breadcrumbs')
    School salsa value
@endsection
@section('content')
    {{--<div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/school-salsa-value/create')}}" class="btn btn-success">Create New School Salsa Value</a></div>--}}
    <div id="schoolSalsaValue" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                        <label for="search" class="col-xs-3 mt-5">Search:</label>
                        <div class="col-xs-9 input-group">
                            <input @keyup.enter="loadSchoolSalsaValueList()" v-model="search" id="search" type="text" class="form-control">
                            <span @click="loadSchoolSalsaValueList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4"></div>
                    <div class="col-xs-12 col-sm-4 pr-5">
                        <label for="search" class="col-xs-3 mt-5">Order By:</label>
                        <div class="col-xs-9">
                            <select v-model="orderBy" @change="loadSchoolSalsaValueList()" class="form-control">
                            <option value="" disabled>Select option</option>
                            <option value="school_title,asc">School Ascending</option>
                            <option value="school_title,desc">School Descending</option>
                            <option value="bg_parents_avg_level_of_education,asc">Parents Avg Level Of Education Ascending</option>
                            <option value="bg_parents_avg_level_of_education,desc">Parents Avg Level Of Education Descending</option>
                            <option value="bg_share_of_newly_immigrated,asc">Share Of Newly Immigrated Ascending</option>
                            <option value="bg_share_of_newly_immigrated,desc">Share Of Newly Immigrated Descending</option>
                            <option value="bg_share_of_born_abroad,asc">Share Of Born Abroad Ascending</option>
                            <option value="bg_share_of_born_abroad,desc">Share Of Born Abroad Descending</option>
                            <option value="bg_share_of_foreign_background,asc">Share Of Foreign Background Ascending</option>
                            <option value="bg_share_of_foreign_background,desc">Share Of Foreign Background Descending</option>
                            <option value="bg_share_of_boys,asc">Share Of Boys Ascending</option>
                            <option value="bg_share_of_boys,desc">Share Of Boys Descending</option>
                            <option value="ga_actual_value_f,asc">Actual Value F Ascending</option>
                            <option value="ga_actual_value_f,desc">Actual Value F Descending</option>
                            <option value="ga_model_calc_value_b,asc">Model calc Value B Ascending</option>
                            <option value="ga_model_calc_value_b,desc">Model calc Value B Descending</option>
                            <option value="ga_residual_value_f_b,asc">Residual Value F-B Ascending</option>
                            <option value="ga_residual_value_f_b,desc">Residual Value F-B Descending</option>
                            <option value="amp_actual_value_f,asc">AMP Actual Value F Ascending</option>
                            <option value="amp_actual_value_f,desc">AMP Actual Value F Descending</option>
                            <option value="amp_model_calc_value_b,asc">AMP Model Calc Value B Ascending</option>
                            <option value="amp_model_calc_value_b,desc">AMP Model Calc Value B Descending</option>
                            <option value="amp_residual_value_f_b,asc">AMP Residual Value F-B Ascending</option>
                            <option value="amp_residual_value_f_b,desc">AMP Residual Value F-B Descending</option>
                            </select>
                            {{--<option value="avg_deviation_value_in_primary_sub,asc">AVG Deviation Value Ascending</option>--}}
                            {{--<option value="avg_deviation_value_in_primary_sub,desc">AVG Deviation Value Descending</option>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>School</th>
                        <th>Parents Avg Level Of Education</th>
                        <th>Share Of Newly Immigrated</th>
                        <th>Share Of Born Abroad</th>
                        <th>Share Of Foreign Background</th>
                        <th>Share Of Boys</th>
                        <th>Actual Value F</th>
                        <th>Model calc Value B</th>
                        <th>Residual Value F-B</th>
                        <th>AMP Actual Value F</th>
                        <th>AMP Model Calc Value B</th>
                        <th>AMP Residual Value F-B</th>
                        {{--<th>AVG Deviation Value</th>--}}
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="schoolSalsaValue in schoolSalsaValues">
                        <td>@{{schoolSalsaValue.school_title}}</td>
                        <td>@{{schoolSalsaValue.bg_parents_avg_level_of_education}}</td>
                        <td>@{{schoolSalsaValue.bg_share_of_newly_immigrated}}</td>
                        <td>@{{schoolSalsaValue.bg_share_of_born_abroad}}</td>
                        <td>@{{schoolSalsaValue.bg_share_of_foreign_background}}</td>
                        <td>@{{schoolSalsaValue.bg_share_of_boys}}</td>
                        <td>@{{schoolSalsaValue.ga_actual_value_f}}</td>
                        <td>@{{schoolSalsaValue.ga_model_calc_value_b}}</td>
                        <td>@{{schoolSalsaValue.ga_residual_value_f_b}}</td>
                        <td>@{{schoolSalsaValue.amp_actual_value_f}}</td>
                        <td>@{{schoolSalsaValue.amp_model_calc_value_b}}</td>
                        <td>@{{schoolSalsaValue.amp_residual_value_f_b}}</td>
                        {{--<td>@{{schoolSalsaValue.avg_deviation_value_in_primary_sub}}</td>--}}
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a v-bind:href="'/admin/school-salsa-value/'+schoolSalsaValue.id+'/edit'"><i class="icon-pencil7"></i></a>
                                </li>
                                {{--<li class="text-danger-600"><a v-on:click="deleteNationalResultData(schoolSalsaValue.id)"><i class="icon-trash"></i></a></li>--}}
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="schoolSalsaValues.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadSchoolSalsaValueList('/admin/get-school-salsa-value?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadSchoolSalsaValueList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadSchoolSalsaValueList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadSchoolSalsaValueList('/admin/get-school-salsa-value?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadSchoolSalsaValueList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadSchoolSalsaValueList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadSchoolSalsaValueList('/admin/get-school-salsa-value?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/schoolSalsaValue.js') }}"></script>
@endsection