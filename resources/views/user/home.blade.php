@extends('user.partials.masterpage')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<main id="login">

    <div class="modal fade" id="myModal" style="z-index:10000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>SALSA-modellen räknar ut vad en skolas genomsnittliga betygsnivå borde vara med hänsyn tagen till tre bakgrundsfaktorer; vilken utbildningsnivå föräldrarna har, andelen nyinvandrade elever kombinerat med elever med okänd bakgrund samt andelen pojkar och flickor. Den förväntade betygsnivån jämförs därefter med de betyg som eleverna faktiskt fått. Resultatet är ett SALSA-värde.</p>
                    
                    <p>Ett positivt SALSA-resultat visar att skolan har presterat bättre än förväntat. Det pekar mot att skolans kvalitet är hög. Ett negativt SALSA-resultat visar å andra sidan att skolan har underpresterat i förhållande till elevernas förutsättningar.</p>
                    <p>SALSA-modellen är utvecklad av Skolverket.</p>
                   <p> De bakgrundsfaktorer som ingår i den statistiska modellen förklarar 63 % av variationen i skolors resultat (läsåret 2014/15). 37 % av variationen beror på andra faktorer. SALSA-värden för landets skolor samlas i databasen SIRIS och det är därifrån som Skolguiden.nu hämtar alla data. </p>
                   <p> Men kan man lita på betygen? Sätter inte vissa skolor ”glädjebetyg” för att bli mer attraktiva? Jo, det händer. Därför har vi jämfört betygsresultaten med resultaten på nationella prov. Om vi har funnit att dessa avviker för mycket så har vi satt ut en varningstriangel. </p> 
                   <p> Triangeln varnar för att en skolas betygsnivåer inte stämmer med vad eleverna faktiskt kan – eller i alla fall har visat att de kan på de nationella proven. Ibland är betygen för låga – ibland för höga. Det är vanligare att en skola sätter för höga än för låga betyg. När du ser varningstriangeln så ska du därför vara försiktig med att dra slutsatser av de faktiska betygsresultaten.</p>
                </div>
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
        <section id="container" class="start_page">
            <div class="clearfix"></div>
            <div class="container container_custom">
 
                <div class="row">

                    <div class="col-md-8 col-md-offset-2 text-center">
                        <div class="text-center">
                            <h1 class="heading_text">Hur bra presterar ditt barns skola?</h1>
                            <span class="heading_line"></span>
                            <div class="text-center">
                                <p class="about_text">Inte bara skolever får betyg utan också skolorna. De bedöms med en metod som heter SALSA som visar hur skolor presterar i årskurs nio. SALSA tar hänsyn till bakgrundsfaktorer som till exempel föräldrarnas utbildningsnivå. 
                                    Se vilka skolor som presterar högst och lägst i din kommun.
                                </p>
                                <p class="about_text" style="cursor: pointer;" data-toggle="modal" data-target="#myModal"> Läs mer om SALSA...</p>
                            </div>
                        </div>

                        <div v-if="single_community_flag" class="input_icon_container input_icon_container_2">
<!--                            <a @click="loadCurrentLocation()" href="javascript:;" id="community_btn" class="icon_btn"></a>-->
                        <input @change="hidesuggestions()" v-on:keyup.enter="compareShools()"  v-model="search" type="text" class="form-control input_icon" placeholder="Välj kommun - gratis" readonly="">
                        <div class="text_right_center login_controls">
                             <a class="btn btn-block btn_custom btn_login_2"  v-on:click="compareShools()">Se Skolresultat</a>
                         </div>
                           
                        </div>
                        
                        <div v-if="!single_community_flag" class="input_icon_container input_icon_container_2">
                            <a @click="loadCurrentLocation()" href="javascript:;" id="community_btn" class="icon_btn"></a>
                        <input @change="hidesuggestions()" @keyup="selectCommunity($event)" v-on:keyup.enter="compareShools()"  v-model="search" type="text" class="form-control input_icon" placeholder="Välj kommun - gratis">
<!--                        <div class="text_right_center login_controls">
                             <a class="btn btn-block btn_custom btn_login_2"  v-on:click="compareShools()">Se Skolresultat</a>
                         </div>-->
                            {{--suggestion boxx--}}
                            <div id="suggestion-box" class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                                <div class="tt-dataset tt-dataset-cars">
                                    <div @click="selectedVal(suggestion.community_code, suggestion.community_title)" v-for="suggestion in suggestions" class="tt-suggestion tt-selectable">
                                        <strong class="tt-highlight">@{{suggestion.community_title}}</strong>
                                    </div>
                                </div>
                            </div>
                            {{--suggestion box end--}}
                        </div>
                        

                        <div class="input_icon_container input_icon_container_2">
                           <a class="btn btn-block btn_custom btn_login_2"  href="{{url('premium')}}">
                               Skolguiden Premium <br/>
                               99 kronor engångsavgift för att se alla skolors resultat
                           </a>
                        </div>
                    </div>
                </div>

            </div>

            </div>
        </section>
    </main>
<script src="{{asset('js/user/vuejs/home.js')}}"></script>
@endsection