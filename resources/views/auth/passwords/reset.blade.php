@extends('user.partials.masterpage')

@section('content')
<main id="login">
    <section id="container">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">

                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="text-center">
                        <h1 class="heading_text">Återställ ditt lösenord</h1>
                        <span class="heading_line"></span>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form  role="form" method="POST" action="{{ url('/password/reset') }}" >

                        <div class="text-center login_controls input_forgot form-group {{ $errors->has('email') ? ' has-error' : '' }}">
<!--                            <input type="text" name="" class="form-control input_control" placeholder="E-postadress">-->
                            <input type="email" class="form-control input_control" name="email" placeholder="E-postadress" value="{{ old('email') }}" oninvalid="this.setCustomValidity('Ange en giltig e-postadress')"  oninput="setCustomValidity('')" required>
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="text-center login_controls input_forgot form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control input_control" id="password" name="password" placeholder="Nytt lösenord" oninvalid="this.setCustomValidity('Var vänlig fyll i det här fältet')"  oninput="setCustomValidity('')" required>

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="text-center login_controls input_forgot form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input type="password" class="form-control input_control" id="password-confirm" name="password_confirmation" placeholder="Repetera nytt lösenord" oninvalid="this.setCustomValidity('Var vänlig fyll i det här fältet')"  oninput="setCustomValidity('')" required>

                            @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="text_right_center login_controls">
                            <button  class="btn btn-block btn_custom btn_forgot">Återställ lösenord</button>
                        </div>
                        {{ csrf_field() }}    

                        <input type="hidden" name="token" value="{{ $token }}">
                    </form>
                </div>
            </div>

        </div>

        </div>
    </section>
</main>
@endsection