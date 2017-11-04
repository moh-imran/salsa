
<fieldset class="content-group">

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Title</label>
        <div class="col-lg-10">
            {!! Form::text('title', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label style="padding-top: 0px;" class="control-label col-lg-2">Use For Deviation</label>
        <div class="col-lg-10">
            {!! Form::select('use_for_deviation', ['1' => 'Yes', '0' => 'No'], null, ['placeholder' => 'Select use for deviation', 'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
        </div>
    </div>
</fieldset>