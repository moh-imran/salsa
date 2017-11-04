@extends('admin.layouts.master')
@section('css')
    <style>
        .left_lbl {display: inline-block; float: left; margin: 0 10px; padding: 0; white-space: nowrap; width: 38%; text-align: right;}
        .right_lbl {display: inline-block;float: left;margin: 0;padding: 0;width: 50%;}
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
    Color Code Settings
@endsection
@section('breadcrumbs')
    Colorcodes
@endsection
@section('content')
{{--    <div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/colorcode/create')}}" class="btn btn-success">Create New Color Code</a></div>--}}
    <div id="colorcode" class="panel panel-flat">
        <div class="panel-heading">

            <!-- Info modal -->
            <div id="modal_edit" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">Edit Information</h6>
                        </div>

                        <div class="modal-body">
                            <fieldset class="content-group">

                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2">Category</label>
                                    <div class="col-lg-10">
                                        <input v-model="editdata.label" type="text" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2">Title</label>
                                    <div class="col-lg-10">
                                        <input type="text" v-model="editdata.key" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2">Much Below</label>
                                    <div class="col-lg-10">
                                        <input type="text" v-model="editdata.much_below_when_less_than" class="form-control">
                                        <small class="text-light " style="display: inline-block;padding: 0 10px;">When less than</small>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2">Below</label>
                                    <div class="col-lg-10">
                                        <input type="text" v-model="editdata.below_when_less_than" class="form-control">
                                        <small class="text-light " style="display: inline-block;padding: 0 10px;">When less than</small>
                                    </div>
                                </div>
                                {{--<div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2">Average</label>
                                    <div class="col-lg-10">
                                        <input type="text" v-model="editdata.average_when_greater_than" class="form-control">
                                        <small class="text-light " style=" display: inline-block;padding: 0 10px;">When greater than</small>
                                    </div>
                                </div>--}}
                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2">Above</label>
                                    <div class="col-lg-10">
                                        <input type="text" v-model="editdata.above_when_greater_than" class="form-control">
                                        <small class="text-light " style=" display: inline-block;padding: 0 10px;">When greater than</small>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2">Much Higher</label>
                                    <div class="col-lg-10">
                                        <input type="text" v-model="editdata.much_higher_when_greater_than" class="form-control">
                                        <small class="text-light " style="display: inline-block;padding: 0 10px;">When greater than</small>
                                    </div>
                                </div>


                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2" style="white-space: nowrap;">For Free App</label>
                                    <div class="col-lg-10" style="padding-top: 8px;">
                                        <input v-model="editdata.is_free" name="is_free" id="slide_is_free" type="checkbox" class="slider-toggle" />
                                        <label class="slider-viewport light" for="slide_is_free">
                                            <div class="slider">
                                                <div class="slider-button">&nbsp;</div>
                                                <div class="slider-content left"><span>Yes</span></div>
                                                <div class="slider-content right"><span>No</span></div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2">Status</label>
                                    <div class="col-lg-10" style="padding-top: 8px; text-align: left;">
                                        <input v-model="editdata.status" name="status" id="slide_status" type="checkbox" class="slider-toggle" />
                                        <label class="slider-viewport light" for="slide_status">
                                            <div class="slider">
                                                <div class="slider-button">&nbsp;</div>
                                                <div class="slider-content left"><span>Active</span></div>
                                                <div class="slider-content right"><span>Inactive</span></div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                    <label class="control-label col-lg-2" style="white-space: nowrap;">Is Reverse</label>
                                    <div class="col-lg-10" style="padding-top: 8px;">
                                        <input v-model="editdata.is_reverse" name="is_reverse" id="slide_is_reverse" type="checkbox" class="slider-toggle" />
                                        <label class="slider-viewport light" for="slide_is_reverse">
                                            <div class="slider">
                                                <div class="slider-button">&nbsp;</div>
                                                <div class="slider-content left"><span>Yes</span></div>
                                                <div class="slider-content right"><span>No</span></div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                            </fieldset>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            <button @click="updateColorcode()" type="button" class="btn btn-info">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /info modal -->

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Free</th>
                        <th style="background-color: {{ COLOR_MUCH_BELOW }};">Much Below</th>
                        <th style="background-color: {{ COLOR_BELOW }};">Below</th>
                        {{--<th style="background-color: {{ COLOR_AVERAGE }};">Average</th>--}}
                        <th style="background-color: {{ COLOR_ABOVE }};">Above</th>
                        <th style="background-color: {{ COLOR_MUCH_HIGHER }};">Much Higher</th>
                        <th>Status</th>
                        <th>Reverse</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(colorcode, key, index) in colorcodes" v-if="colorcode.status == 1">
                        
                        <td v-if="colorcode.label != colorcodes[(key == 0 ? key : (key -1) )].label">
                            <strong :colorcode="colorcodes[(key == 0 ? key : (key -1) )].label" :data-key="key" :data-idx="index" :title="colorcode.label" v-text="colorcode.label"></strong>
                        </td>
                        <td v-else>
                            <span v-if="key == 0">
                                <strong :title="colorcode.label" v-text="colorcode.label"></strong>
                            </span>
                            <span v-else>
                                &nbsp;
                            </span>
                        </span>

                        <td>@{{colorcode.key}}</td>
                        <td>@{{(colorcode.is_free == 1) ?'Yes':'No'}}</td>
                        <td style="background-color: {{ COLOR_MUCH_BELOW }};">@{{colorcode.much_below_when_less_than}}</td>
                        <td style="background-color: {{ COLOR_BELOW }};">@{{colorcode.below_when_less_than}}</td>
                        {{--<td style="background-color: {{ COLOR_AVERAGE }};">@{{colorcode.average_when_greater_than}}</td>--}}
                        <td style="background-color: {{ COLOR_ABOVE }};">@{{colorcode.above_when_greater_than}}</td>
                        <td style="background-color: {{ COLOR_MUCH_HIGHER }};">@{{colorcode.much_higher_when_greater_than}}</td>
                        <td>@{{(colorcode.status == 1) ?'Active':'In-Active'}}</td>
                        <td>@{{(colorcode.is_reverse == 1) ?'Yes':'No'}}</td>

                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600">
                                    <a @click="editColorcode(colorcode.id, key)"><i class="icon-pencil7"></i></a>
                                </li>
                             </ul>
                        </td>
                       
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="colorcodes.length > 0">
            <div class="col-xs-12 col-sm-12 text-center pagination_wrapper">
                <a @click="loadColorcodesList('/admin/get-colorcode?page=1&search=')" id="move-left" class="page-link">
                <span aria-hidden="true">First</span>
                <span class="sr-only">First</span>
                </a>
                <div id="paginationwrap">
                    <ul class="pagination">
                        <li v-if="pagingData.prev_page_url==null" class="page-item disabled" >
                            <a @click="loadColorcodesList(pagingData.prev_page_url+'&search=')" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-else class="page-item">
                            <a  @click="loadColorcodesList(pagingData.prev_page_url+'&search=');" class="page-link">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-for="x in pagingData.last_page" class="page-item">

                            <a v-if="x <= pagingData.current_page + 5 && x >= pagingData.current_page - 4"
                               class="page-link" href="javascript:;" @click="loadColorcodesList('/admin/get-colorcode?page='+(x)+'&search=')">@{{x}}</a>
                        </li>
                        <li v-if="pagingData.next_page_url==null" class="page-item disabled" >
                            <a class="page-link" @click="loadColorcodesList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li v-else  class="page-item">
                            <a class="page-link" @click="loadColorcodesList(pagingData.next_page_url+'&search=')">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a @click="loadColorcodesList('/admin/get-colorcode?page='+(pagingData.last_page)+'&search=')" id="move-right"  class="page-link">
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
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/colorcode.js') }}"></script>
@endsection