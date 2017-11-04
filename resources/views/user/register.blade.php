@extends('user.partials.masterpage')

@section('content')
<div class="top_banner on_pc"><div class="banner_text"><h1>Vi hjälper dig hitta rätt</h1> <span>Skolguiden.nu hjälper dig jämföra och välja skola.</span></div></div>
<main id="register">
<!--    <div class="title_text mb-15 on_pc">
        <span>Idag är det 43 dagar kvar</span>
    </div>-->
    <section id="container" class="reg_step_1">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="school_line">
                        <span class="line_text on_pc">Användaruppgifter</span>

                        <span class="line_text on_pc">Betala</span>

                        <span class="line_text on_pc">Färdig</span>

                        <span class="img-circle status_circle circle_green" style="left: 0%; z-index: 1;"></span>
                        <span class="img-circle status_circle circle_inactive" style="left: 47%; z-index: 1;"></span>

                        <span class="img-circle status_circle circle_inactive" style="left: 97%; z-index: 2;"></span>
                    </div>


                    <div class="text-center">

                        <h3>Användaruppgifter</h3>
                        <div class="line"></div>
                        <div class="clearfix"></div>
                        <div class="regiter_text">
                        <p class="gen_text" style="font-size: 13px;">I Skolguiden Premium får du detaljerad information om hur grundskolor I Norrköping har presterat i nionde klass i alla ämnen.</p>

                        <p class="gen_text" style="font-size: 13px; margin-top: 17px !important;">Skolguiden Premium kostar 99 kronor och då kan du använda tjänsten under tre månader.</p>
<!--                        <p class="gen_text" style="font-size: 13px; cursor: pointer;" data-toggle="modal" data-target="#myModal">Läs mer om tjänsten…</p>-->
                        </div>
                    </div>

                </div>

                <div class="col-md-8 col-md-offset-2 text-center">
                    <form  role="form" method="POST" action="{{ url('/register') }}" >
                        {{ csrf_field() }}
                        <div class="text-center login_controls">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
<!--                                <input type="text" name="" class="form-control input_control" placeholder="E-postadress">-->
                                <input type="text" class="form-control input_control" id="name" name="name"  placeholder="Namn" value="{{ old('name') }}" oninvalid="this.setCustomValidity('Var vänlig fyll i det här fältet')"  oninput="setCustomValidity('')"  required autofocus>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" class="form-control input_control"  id="email" name="email" placeholder="E-postadress" value="{{ old('email') }}" oninvalid="this.setCustomValidity('Ange en giltig e-postadress')"  oninput="setCustomValidity('')"  required>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif            
                            </div>
                            <div class="form-group">
                                <input type="password" value="{{Session::get('password')}}"  class="form-control input_control" id="password" name="password" placeholder="Lösenord" oninvalid="this.setCustomValidity('Var vänlig fyll i det här fältet')"  oninput="setCustomValidity('')"  required>

                                
                            </div>
                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password"  class="form-control input_control" id="password-confirm" placeholder="Bekräfta lösenord" name="password_confirmation" oninvalid="this.setCustomValidity('Var vänlig fyll i det här fältet')"  oninput="setCustomValidity('')" required>
                            
                            
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            
                            </div>
                            
                            

<!--                            <input type="text" name="" class="form-control input_control" placeholder="Lösenord">-->
                        </div>

                        <button class="btn btn-block btn_custom btn_login btn_null mb-15">Gå vidare till betalning</button>
                        <p><a href="{{ url('/login') }}" class="custom_link">Har du redan ett konto? Logga in</a></p>
                        
                    </form>
                    
                </div>

            </div>

        </div>
        
    <div class="modal fade" id="myModal" style="z-index:10000;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                   <div class="modal-body">
                    <p>SALSA-modellen räknar ut vad en skolas genomsnittliga betygsnivå borde vara med hänsyn tagen till tre bakgrundsfaktorer; vilken utbildningsnivå föräldrarna har, andelen nyinvandrade elever kombinerat med elever med okänd bakgrund samt andelen pojkar och flickor. Den förväntade betygsnivån jämförs därefter med de betyg som eleverna faktiskt fått. Resultatet är ett SALSA-värde.</p>
                    
                    <p>Ett positivt SALSA-resultat visar att skolan har presterat bättre än förväntat. Ett negativt SALSA-resultat visar å andra sidan att skolan har underpresterat i förhållande till elevernas förutsättningar.</p>
                    <p>SALSA-modellen är utvecklad av Skolverket.</p>
                   <p> De bakgrundsfaktorer som ingår i den statistiska modellen förklarar 63 % av variationen i skolors resultat. 37 % av variationen beror på andra faktorer. SALSA-värden för landets skolor samlas i databasen SIRIS och det är därifrån som skolguiden.se hämtar alla data. </p>
                   <p> Men kan man lita på betygen? Sätter inte vissa skolor ”glädjebetyg” för att bli mer attraktiva? Jo, det händer. Därför har vi jämfört betygsresultaten med resultaten på nationella prov. Om vi har funnit att dessa avviker för mycket så har vi satt ut en varningstriangel på ämnesbetyget. Om för få elever deltagit i det nationella provet har vi satt ut en varningstriangel på andelen som deltagit.</p> 
                   <p> När du ser varningstriangeln så ska du därför vara försiktig med att dra slutsatser av de faktiska betygsresultaten och resultatet i de nationella proven. </p>
                </div>
                </div>
            </div>
    </div>
        
        <!--        </div>-->
    </section>
</main>
@endsection