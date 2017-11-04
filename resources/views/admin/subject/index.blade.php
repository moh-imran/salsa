@extends('admin.layouts.master')
@section('page-title')
    Subject
@endsection
@section('breadcrumbs')
    Subject
@endsection
@section('content')
{{--    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/subject/create')}}" class="btn btn-success">Create New Subject</a></div>--}}
    <div id="subject" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                        <label for="search" class="col-xs-3 mt-5">Search:</label>
                        <div class="col-xs-9 input-group">
                            <input @keyup.enter="loadSubjectList()" v-model="search" id="search" type="text" class="form-control">
                            <span @click="loadSubjectList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4"></div>
                    <div class="col-xs-12 col-sm-4 pr-5">
                        <label for="search" class="col-xs-3 mt-5">Order By:</label>
                        <div class="col-xs-9">
                            <select v-model="orderBy" @change="loadSubjectList()" class="form-control">
                            <option value="" disabled>Select option</option>
                            <option value="title,asc">Title Ascending</option>
                            <option value="title,desc">Title Descending</option>
                            <option value="use_for_deviation,desc">Deviation Yes</option>
                            <option value="use_for_deviation,asc">Deviation No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Use For Deviation</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="subject in subjects">
                        <td>@{{subject.title}}</td>
                        <td v-if="subject.use_for_deviation == 1">Yes</td>
                        <td v-else>No</td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a v-bind:href="'/admin/subject/'+subject.id+'/edit'"><i class="icon-pencil7"></i></a>
                                </li>
                                {{--<li class="text-danger-600"><a v-on:click="deleteSubject(subject.id)"><i class="icon-trash"></i></a></li>--}}
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="subjects.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadSubjectList('/admin/get-subject?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadSubjectList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadSubjectList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadSubjectList('/admin/get-subject?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadSubjectList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadSubjectList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadSubjectList('/admin/get-subject?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/subject.js') }}"></script>
@endsection