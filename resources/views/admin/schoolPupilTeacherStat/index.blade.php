@extends('admin.layouts.master')
@section('page-title')
    School Pupil Teacher Stat
@endsection
@section('breadcrumbs')
    School pupil teacher stat
@endsection
@section('content')
{{--    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/school-pupil-teacher-stat/create')}}" class="btn btn-success">Create New School Pupil Teacher Stat </a></div>--}}
    <div id="schoolPupilTeacherStat" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 pl-5">
                        <label for="search" class="col-xs-3 mt-5">Search:</label>
                        <div class="col-xs-9 input-group">
                            <input @keyup.enter="loadSchoolPupilTeacherStatList()" v-model="search" id="search" type="text" class="form-control">
                            <span @click="loadSchoolPupilTeacherStatList()" class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4"></div>
                    <div class="col-xs-12 col-sm-4 pr-5">
                        <label for="search" class="col-xs-3 mt-5">Order By:</label>
                        <div class="col-xs-9">
                            <select v-model="orderBy" @change="loadSchoolPupilTeacherStatList()" class="form-control">
                            <option value="" disabled>Select option</option>
                            <option value="school_title,asc">School Ascending</option>
                            <option value="school_title,desc">School Descending</option>
                            <option value="students_grade1,asc">Students Grade1 Ascending</option>
                            <option value="students_grade1,desc">Students Grade1 Descending</option>
                            <option value="students_grade2,asc">Students Grade2 Ascending</option>
                            <option value="students_grade2,desc">Students Grade2 Descending</option>
                            <option value="students_grade3,asc">Students Grade3 Ascending</option>
                            <option value="students_grade3,desc">Students Grade3 Descending</option>
                            <option value="students_grade4,asc">Students Grade4 Ascending</option>
                            <option value="students_grade4,desc">Students Grade4 Descending</option>
                            <option value="students_grade5,asc">Students Grade5 Ascending</option>
                            <option value="students_grade5,desc">Students Grade5 Descending</option>
                            <option value="students_grade6,asc">Students Grade6 Ascending</option>
                            <option value="students_grade6,desc">Students Grade6 Descending</option>
                            <option value="students_grade7,asc">Students Grade7 Ascending</option>
                            <option value="students_grade7,desc">Students Grade7 Descending</option>
                            <option value="students_grade8,asc">Students Grade8 Ascending</option>
                            <option value="students_grade8,desc">Students Grade8 Descending</option>
                            <option value="students_grade9,asc">Students Grade9 Ascending</option>
                            <option value="students_grade9,desc">Students Grade9 Descending</option>
                            <option value="teachers_count,asc">Teachers Count Ascending</option>
                            <option value="teachers_count,desc">Teachers Count Descending</option>
                            <option value="students_per_teacher,asc">Students Per Teacher Ascending</option>
                            <option value="students_per_teacher,desc">Students Per Teacher Descending</option>
                            <option value="percent_teacher_pedagogical_degree,asc">Percent Teacher Pedagogical Degree Ascending</option>
                            <option value="percent_teacher_pedagogical_degree,desc">Percent Teacher Pedagogical Degree Descending</option>
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
                        <th>Students Grade1</th>
                        <th>Students Grade2</th>
                        <th>Students Grade3</th>
                        <th>Students Grade4</th>
                        <th>Students Grade5</th>
                        <th>Students Grade6</th>
                        <th>Students Grade7</th>
                        <th>Students Grade8</th>
                        <th>Students Grade9</th>
                        <th>Teachers Count</th>
                        <th>Students Per Teacher</th>
                        <th>Percent Teacher Pedagogical Degree</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="schoolPupilTeacherStat in schoolPupilTeacherStats">
                        <td>@{{schoolPupilTeacherStat.school_title}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade1}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade2}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade3}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade4}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade5}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade6}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade7}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade8}}</td>
                        <td>@{{schoolPupilTeacherStat.students_grade9}}</td>
                        <td>@{{schoolPupilTeacherStat.teachers_count}}</td>
                        <td>@{{schoolPupilTeacherStat.students_per_teacher}}</td>
                        <td>@{{schoolPupilTeacherStat.percent_teacher_pedagogical_degree}}</td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a v-bind:href="'/admin/school-pupil-teacher-stat/'+schoolPupilTeacherStat.id+'/edit'"><i class="icon-pencil7"></i></a>
                                </li>
                                {{--<li class="text-danger-600"><a v-on:click="deleteSchoolPupilTeacherStatData(schoolPupilTeacherStat.id)"><i class="icon-trash"></i></a></li>--}}
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="schoolPupilTeacherStats.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadSchoolPupilTeacherStatList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadSchoolPupilTeacherStatList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadSchoolPupilTeacherStatList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadSchoolPupilTeacherStatList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
        <div class="row" v-if="schoolPupilTeacherStats.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page=1')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadSchoolPupilTeacherStatList(pagingData.prev_page_url)" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadSchoolPupilTeacherStatList(pagingData.prev_page_url);" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page='+(x))">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadSchoolPupilTeacherStatList(pagingData.next_page_url)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadSchoolPupilTeacherStatList(pagingData.next_page_url)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page='+(pagingData.last_page))" id="move-right"  class="page-link">
                <span aria-hidden="true">Last</span>
                <span class="sr-only">Last</span>
                </a>
                <label id="move-right" for="move-right">Go to:</label>
                <input onkeypress='return event.charCode >= 48 && event.charCode <= 57' v-model="page" @change="goto()" @keyup.enter="goto()"  id="move-right"
                style="padding: 10px;border: solid 1px gainsboro; height: 80%;width: 50px;" type="text">
            </div>
            <div class="text-center">@{{ pagingData.current_page }} out of @{{ pagingData.last_page }}</div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/schoolPupilTeacherStat.js') }}"></script>
@endsection