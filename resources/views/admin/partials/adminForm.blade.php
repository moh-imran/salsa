@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<fieldset class="content-group">

    <div class="form-group">
        <label class="control-label col-lg-2">Name</label>
        <div class="col-lg-10">
            {!! Form::text('name', null ,['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-lg-2">Email</label>
        <div class="col-lg-10">
            {!! Form::email('email', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-2">Phone</label>
        <div class="col-lg-10">
            {!! Form::text('phone', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
</fieldset>