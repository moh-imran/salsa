@extends('admin.layouts.master')
@section('page-title')
    Children
@endsection
@section('breadcrumbs')
    Children
@endsection
@section('content')
{{--    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/client/create')}}" class="btn btn-success">Create New Client</a></div>--}}
    <div id="children_info" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                        <label for="search" class="col-xs-3 mt-5">Search:</label>
                        <div class="col-xs-9 input-group">
                            <input @keyup.enter="loadClientList()" v-model="search" id="search" type="text" class="form-control">
                            <span @click="loadClientList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4"></div>
                   
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Child#1</th>
                        {{--<th>Status</th>--}}
                        <th>Child#2</th>
                        <th>Child#3</th>
                        <th>Child#4</th>
                        <th>Child#5</th>
                        {{--<th>Action</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="client in clients">
                        <td>@{{client.name}}</td>
                        <td>@{{client.email}}</td>
                        
                        {{--<td v-if="client.status == 1">Active</td>--}}
                        {{--<td v-else>Inactive</td>--}}
                        <td v-if="client.user_children">@{{client.user_children.child_1_age}}</td>
                        <td v-else></td>
                        <td v-if="client.user_children">@{{client.user_children.child_2_age}}</td>
                        <td v-else></td>
                        <td v-if="client.user_children">@{{client.user_children.child_3_age}}</td>
                        <td v-else></td>
                        
                        <td v-if="client.user_children">@{{ client.user_children.child_4_age }}</td>
                        <!--<td v-else></td>-->
                        <td v-if="client.user_children">@{{client.user_children.child_5_age}}</td>
                        
                        {{--<td>--}}
                            {{--<ul class="icons-list">--}}
                                {{--<li class="text-primary-600">--}}
                                    {{--<a v-bind:href="'/admin/children/'+client.id+'/edit'"><i class="icon-pencil7"></i></a>--}}
                                {{--</li>--}}
                                {{--<li class="text-danger-600"><a v-on:click="deleteCustomer(client.id)"><i class="icon-trash"></i></a></li>--}}
                            {{--</ul>--}}
                        {{--</td>--}}
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="clients.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadClientList('/admin/get-children?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadClientList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadClientList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadClientList('/admin/get-children?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadClientList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadClientList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadClientList('/admin/get-children?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/children.js') }}"></script>
@endsection