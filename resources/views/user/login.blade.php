@extends('user.partials.masterpage')

@section('content')
<main id="login">
    <section id="container">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">

                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="text-center">
                        <h1 class="heading_text">Välkommen till Skolguiden Premium</h1>
<!--                        <span class="heading_line"></span>-->
                        <h3 class="sub_heading">Logga in eller läs mer och skapa ett konto</h3>

                        <!-- <img src="{{'assets/images/logo.png'}}" class="img-responsive on_mobile_i_b logo_login" alt="Logo"> -->
                    </div>
                    <form  role="form" method="POST" action="{{ url('/login') }}" >

                        <div class="text-center login_controls">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
<!--                            <input type="text" name="" class="form-control input_control" placeholder="E-postadress">-->
                                <input type="email" class="form-control input_control " name="email" placeholder="E-postadress" value="{{ old('email') }}" oninvalid="this.setCustomValidity('Ange en giltig e-postadress')"  oninput="setCustomValidity('')" required autofocus >
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
<!--                            <input type="text" name="" class="form-control input_control" placeholder="Lösenord">-->
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" class="form-control input_control" placeholder="Lösenord" name="password" name="password" oninvalid="this.setCustomValidity('Var vänlig fyll i det här fältet')"  oninput="setCustomValidity('')" required >
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="text_right_center login_controls">
                            <!-- <div class="reverse"> -->
                                <a href="{{ url('/password/reset') }}" class="custom_link">Glömt lösenord?</a>
                                <button type='submit' class="btn btn-block btn_custom btn_login">Logga in</button>
                            <!-- </div> -->
                        </div>
                        {{ csrf_field() }}
                    </form>
                    <div class="line"></div>

                    <div class="text-center signup_link">
                        <!-- <span class="on_mobile_i_b">Har du inget konto?</span>--> <a href="{{url('/register')}}" class="btn btn-block btn_custom btn_login btn_null">Läs mer och skapa konto <!--<span class="on_mobile_i_b">här</span> --></a> 
<!--                        <a href="{{ url('/register') }}" class="custom_link">Läs mer och skapa konto</a>-->
                    </div>



                </div>
            </div>

        </div>
<!--        <div class="clearfix"></div>
        <div class="text-center" style="margin-bottom: 20px;"> 

              <a href="{{ url('/register') }}" class="custom_link">Läs mer och skapa konto</a>
       </div>-->

        <!--            </div>-->
    </section>
</main>
<script>
        $(document).ready(function() {

            // var classes = $('.signup_link a').attr('class');
            // if (viewport().width <= 767) {
            //     $('.signup_link a').removeAttr('class');
            // } else {
            //     $('.signup_link a').attr('class', classes);
            // }

            // $(window).resize(function() {
            //     if (viewport().width <= 767) {
            //         $('.signup_link a').removeAttr('class');
            //     } else {
            //         $('.signup_link a').attr('class', classes);
            //     }
            // });

            function viewport() {
                var e = window,
                    a = 'inner';
                if (!('innerWidth' in window)) {
                    a = 'client';
                    e = document.documentElement || document.body;
                }
                return {
                    width: e[a + 'Width'],
                    height: e[a + 'Height']
                };
            }
        });
    </script>
@endsection