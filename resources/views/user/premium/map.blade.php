@extends('user.partials.masterpage')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<main id="premium">
    <div class="modal fade"  id="myModal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        En skolas betygsresultat avgörs i stor utsträckning av elevernas socioekonomiska förutsättningar. Det är inte säkert att skolor med höga meritvärden presterar tillräckligt bra och inte heller att skolor med låga meritvärden underpresterar.
                                                        För att kunna bedöma det har Skolverket utvecklat analysverktyget SALSA.
                                                        SALSA jämför en skolas betygsresultat i årskurs 9 med det förväntade resultatet efter att hänsyn tagits till elevsammansättningen. Skolguiden.nu bygger på Skolverkets SALSA-siffror. 

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!--    <div class="top_banner  on_pc">
        <div class="banner_text">
            <h1>Vi hjälper dig hitta rätt</h1>
            <span>Skolguiden.se hjälper dig jämföra och välja skola.</span>
        </div>
    </div>-->

    <section id="map_search">
        <div class="title_text on_pc">
            <span></span>
        </div>

        <div class="map_main">
            
         
                
            <div class="map" id="map">
                

                
                
            </div>

            <div class="map_box">
                Klicka på <strong>1</strong> eller <strong>2</strong> skolor som du vill undersöka
            </div>
            <div class="map_box">
                Du har markerat <strong>1 skola</strong> markera minst <strong>1</strong> till för att börja jämföra
            </div>
            
            <div class="map_box">
                <form id="schools_form" method="post" action="{{ url('school-comparison') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                Du har markerat <strong id="selected_schools">2 skolor</strong><br>
                <button class="btn btn_custom btn-sm btn_compare">Jämför</button>

                  </form> 
            </div>
            
            <form style="display:none;" id="one_schools_form" method="post" action="{{ url('school-comparison') }}">
                    <input type="hidden" id="hideen" name="_token" value="{{ csrf_token() }}">

            </form>
             
            
        </div>

                                                
        
        
        <div class="container container_custom">

            <div class="row">

                <div class="col-md-8 col-md-offset-2 text-center">
                    <p class="text-center" style="color: #000;"><strong>Jämför skolornas SALSA-resultat:</strong></p>
                    <div class="status_container">
                        <span class="img-circle status_circle circle_red"></span> <span class="status_text">Mycket under</span>
                    </div>

                    <div class="status_container">
                        <span class="img-circle status_circle circle_orange"></span> <span class="status_text">Under</span>
                    </div>

                    <div class="status_container">
                        <span class="img-circle status_circle circle_yellow"></span> <span class="status_text">Medel</span>
                    </div>


                    <div class="status_container">
                        <span class="img-circle status_circle circle_green"></span> <span class="status_text">Över</span>
                    </div>

                    <div class="status_container">
                        <span class="img-circle status_circle circle_blue"></span> <span class="status_text">Mycket över</span>
                    </div>
                    
                    <div style="display:none;" v-if="single_community_flag == 1" class="input_icon_container">
<!--                        <a @click="loadCurrentLocation()" href="javascript:;" class="icon_btn"></a>-->
                    <input @change="hidesuggestions()"   v-model="search" type="text" name="" class="form-control input_icon" placeholder="gruppnamn" readonly="">
                       
                    </div>
                    <div style="display:none;" v-if="single_community_flag == 0" class="input_icon_container">
                        <a @click="loadCurrentLocation()" href="javascript:;" class="icon_btn"></a>
                        <input @change="hidesuggestions()" v-on:keyup.enter="loadSchools(1)" @keyup="selectCommunity($event)" v-model="search" type="text" name="" class="form-control input_icon" placeholder="gruppnamn">
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
                    <button style="display:none;"  v-on:click="loadSchools(1)" class="btn btn-block btn_custom btn_search">Sök skolor</button>
                </div>

            </div>

            
        </div>
    </section>
</main>
<style>
    #map * {
        font-family: inherit;
    }

    .gm-style-iw {
        text-align: center;
    }

    .gm-style-iw>div {
        overflow: visible
    }

    .gm-style-iw p {
        margin: 0;
        padding: 0;
        font-size: 13px;
        color: #000;
        margin-top: 10px;
        text-align: left;
    }

    .gm-style-iw a {
        font-size: 13px;
        font-weight: bold;
        text-decoration: underline;
        color: #000 !important;
    }

    .compare_check {
        min-width: 147px;
        max-width: 100%;
        min-height: 30px;
        border-radius: 4px;
        background-color: #242424;
        text-align: center;
        line-height: 25px;
        display: inline-block;
        margin-top: 10px;
        padding: 0 16px;
        padding-top: 2px;
    }
    /*.compare_checkbox:not(:nth-child(2)) {
        margin-left: 5px;
    }*/

    .chk_after {
        display: inline-block
    }

    .chk_after .compare_checkbox {
        margin-left: 5px;
    }

    .compare_check label {
        font-size: 13px;
        font-weight: bold;
        font-style: normal;
        font-stretch: normal;
        letter-spacing: -0.2px;
        text-align: left;
        color: #ffffff;
        margin-bottom: 0;
        vertical-align: middle;
        cursor: pointer;
    }

    .compare_check .compare_checkbox {
        display: none;
    }

    .compare_check .compare_checkbox+label:after{
        content: url('assets/images/checkbox.svg');
        display: inline-block;
        height: 14px;
        width: 14px;
        vertical-align: sub;
        margin-left: 5px;
        box-sizing: border-box;
    }

    .compare_check .compare_checkbox:checked+label:after {
        content: url('assets/images/checkbox_checked.svg');
        display: inline-block;
        height: 14px;
        width: 14px;
        vertical-align: sub;
        margin-left: 5px; 
        box-sizing: border-box;
    }
    /*
    .gm-style-iw * {
        display: block;
        max-width: 100%;
    }
    .gm-style-iw h4,
    .gm-style-iw p {
        margin: 0;
        padding: 0;
    }
    
    .gm-style-iw a {
        color: #4272db;
    }*/
</style>
<script src="{{asset('js/user/vuejs/map.js')}}"></script>
@endsection

@section('script')


<script language="javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKXrYY2iM1nQZGX4iCErcwt7Geus8NbYE&sensor=false&extension=.js"></script>
 
@endsection