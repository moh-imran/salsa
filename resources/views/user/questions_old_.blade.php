@extends('user.partials.masterpage')

@section('content')
<div class="top_banner">
            <div class="banner_text">
                <h1>Vi hjälper dig hitta rätt</h1>
                <span>Skolguiden.nu hjälper dig sortera, jämföra och välja skola.</span>
            </div>
        </div>
        <div class="title_text mb-15">
        <span>Idag är det 43 dagar kvar</span>
    </div>
<main id="register">
    
    <section id="container">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
<!--                    <div class="school_line">
                        <span class="line_text">Användaruppgifter</span>

                        <span class="line_text">Betala</span>

                        <span class="line_text">Färdig</span>

                        <span class="img-circle status_circle circle_green" style="left: 0%; z-index: 1;"></span>
                        <span class="img-circle status_circle circle_inactive" style="left: 47%; z-index: 1;"></span>

                        <span class="img-circle status_circle circle_inactive" style="left: 96%; z-index: 2;"></span>
                    </div>-->


                    <div class="text-center">

                        <h1 class="heading_text on_pc">Account Info</h1>
                        <div class="line"></div>
                        <p>Your account info .</p>

                    </div>
                    <form  role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="text-center login_controls">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
<!--                                <input type="text" name="" class="form-control input_control" placeholder="E-postadress">-->
                                <input type="text" class="form-control input_control" id="name" name="name" placeholder="Namn" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" class="form-control input_control" id="email" name="email" placeholder="E-postadress" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif            
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" class="form-control input_control" id="password" name="password" placeholder="Lösenord" required>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control input_control" id="password-confirm" placeholder="Bekräfta lösenord" name="password_confirmation" required>
                            </div>

<!--                            <input type="text" name="" class="form-control input_control" placeholder="Lösenord">-->
                        </div>

                        <button class="btn btn-block btn_custom btn_login btn_null mb-15">Gå vidare till betalning</button>
                    </form>
                    <div class="text-center signup_link on_mobile_i_b">
                        Har du inget konto? <a href="javascript:;" class="">Skapa konto här</a>
                    </div>
                </div>
            </div>

        </div>

        <!--        </div>-->
    </section>
</main>
@endsection