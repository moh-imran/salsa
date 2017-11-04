@extends('user.partials.masterpage')

@section('content')
    <div class="top_banner">
        <div class="banner_text">

        </div>
    </div>
<!--    <div class="title_text border_top_none">
        <span>Idag är det 43 dagar kvar</span>
    </div>-->
    <div class="container-fluid">
        <main id="profile_edit" class="contact_page">
            <section id="container">
                <div class="clearfix"></div>
                <div class="container container_custom">

                    <div class="row">

                        <div class="col-md-12 text-left">

                                <h1 align="center">Kontakt</h1>
                                <div class="line">&nbsp;</div>
                                <div class="text-center">
                                    <p class="about_text">Här kan du komma i kontakt med Skolguiden: Du kan lämna synpunkter på innehållet, tipsa om något saknas eller om något som bör ändras. Vi har dock ingen möjlighet att besvara frågor kring skolornas resultat. 
                                        Den typen av frågor bör du istället ställa direkt till berörd skola.</p>
                                    <p class="about_text">Med vänlig hälsning<br>
                                        Skolguiden.nu</p>
                                </div>
                    </div>
                    <div class="col-md-8 col-md-offset-2 text-center">
                                <form class="loginform" role="form" method="POST" action="{{ url('/contact') }}">

                                    @if (Session::has('success'))
                                        <div class="alert alert-success alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ Session::get('success') }}</strong>
                                        </div>
                                    @endif
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ Session::get('errors')}}</strong>
                                        </div>
                                    @endif

                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <input type="text" class="form-control input_control input_control_rounded" id="name" name="name" placeholder="namn"
                                               value="{{ old('name') }}" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input type="email" class="form-control input_control input_control_rounded" id="email" name="email"
                                               placeholder="E-postadress" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                                        @endif
                                    </div>
                                <!--            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <input type="text" class="form-control input_control input_control_rounded" id="subject" name="subject" placeholder="ämne" required>

                @if ($errors->has('subject'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                </span>
                @endif
                                        </div>-->

                                    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                        <textarea class="form-control input_control input_control_rounded" rows="5" id="message" name="message"
                                                  placeholder="Ärende" required></textarea>
                                        @if ($errors->has('message'))
                                            <span class="help-block">
                    <strong>{{ $errors->first('message') }}</strong>
                </span>
                                        @endif
                                    </div>

                                    <button type="submit" class="login">Skicka</button>
                                </form>
                            </div>
                        </div>

                    </div>
            </section>
        </main>
    </div>
@endsection