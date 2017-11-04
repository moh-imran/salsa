
<fieldset class="content-group">

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">School</label>
        <div class="col-lg-8">
            {!! Form::select('school_code', $schools, null, ['placeholder' => 'Select a school', 'class' => 'form-control', 'disabled'=> 'disabled']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Qualify Vocational Program</label>
        <div class="col-lg-8">
            {!! Form::number('share_qualify_vocational_program', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Qualify Arts Aestetichs</label>
        <div class="col-lg-8">
            {!! Form::number('share_qualify_arts_aestetichs_program', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Qualify Econ Philos Socialsc Program</label>
        <div class="col-lg-8">
            {!! Form::number('share_qualify_econ_philos_socialsc_program', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Qualify Natural Science Tech Program</label>
        <div class="col-lg-8">
            {!! Form::number('share_qualify_natural_science_tech_program', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Not Qualified</label>
        <div class="col-lg-8">
            {!! Form::number('share_not_qualified', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
        </div>
    </div>
</fieldset>