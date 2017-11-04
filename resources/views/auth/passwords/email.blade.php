@extends('user.partials.masterpage')

@section('content')
<main id="login">
    <section id="container">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">

                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="text-center">
                        <h1 class="heading_text">Har du glömt ditt lösenord?</h1>
                        <span class="heading_line"></span>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form  role="form" method="POST" action="{{ url('/password/email') }}" >
                        {{ csrf_field() }}    
                        <div class="text-center login_controls input_forgot {{ $errors->has('email') ? ' has-error' : '' }}">
<!--                            <input type="text" name="" class="form-control input_control" placeholder="E-postadress">-->
                            <input type="email" class="form-control input_control" name="email" placeholder="E-postadress" value="{{ old('email') }}" oninvalid="this.setCustomValidity('Ange en giltig e-postadress')"  oninput="setCustomValidity('')" required>
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="text_right_center login_controls">
                            <button type="submit" class="btn btn-block btn_custom btn_forgot">Återställ lösenord</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        </div>
    </section>
</main>
@endsection