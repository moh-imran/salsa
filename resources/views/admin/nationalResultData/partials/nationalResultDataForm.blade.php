
<fieldset class="content-group">

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-3">School</label>
        <div class="col-lg-9">
            {!! Form::select('school_code', $schools, null, ['placeholder' => 'Select a school', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-3">Subject</label>
        <div class="col-lg-9">
            {!! Form::select('subject_id', $subjects, null, ['placeholder' => 'Select a subject', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-3">Merit Points</label>
        <div class="col-lg-9">
            {!! Form::number('merit_points', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-3">Share AE</label>
        <div class="col-lg-9">
            {!! Form::number('share_ae', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label style="padding-top: 0px;" class="control-label col-lg-3">Students Participated</label>
        <div class="col-lg-9">
            {!! Form::number('students_participated', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <label class="control-label col-lg-3">Share Participated</label>
        <div class="col-lg-9">
            {!! Form::number('share_participated', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
        </div>
    </div>
</fieldset>