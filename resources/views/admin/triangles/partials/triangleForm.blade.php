<fieldset class="content-group">

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Title</label>
        <div class="col-lg-10">
            {!! Form::text('key', null ,['class'=> 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Participation Warning Value</label>
        <div class="col-lg-10">
            {!! Form::text('participation_warning_value', null ,['class'=> 'form-control']) !!}
            <small class="text-light " style="display: inline-block;padding: 0 10px;">Warning triangle if participation is < X</small>
        </div>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Merit Points Warning Value</label>
        <div class="col-lg-10">
            {!! Form::text('merit_points_warning_value', null ,['class'=> 'form-control']) !!}
            <small class="text-light " style="display: inline-block;padding: 0 10px;">Warning triangle if national test result is > or < than X compared with betygspoäng</small>
        </div>
    </div>

    {{--<div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">--}}
        {{--<label class="control-label col-lg-2" style="white-space: nowrap;">For Free</label>--}}
        {{--<div class="col-lg-10" style="padding-top: 8px;">--}}
            {{--<input name="is_free" id="slide_is_free" type="checkbox" class="slider-toggle" {{ ($triangle->is_free)?'checked':'' }} />--}}
            {{--<label class="slider-viewport light" for="slide_is_free">--}}
                {{--<div class="slider">--}}
                    {{--<div class="slider-button">&nbsp;</div>--}}
                    {{--<div class="slider-content left"><span>Yes</span></div>--}}
                    {{--<div class="slider-content right"><span>No</span></div>--}}
                {{--</div>--}}
            {{--</label>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Status</label>
        <div class="col-lg-10" style="padding-top: 8px; text-align: left;">
                <input name="status" id="slide_status" type="checkbox" class="slider-toggle" {{ ($triangle->status)?'checked':'' }} />
                <label class="slider-viewport light" for="slide_status">
                    <div class="slider">
                        <div class="slider-button">&nbsp;</div>
                        <div class="slider-content left"><span>Active</span></div>
                        <div class="slider-content right"><span>Inactive</span></div>
                    </div>
                </label>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
        {{--<a href="{{url('admin/triangles')}}" class="btn btn-default">Cancel</a>--}}
    </div>
</fieldset>


