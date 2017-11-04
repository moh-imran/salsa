
<fieldset class="content-group">

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">School</label>
        <div class="col-lg-8">
            {!! Form::select('school_code', $schools, null, ['placeholder' => 'Select a school', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Parents Avg Level Of Education</label>
        <div class="col-lg-8">
            {!! Form::number('bg_parents_avg_level_of_education', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Of Newly Immigrated</label>
        <div class="col-lg-8">
            {!! Form::number('bg_share_of_newly_immigrated', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Of Newly Immigrated</label>
        <div class="col-lg-8">
            {!! Form::number('bg_share_of_newly_immigrated', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Of Born Abroad</label>
        <div class="col-lg-8">
            {!! Form::number('bg_share_of_born_abroad', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Of Foreign Background</label>
        <div class="col-lg-8">
            {!! Form::number('bg_share_of_foreign_background', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Share Of Boys</label>
        <div class="col-lg-8">
            {!! Form::number('bg_share_of_boys', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Actual Value F</label>
        <div class="col-lg-8">
            {!! Form::number('ga_actual_value_f', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Model calc Value B</label>
        <div class="col-lg-8">
            {!! Form::number('ga_model_calc_value_b', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">Residual Value F-B</label>
        <div class="col-lg-8">
            {!! Form::number('ga_residual_value_f-b', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">AMP Actual Value F</label>
        <div class="col-lg-8">
            {!! Form::number('amp_actual_value_f', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">AMP Model Calc Value B</label>
        <div class="col-lg-8">
            {!! Form::number('amp_model_calc_value_b', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">AMP Residual Value F-B</label>
        <div class="col-lg-8">
            {!! Form::number('amp_residual_value_f-b', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-4">AVG Deviation Value</label>
        <div class="col-lg-8">
            {!! Form::number('avg_deviation_value_in_primary_sub', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
    </div>
    </div>
</fieldset>