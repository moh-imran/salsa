@extends('layouts.app')

@section('content')
        <!-- Error wrapper -->
<div class="container-fluid text-center">

    <h1 class="error-title offline-title">Please sit tight!</h1>
    <br /><br />
    <h1 class="text-semibold" style="font-size: 24px !important; color:#fff">We are updating our website.. we will be back in a minute.  Thanks!</h1>
    <br />
    <br />
    <a href="{{ url('/') }}" class="btn btn-info">Refresh</a>
</div>
<!-- /error wrapper -->
@endsection