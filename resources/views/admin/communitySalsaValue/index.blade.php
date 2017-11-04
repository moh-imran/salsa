@extends('admin.layouts.master')
@section('page-title')
    Community Salsa Value
@endsection
@section('breadcrumbs')
    Community salsa value
@endsection
@section('content')
{{--    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/community-salsa-value/create')}}" class="btn btn-success">Create New Community Salsa Value </a></div>--}}
    <div id="communitySalsaValue" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                        <label for="search" class="col-xs-3 mt-5">Search:</label>
                        <div class="col-xs-9 input-group">
                            <input @keyup.enter="loadCommunitySalsaValueList()" v-model="search" id="search" type="text" class="form-control">
                            <span @click="loadCommunitySalsaValueList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4"></div>
                    <div class="col-xs-12 col-sm-4 pr-5">
                        <label for="search" class="col-xs-3 mt-5">Order By:</label>
                        <div class="col-xs-9">
                            <select v-model="orderBy" @change="loadCommunitySalsaValueList()" class="form-control">
                            <option value="" disabled>Select option</option>
                            <option value="community_title,asc">Community Ascending</option>
                            <option value="community_title,desc">Community Descending</option>
                            <option value="ga_actual_value_avg_three_yrs,asc">GA Actual Value Avg Ascending</option>
                            <option value="ga_actual_value_avg_three_yrs,desc">GA Actual Value Avg Descending</option>
                            <option value="ga_model_calc_value_avg_three_yrs,asc">GA Model Calc Value Avg Ascending</option>
                            <option value="ga_model_calc_value_avg_three_yrs,desc">GA Model Calc Value Avg Descending</option>
                            <option value="ga_residual_value_avg_three_yrs,asc">GA Residual Value Avg Ascending</option>
                            <option value="ga_residual_value_avg_three_yrs,desc">GA Residual Value Avg Descending</option>
                            <option value="amp_actual_value_avg_three_yrs,asc">AMP Actual Value Avg Ascending</option>
                            <option value="amp_actual_value_avg_three_yrs,desc">AMP Actual Value Avg Descending</option>
                            <option value="amp_model_calc_value_avg_three_yrs,asc">AMP Model Calc Value Avg Ascending</option>
                            <option value="amp_model_calc_value_avg_three_yrs,desc">AMP Model Calc Value Avg Descending</option>
                            <option value="amp_residual_value_avg_three_yrs,asc">AMP Residual Value Avg Ascending</option>
                            <option value="amp_residual_value_avg_three_yrs,desc">AMP Residual Value Avg Descending</option>
                            <option value="public_ga_actual_value_avg_three_yrs,asc">Public GA Actual Value Avg Ascending</option>
                            <option value="public_ga_actual_value_avg_three_yrs,desc">Public GA Actual Value Avg Descending</option>
                            <option value="public_ga_model_calc_value_avg_three_yrs,asc">Public GA Model Calc Value Avg Ascending</option>
                            <option value="public_ga_model_calc_value_avg_three_yrs,desc">Public GA Model Calc Value Avg Descending</option>
                            <option value="public_ga_residual_value_avg_three_yrs,asc">Public GA Residual Value Avg Ascending</option>
                            <option value="public_ga_residual_value_avg_three_yrs,desc">Public GA Residual Value Avg Descending</option>
                            <option value="public_amp_actual_value_avg_three_yrs,asc">Public AMP Actual Value Avg Ascending</option>
                            <option value="public_amp_actual_value_avg_three_yrs,desc">Public AMP Actual Value Avg Descending</option>
                            <option value="public_amp_model_calc_value_avg_three_yrs,asc">Public AMP Model Calc Value Avg Ascending</option>
                            <option value="public_amp_model_calc_value_avg_three_yrs,desc">Public AMP Model Calc Value Avg Descending</option>
                            <option value="public_amp_residual_value_avg_three_yrs,asc">Public AMP Residual Value Avg Ascending</option>
                            <option value="public_amp_residual_value_avg_three_yrs,desc">Public AMP Residual Value Avg Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Community</th>
                        <th>GA Actual Value Avg</th>
                        <th>GA Model Calc Value Avg</th>
                        <th>GA Residual Value Avg</th>
                        <th>AMP Actual Value Avg</th>
                        <th>AMP Model Calc Value Avg</th>
                        <th>AMP Residual Value Avg</th>
                        <th>Public GA Actual Value Avg</th>
                        <th>Public GA Model Calc Value Avg</th>
                        <th>Public GA Residual Value Avg</th>
                        <th>Public AMP Actual Value Avg</th>
                        <th>Public AMP Model Calc Value Avg</th>
                        <th>Public AMP Residual Value Avg</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="communitySalsaValue in communitySalsaValues">
                        <td>@{{communitySalsaValue.community_title}}</td>
                        <td>@{{communitySalsaValue.ga_actual_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.ga_model_calc_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.ga_residual_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.amp_actual_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.amp_model_calc_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.amp_residual_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.public_ga_actual_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.public_ga_model_calc_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.public_ga_residual_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.public_amp_actual_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.public_amp_model_calc_value_avg_three_yrs}}</td>
                        <td>@{{communitySalsaValue.public_amp_residual_value_avg_three_yrs}}</td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a v-bind:href="'/admin/community-salsa-value/'+communitySalsaValue.id+'/edit'"><i class="icon-pencil7"></i></a>
                                </li>
                                {{--<li class="text-danger-600"><a v-on:click="deleteCommunitySalsaValueData(communitySalsaValue.id)"><i class="icon-trash"></i></a></li>--}}
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="communitySalsaValues.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadCommunitySalsaValueList('/admin/get-community-salsa-value?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadCommunitySalsaValueList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadCommunitySalsaValueList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadCommunitySalsaValueList('/admin/get-community-salsa-value?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadCommunitySalsaValueList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadCommunitySalsaValueList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadCommunitySalsaValueList('/admin/get-community-salsa-value?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/communitySalsaValue.js') }}"></script>
@endsection