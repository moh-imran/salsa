@extends('layouts.app')

@section('content')
<!-- Error wrapper -->
<div class="container-fluid text-center">
    <h1 class="error-title">404</h1>
    <h6 class="text-semibold content-group">Oops, an error has occurred. Page not found!</h6>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
            {{--<form action="{{ url('/') }}" class="main-search">--}}
                {{--<div class="input-group content-group">--}}
                    {{--<input type="text" class="form-control input-lg" placeholder="Search">--}}

                    {{--<div class="input-group-btn">--}}
                        {{--<button type="submit" class="btn bg-slate-600 btn-icon btn-lg"><i class="icon-search4"></i></button>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="row">
                    <div class="col-sm-offset-3 col-sm-6">
                        <a href="javascript:window.history.back();" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i> Go Back</a>
                    </div>

                </div>
            {{--</form>--}}
        </div>
    </div>
</div>
<!-- /error wrapper -->
@endsection