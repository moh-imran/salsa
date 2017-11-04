   @extends('user.partials.masterpage')
    @section('content')
    <style>
        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <main>
    <div class="content">
        <div class="title m-b-md" style="padding-top:10%">
            Welcome
        </div>
    </div>
    </main>
    <script>
$(document).ready(function(){
   $('main').css('min-height',window.screen.availHeight+'px'); 
});
</script>
    @endsection