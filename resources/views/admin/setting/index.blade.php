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
    Setting
@endsection
@section('breadcrumbs')
    Setting
@endsection
@section('content')
    {{--<div class="text-right" style="margin-bottom: 10px"><a href="{{url('admin/setting/create')}}" class="btn btn-success">Create New Setting</a></div>--}}
    @if (count($errors) > 0)
        <div class="alert bg-danger">

            <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="setting" class="panel panel-flat">
        <div class="panel-heading">
            <div class="panel-body">
                {!! Form::model($settings, ['route' => ['admin.setting.index'], 'method' => 'get', 'class' => 'form-horizontal']) !!}
                    <div >
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <?php
                            foreach($settings as $setting)
                                {
                                    $input = '';
                                    if($setting->type == 'select')
                                        {
                                            $input .= '<select name="'. $setting->key .'" class="form-control">' .
                                                        '<option value="" disabled="disabled">Select option</option>';
                                            $options = explode(':', $setting->key_options);
                                            foreach($options as $option)
                                                {
                                                    $selected = "";
                                                    if($option == $setting->value)
                                                        $selected = " selected='selected' ";

                                                    $input .= '<option value="'. $option .'" '.$selected.' >'. $option .'</option>';
                                                }
                                            $input .= '</select>';
                                        }
                                    else
                                        if(in_array($setting->type , array('text','email', 'number')))
                                        {
                                            $input .= '<input type="'. $setting->type .'" name="'. $setting->key .'" class="form-control" value="'. $setting->value .'" />';
                                        }
                                    ?>
						<?php if ( $setting->type != 'textarea') {?>	
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"  >
                                    <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-3">
                                        <?php
                                        echo "<strong class='ib mt-sm'>".$setting->title."</strong>";
                                        ?>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-6"><?php echo $input. "<small>".$setting->description."</small>";?></div>


                                </div>
						<?php } ?>
								
							<?php if ( $setting->type == 'textarea') {?>	
							<div v-if="communitySelectionFlag" class="col-lg-12 col-md-12 col-xs-12 col-sm-12" >
							   <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-3"><strong class='ib mt-sm'>Selected Community</strong></div>
							   <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-6">
								  <input @change="hidesuggestions()"  @keyup="selectCommunity($event)" v-model="search" type="text" class="form-control input_icon" placeholder="gruppnamn" name="selected_community" autocomplete="off">
								  <!--- <small>Selected Community</small> -->
								  {{--suggestion boxx--}}
								  <div id="suggestion-box" class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
									 <div class="tt-dataset tt-dataset-cars">
										<div @click="selectedVal(suggestion.community_code, suggestion.community_title)" v-for="suggestion in suggestions" class="tt-suggestion tt-selectable">
										   <strong class="tt-highlight">@{{suggestion.community_title}}</strong>
										</div>
									 </div>
								  </div>
								  {{--suggestion box end--}}
							   </div>
							</div>
							
							<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
								 <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-3"><strong class='ib mt-sm'>Single Community</strong></div>
								  <div class="form-group col-lg-4 col-md-4 col-xs-12 col-sm-6">
								   <input type="radio" name="single_community_flag" :checked="communitySelectionFlag == 1" value="1" @change="changeCommunitySelection($event)" > Yes<br>
								   <input type="radio" name="single_community_flag" name="abc" :checked="communitySelectionFlag == 0" value="0" @change="changeCommunitySelection($event)" > No<br>
								  </div>
							</div>
							
							<?php } ?>
							
                            <?php
                                }
                            ?>
		
						
						
					
					
                        <div class="col-lg-12">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </div>

                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/admin/vuejs/setting.js') }}"></script>
@endsection