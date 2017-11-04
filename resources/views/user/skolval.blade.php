@extends('user.partials.masterpage')
@section('content')
<main id="skolval">

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


    <section id="container" class="single_skolval">
        <div class="clearfix"></div>
        <!--        <div class="title_text">
                    <span>Idag är det 43 dagar kvar</span>
                </div>-->

        <div class="container container_custom" style="margin-top: 50px; background:#fff">

            <div class="row">

                <div class="col-md-8 col-md-offset-2 text-center">
                    <div v-if="single_community_flag == 1" class="text-center">

                        <div class="input_icon_container">
<!--                            <a @click="loadCurrentLocation()" href="javascript:;" id="community_btn" class="icon_btn"></a>-->
<input @change="hidesuggestions()" v-on:keyup.enter="loadSchools(1)"  v-model="search" type="text" class="form-control input_icon" placeholder="gruppnamn" readonly="">
                            
                        </div>

                    </div>
                    
                <div v-if="single_community_flag == 0" class="text-center">

                        <div class="input_icon_container">
                            <a @click="loadCurrentLocation()" href="javascript:;" id="community_btn" class="icon_btn"></a>
<input @change="hidesuggestions()" v-on:keyup.enter="loadSchools(1)" @keyup="selectCommunity($event)"  v-model="search" type="text" class="form-control input_icon" placeholder="gruppnamn" >
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

                    </div>

                    <p class="text_gen">Punkterna på linjen representerar grundskolorna med årskurs nio i <b> @{{search}} </b> och hur de ligger till i jämförelse med andra svenska skolor enligt Skolverkets SALSA-värden.</p>
                    <p style="font-size: 14px; font-weight: 500; font-style: normal; font-stretch: normal;">I tabellen visas SALSA-värden för skolorna med lägst och högst resultat i <b> @{{search}}. </b> </p>
                    <p style="font-size: 14px; font-weight: 500; font-style: normal; font-stretch: normal;"> I Skolguiden Premium kan du jämföra alla skolor med SALSA-resultat och även se detaljerade resultat ner på ämnesnivå.</p>
                    <p><span style="cursor:pointer;" data-toggle="modal" data-target="#myModal">Läs mer om SALSA…</span></p>
                    <div class="line"></div>
                    <div class="clearfix"></div>
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

                    <div class="clearfix"></div>
                    <div class="school_line">
                        <span class="line_text">Lägst i Sverige</span>

                        <span class="line_text">Medel i Sverige</span>

                        <span class="line_text">Högst i Sverige</span>


                        <span v-for="school in slider_schools" :style="school.style"
                              class="img-circle status_circle " :class="school.amp_residual_value_f_b_class"></span>
                    </div>
                    <div class="clearfix"></div>

                    <div class="boxes_container">
                        <div class="rating">
                            <div class="rating_text">
                                Meritvärde/betyg
                            </div>

                            <div class="rating_line">

                            </div>

                            <img src="{{asset('assets/images/info_con.svg')}}" alt="" style="cursor:pointer;" class="result_icon on_pc" data-toggle="popover" title="" data-placement="right" data-content="<p>En skolas betygsresultat avgörs i stor utsträckning av elevernas socioekonomiska förutsättningar. Det är inte säkert att skolor med höga meritvärden presterar tillräckligt bra och inte heller att skolor med låga meritvärden underpresterar. </p>
                                 För att kunna bedöma det har Skolverket utvecklat analysverktyget SALSA. SALSA jämför en skolas betygsresultat i årskurs 9 med det förväntade resultatet efter att hänsyn tagits till elevsammansättningen.
                                 Skolguiden.nu bygger på Skolverkets SALSA-siffror.   <br><a  data-toggle='modal' href='#myModal' data-dismiss='modal'  class='custom_link'>Läs mer om SALSA</a>" id="close_1" data-html="true" data-original-title="<a href='javascript:;' onclick='$(&quot;#close_1&quot;).popover(&quot;hide&quot;);' data-toggle='popover'>×</a>">
                            <a data-toggle="modal"  href="#myModal" class="on_mobile_i_b"><img  src="{{asset('assets/images/info_con.svg')}}" alt="" style="cursor:pointer;" class="result_icon"></a>
                        </div>

                        <div class="left_box">
                            <div class="box_title">

                                <div class="status_container">
                                    <table>
                                        <tbody><tr>
                                                <td><span class="img-circle status_circle" :class="lastSchool.amp_residual_value_f_b_class" id="min_schhol_number" ></span></td>
                                                <td><span class="status_text" id="min_school_name">@{{ lastSchool.title }}</span></td>
                                            </tr>
                                        </tbody></table>
                                </div>

                            </div>

                            <div class="result_container">
                                <div class="result_text">
                                    SALSA-resultat
                                    <div class="clearfix"></div>
                                </div>

                                <div id="salsa_result_min" class="result_box" :class="lastSchool.amp_residual_value_f_b_class">
                                    @{{ lastSchool.amp_residual_value_f_b }}
                                </div>

                                <div  class="result_text">
                                    Uppnått meritvärde
                                    <img src="{{asset('assets/images/warning_icon.svg')}}" alt="" class="result_icon" v-if="lastSchool.triangle_count > schoolWarningThreshold" data-toggle="modal" data-target="#warningModal">
                                    <div class="clearfix"></div>
                                </div>

                                <div id="achieved_result_min" class="result_box result_null" >
                                    @{{ lastSchool.amp_actual_value_f }}
                                </div>

                                <div class="result_text">
                                    Förväntat meritvärde
                                    <div class="clearfix"></div>
                                </div>

                                <div id="expected_result_min" class="result_box result_null" >
                                    @{{ lastSchool.amp_model_calc_value_b }}
                                </div>
                            </div>
                        </div>

                        <div class="right_box">
                            <div class="box_title">
                                <div class="status_container">
                                    <table>
                                        <tbody><tr>
                                                <td><span class="img-circle status_circle" :class="topSchool.amp_residual_value_f_b_class" id="max_school_number"></span></td>
                                                <td><span class="status_text" id="max_school_name">@{{ topSchool.title }}</span></td>
                                            </tr>
                                        </tbody></table>
                                </div>

                            </div>

                            <div class="result_container">
                                <div class="result_text">
                                    SALSA-resultat
                                    <div class="clearfix"></div>
                                </div>

                                <div id="salsa_result_min" class="result_box " :class="topSchool.amp_residual_value_f_b_class">
                                    @{{ topSchool.amp_residual_value_f_b }}
                                </div>

                                <div  class="result_text">
                                    Uppnått meritvärde
                                    <img src="{{asset('assets/images/warning_icon.svg')}}" alt="" class="result_icon" v-if="topSchool.triangle_count > schoolWarningThreshold" data-toggle="modal" data-target="#warningModal">
                                    <div class="clearfix"></div>
                                </div>

                                <div id="achieved_result_min" class="result_box result_null" >
                                    @{{ topSchool.amp_actual_value_f }}
                                </div>

                                <div class="result_text">
                                    Förväntat meritvärde
                                    <div class="clearfix"></div>
                                </div>

                                <div id="expected_result_min" class="result_box result_null" >
                                    @{{ topSchool.amp_model_calc_value_b }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!is_paid_user())
                        <a class="btn btn-block btn_custom btn_search" style="color:white;" href="{{url('/premium')}}">
                            Skolguiden Premium <br/>
                            99 kronor engångsavgift för att se alla skolors resultat
                        </a>
                    @endif
                </div>

            </div>

        </div>
    </section>


</main>

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/user/vuejs/skolval.js') }}"></script>

<script>
$(document).ready(function () {

    $('[data-toggle="popover"]').popover();

    $('#skolval').on('click', '.custom_link', function () {
        $('[data-toggle="popover"]').popover('hide');
    });

//     $('#container .custom_link').on('click', function(e) {
//         //$('[data-toggle="popover"]').popover('hide');
//         
//     });
//    $(".input_icon").on("change", function () {
//
//        var zi = 1;
//        setTimeout(function () {
//            $('.school_line .status_circle:not(.circle_inactive)').each(function () {
//                $(this).css('z-index', zi);
//                //alert(zi);
//                zi++;
//            });
//
//            var check_height_new = 0;
//            var check_height_1 = $(".box_title:eq(0)").outerHeight();
//            var check_height_2 = $(".box_title:eq(1)").outerHeight();
//
//            if (check_height_1 > check_height_2) {
//                check_height_new = check_height_1 + 2;
//                $(".box_title").css("line-height", check_height_new + "px");
//            } else {
//                check_height_new = check_height_2 + 2;
//                $(".box_title").css("line-height", check_height_new + "px");
//            }
//            
//            alert(check_height_1);
//            alert(check_height_2);
//        }, 1000);
//    });
});


</script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

<div class="modal fade" id="warningModal" style="z-index:10000; margin-top: 115px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Risk för att meritvärdet inte är korrekt. Skolan har flera varningstrianglar på ämnesbetygen.</p>
                {{--<p>En skolas betygsresultat avgörs i stor utsträckning av elevernas socioekonomiska förutsättningar. Det är inte säkert att skolor med höga meritvärden presterar tillräckligt bra och inte heller att skolor med låga meritvärden underpresterar. </p>--}}
                {{--<p>För att kunna bedöma det har Skolverket utvecklat analysverktyget SALSA. SALSA jämför en skolas betygsresultat i årskurs 9 med det förväntade resultatet efter att hänsyn tagits till elevsammansättningen. Skolguiden.nu --}}
                    {{--bygger på Skolverkets SALSA-siffror.</p> --}}
            </div>
        </div>
    </div>
</div> 
@endsection