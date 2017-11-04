
<fieldset class="content-group">

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Title</label>
        <div class="col-lg-10">
            {!! Form::text('title', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Group</label>
        <div class="col-lg-10">
            {!! Form::text('group', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Key</label>
        <div class="col-lg-10">
            {!! Form::text('key', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Key Options</label>
        <div class="col-lg-10">
            {!! Form::text('key_options', null ,['class'=> 'form-control']) !!}
        </div>
    </div>


    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label style="padding-top: 0px;" class="control-label col-lg-2">Value</label>
        <div class="col-lg-10">
            {!! Form::text('value', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
    </div>
    </div>
</fieldset>