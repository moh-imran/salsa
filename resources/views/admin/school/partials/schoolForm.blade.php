
<fieldset class="content-group">

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Code</label>
        <div class="col-lg-10">
            {!! Form::text('code', null ,['class'=> 'form-control', 'diaabled' => '']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Title</label>
        <div class="col-lg-10">
            {!! Form::text('title', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Community</label>
        <div class="col-lg-10">
            {!! Form::select('community_code', $communities, null, ['placeholder' => 'Select a community', 'class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-2">Type</label>
        <div class="col-lg-10">
            {!! Form::select('is_public', [1 => 'Kommunal', 2=> 'Enskild', 3 => 'Landsting'], null, ['placeholder' => 'Select is public', 'class' => 'form-control']) !!}
        </div>
    </div>


    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label style="padding-top: 0px;" class="control-label col-lg-2">Street Address</label>
        <div class="col-lg-10">
            {!! Form::text('street_address', null ,['class'=> 'form-control']) !!}
        </div>
    </div>


    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label style="padding-top: 0px;" class="control-label col-lg-2">Post Area</label>
        <div class="col-lg-10">
            {!! Form::text('post_area', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
    </div>
    </div>
</fieldset>