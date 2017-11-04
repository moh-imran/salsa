<fieldset class="content-group">

    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
        <div class="form-group2">
            <div class="col-lg-4"><label class="bold nowrap">File Name</label></div>
            <div class="col-lg-8"><label><span>{{$file->key}}</span></label></div>
        </div>
        <div class="form-group2">
            <div class="col-lg-4"><label class="bold nowrap">File Size (KB)</label></div>
            <div class="col-lg-8"><label><span>{{$file->file_size}}</span></label></div>
        </div>
        <div class="form-group2">
            <div class="col-lg-4"><label class="bold nowrap">Checksum</label></div>
            <div class="col-lg-8"><label><span>{{$file->checksum_of_last_file}}</span></label></div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 mb-20">
        <div class="form-group2">
            <div class="col-lg-4"><label class="bold nowrap">Version Number</label></div>
            <div class="col-lg-8"><label><span>{{$file->version_no}}</span></label></div>
        </div>
        <div class="form-group2">
            <div class="col-lg-4"><label class="bold nowrap">Status</label></div>
            <div class="col-lg-8"><label><span>{{$file->status}}</span></label></div>
        </div>
        <div class="form-group2">
            <div class="col-lg-4"><label class="bold nowrap">Server Path</label></div>
            <div class="col-lg-8"><label><span>{{$file->relative_path_on_server}}</span></label></div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-lg-2">Download URL</label>
        <div class="col-lg-10">
            {!! Form::text('download_url', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-2">From Year</label>
        <div class="col-lg-10">
            {!! Form::text('from_year', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-2">To Year</label>
        <div class="col-lg-10">
            {!! Form::text('to_year', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-2">First Data Row</label>
        <div class="col-lg-10">
            {!! Form::text('first_data_row', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-2">Description</label>
        <div class="col-lg-10">
            {!! Form::textarea('description', null ,['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
    </div>
</fieldset>