@extends('user.partials.masterpage')

@section('content')
<div class="container-fluid">
    
    <main>
        @if (Session::has('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ Session::get('success') }}</strong>
        </div>
        @endif
        <p>&nbsp;</p>
<!--        <a href="javascript:;"><img src="{{ asset('assets/images/logo2.png')}}" alt="Logo Not Found" title="Skolguiden.nu" class="img-responsive"></a>-->
        <p>&nbsp;</p>
        

        <p>&nbsp;</p>
        <p>&nbsp;</p>

    </main>
</div>
<script>
$(document).ready(function(){
   $('main').css('min-height',window.screen.availHeight+'px'); 
});
</script>
@endsection