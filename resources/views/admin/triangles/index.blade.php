@extends('admin.layouts.master')
@section('css')
    <style>
        .left_lbl {display: inline-block; float: left; margin: 0 10px; padding: 0; white-space: nowrap; width: 38%; text-align: right;}
        .right_lbl {display: inline-block;float: left;margin: 0;padding: 0;width: 50%;}
    </style>
@endsection
@section('page-title')
    Triangle Settings
@endsection
@section('breadcrumbs')
    triangles
@endsection
@section('content')
{{--    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/triangle/create')}}" class="btn btn-success">Create New Triangle</a></div>--}}
    <div id="triangles" class="panel panel-flat">
        <div class="panel-heading">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Free</th>
                        <th>Participation Warning Value</th>
                        <th>Merit Points Warning Value</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(triangle, key, index) in triangles">

                        <td>@{{triangle.key}}</td>
                        <td>@{{(triangle.is_free == 1) ?'Yes':'No'}}</td>
                        <td>@{{triangle.participation_warning_value}}</td>
                        <td>@{{triangle.merit_points_warning_value}}</td>
                        <td>@{{(triangle.status == 1) ?'Active':'In-Active'}}</td>

                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a v-bind:href="'/admin/triangles/'+triangle.id+'/edit'"><i class="icon-pencil7"></i></a>
                                </li>
                                {{--<li class="text-danger-600"><a v-on:click="deleteTriangles(triangle.id)"><i class="icon-trash"></i></a></li>--}}
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="triangles.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadTrianglesList('/admin/get-triangles?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadTrianglesList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadTrianglesList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadTrianglesList('/admin/get-triangles?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadTrianglesList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadTrianglesList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadTrianglesList('/admin/get-triangles?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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

@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/triangles.js') }}"></script>
@endsection