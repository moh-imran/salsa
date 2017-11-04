@extends('user.partials.masterpage')
@section('style')
    <link href="{{ asset('user_assets/css/mCustomScrollbar.css')}}" rel="stylesheet">
@endsection

@section('content')
    <main id="skolval">
<!--    <div class="title_text">
        <span>Idag är det 43 dagar kvar</span>
    </div>-->
    <section id="container" class="multi_skolval">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">

                <div class="multi_skolval_contaniner text-center" style="font-size: 0">
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

                    <div class="school_line" style="margin-bottom: 35px; margin-top: 90px; background: url('/assets/images/line-salsa.png') repeat-y center; background-size: contain;">
                        <span class="line_text">Lägst i Sverige</span>

                        <span class="line_text">Medel i Sverige</span>

                        <span class="line_text">Högst i Sverige</span>


<!--                        <span v-for="school in slider_schools" :style="school.style"
                              class="img-circle status_circle " :class="school.amp_residual_value_f_b_class"></span>-->
                        
                    </div>

                    <div class="overflow_scroll">
                        <div class="clearfix hidden"></div>
                      
                        <div class="school_line hidden">
                        </div>

                        <div class="clearfix hidden"></div>

                        
      
                        <div class="boxes_container">
                            <div class="rating">
                                <div class="rating_text">
                                    Meritvärde
                                </div>

                                <div class="rating_line">

                                    <img src="{{asset('assets/images/info_con.svg')}}" alt="" style="cursor:pointer;" class="line_icon on_pc" data-toggle="popover" title="" data-placement="left" data-content="<p>En skolas betygsresultat avgörs i stor utsträckning av elevernas socioekonomiska förutsättningar. Det är inte säkert att skolor med höga meritvärden presterar tillräckligt bra och inte heller att skolor med låga meritvärden underpresterar. </p>
                                 För att kunna bedöma det har Skolverket utvecklat analysverktyget SALSA. SALSA jämför en skolas betygsresultat i årskurs 9 med det förväntade resultatet efter att hänsyn tagits till elevsammansättningen. 
                                 Skolguiden.nu bygger på Skolverkets SALSA-siffror.  <br><a  data-toggle='modal' href='#myModal' data-dismiss='modal'  class='custom_link'>Läs mer om SALSA</a>" id="close_1" data-html="true" data-original-title="<a href='javascript:;' onclick='$(&quot;#close_1&quot;).popover(&quot;hide&quot;);' data-toggle='popover'>×</a>">
                            <a data-toggle="modal"  href="#myModal" class="on_mobile_i_b"><img  src="{{asset('assets/images/info_con.svg')}}" alt="" style="cursor:pointer;" class="line_icon"></a>
                         
                                </div>
                            </div>
                            @foreach($schools as $school)
                                <div class="left_box">
                                    <div class="box_title">
                                        <div class="status_container">
                                            <table align="center">
                                                <tr>
                                                    <td><span class="status_text">{{$school->title}}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    @if($school->schoolSalsaValue != null)
                                        <div class="result_container">
                                        <div class="result_text">
                                            SALSA-resultat
                                        </div>

                                        <div class="result_box {{$school->schoolSalsaValue['color_amp_residual_value_f-b']}}">
                                            {{ $school->schoolSalsaValue['amp_residual_value_f-b'] }}
                                        </div>

                                        <div class="result_text">
                                            Uppnått meritvärde
                                            @if($school->schoolTriangle != null && $school->schoolTriangle->triangle_count > $warning_at)

                                                <img src="{{asset('assets/images/warning_icon.svg')}}" alt="" class="result_icon" data-toggle="modal" data-target="#warningModal">

                                            @endif
                                        </div>

                                        <div class="result_box {{$school->schoolSalsaValue->color_amp_actual_value_f}}">
                                            {{ $school->schoolSalsaValue->amp_actual_value_f }}
                                        </div>

                                        <div class="result_text">
                                            Förväntat meritvärde
                                        </div>

                                        <div class="result_box {{$school->schoolSalsaValue->color_amp_model_calc_value_b}}">
                                            {{ $school->schoolSalsaValue->amp_model_calc_value_b }}
                                        </div>
                                    </div>
                                    @else
                                        <div class="result_container">
                                            <div class="result_text">
                                                SALSA-resultat
                                            </div>

                                            <div class="result_box ">

                                            </div>

                                            <div class="result_text">
                                                Uppnått meritvärde
                                            </div>

                                            <div class="result_box">

                                            </div>

                                            <div class="result_text">
                                                Förväntat meritvärde
                                            </div>

                                            <div class="result_box ">

                                            </div>
                                        </div>
                                    @endif
                                </div>
                            
                            @endforeach
                            
                            <div class="rating">
                                <div class="text-center">
                                    <img src="{{'assets/images/expand_icon.svg'}}" class="collapse_icon" width="45" alt="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="boxes_container">
                            <div class="rating">
                                <div class="rating_text">
                                   Bakgrundsvariabler för SALSA-värden
                                </div>

                                <div class="rating_line">

                                </div>
                            </div>
                            @foreach($schools as $school)
                                <div class="left_box">
                                    @if($school->schoolSalsaValue != null)
                                        <div class="result_container">
                                        <div class="result_text">
                                            Föräldrarnas utbildningsnivå
                                        </div>

                                        <div class="result_box {{$school->schoolSalsaValue->color_bg_parents_avg_level_of_education}}">
                                            {{ $school->schoolSalsaValue->bg_parents_avg_level_of_education }}
                                        </div>

                                        <div class="result_text">
                                            Andel nyinvandrade
                                        </div>
 
                                        <div class="result_box gray" style="border-color: black;color: #000 !important;">
                                            {{ $school->schoolSalsaValue->bg_share_of_newly_immigrated }} %
                                        </div>

                                        <div class="result_text">
                                            Andel pojkar
                                        </div>

                                            <div class="result_box gray" style="border-color: black;color: #000important;">
                                            {{ $school->schoolSalsaValue->bg_share_of_boys }} %
                                        </div>
                                    </div>
                                    @else
                                        <div class="result_container">
                                            <div class="result_text">
                                                Föräldrarnas utbildningsnivå
                                            </div>

                                            <div class="result_box {{$school->schoolSalsaValue->color_bg_parents_avg_level_of_education}}">
                                                {{ $school->schoolSalsaValue->bg_parents_avg_level_of_education }}
                                            </div>

                                            <div class="result_text">
                                                Andel nyinvandrade
                                            </div>

                                            <div class="result_box {{ $school->schoolSalsaValue->color_bg_share_of_newly_immigrated }}">
                                                {{ $school->schoolSalsaValue->bg_share_of_newly_immigrated }} 
                                            </div>

                                            <div class="result_text">
                                                Andel pojkar
                                            </div>

                                            <div class="result_box {{ $school->schoolSalsaValue->color_bg_share_of_boys }}">
                                                {{ $school->schoolSalsaValue->bg_share_of_boys }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            
                            <div class="rating">
                                <div class="text-center">
                                    <img src="{{'assets/images/expand_icon.svg'}}" class="collapse_icon" width="45" alt="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="clearfix"></div>

                        <div class="boxes_container">

                            <div class="rating">
                                <div class="rating_text">
                                    Andel elever med betyg i alla ämnen
                                </div>

                                <div class="rating_line">

                                </div>
                            </div>

                            @foreach($schools as $school)
                                <div class="left_box">
                                    @if($school->schoolSalsaValue != null)
                                        <div class="result_container">
                                        <div class="result_text">
                                            SALSA-resultat
                                        </div>

                                        <div class="result_box {{ $school->schoolSalsaValue['color_ga_residual_value_f-b'] }}">
                                            {{ $school->schoolSalsaValue['ga_residual_value_f-b'] }} %
                                        </div>

                                        <div class="result_text">
                                            Uppnådd andel
                                        </div>

                                        <div class="result_box {{ $school->schoolSalsaValue->color_ga_actual_value_f }}">
                                            {{ $school->schoolSalsaValue->ga_actual_value_f }} %
                                        </div>

                                        <div class="result_text">
                                            Förväntad andel
                                        </div>

                                        <div class="result_box {{ $school->schoolSalsaValue->color_ga_model_calc_value_b }}">
                                            {{ $school->schoolSalsaValue->ga_model_calc_value_b }} %
                                        </div>
                                    </div>
                                    @else
                                        <div class="result_container">
                                            <div class="result_text">
                                                Resultat
                                            </div>

                                            <div class="result_box">
                                            </div>

                                            <div class="result_text">
                                                Uppnådd andel
                                            </div>

                                            <div class="result_box">
                                            </div>

                                            <div class="result_text">
                                                Förväntad andel
                                            </div>

                                            <div class="result_box">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            
                            <div class="rating">
                                <div class="text-center">
                                    <img src="{{'assets/images/expand_icon.svg'}}" class="collapse_icon" width="45" alt="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="boxes_container">
                            <div class="rating">
                                <div class="rating_text">
                                    Andel elever med behörighet till gymnasiet
                                </div>

                                <div class="rating_line">
                                    23
                                </div>
                            </div>
                            @foreach($schools as $school)
                                <div class="left_box">
                                    @if($school->qualifyUpperSecData != null)
                                        <div class="result_container">
                                        <div class="result_text">
                                            Naturvetenskapligt och tekniskt program
                                        </div>

                                        <div class="result_box {{ $school->qualifyUpperSecData->color_share_qualify_natural_science_tech_program }}">
                                            {{ $school->qualifyUpperSecData->share_qualify_natural_science_tech_program }} %
                                        </div>

                                        <div class="result_text">
                                            Ekonomi-, humanistiska och samhällsvetenskapsprogram
                                        </div>

                                        <div class="result_box {{ $school->qualifyUpperSecData->color_share_qualify_econ_philos_socialsc_program }}">
                                            {{ $school->qualifyUpperSecData->share_qualify_econ_philos_socialsc_program }} %
                                        </div>

                                        <div class="result_text">
                                            Estetiskt program
                                        </div>

                                        <div class="result_box {{ $school->qualifyUpperSecData->color_share_qualify_arts_aestetichs_program }}">
                                            {{ $school->qualifyUpperSecData->share_qualify_arts_aestetichs_program }} %
                                        </div>

                                        <div class="result_text">
                                            Yrkesprogram
                                        </div>

                                        <div class="result_box {{ $school->qualifyUpperSecData->color_share_qualify_vocational_program }}">
                                            {{ $school->qualifyUpperSecData->share_qualify_vocational_program }} %
                                        </div>
                                    </div>
                                    @else
                                        <div class="result_container">
                                            <div class="result_text">
                                                Naturvetenskapligt och tekniskt program
                                            </div>

                                            <div class="result_box">
                                            </div>

                                            <div class="result_text">
                                                Ekonomi-, humanistiska och samhällsvetenskapsprogram
                                            </div>

                                            <div class="result_box">
                                            </div>

                                            <div class="result_text">
                                                Estetiskt program
                                            </div>

                                            <div class="result_box">
                                            </div>

                                            <div class="result_text">
                                                Yrkesprogram
                                            </div>

                                            <div class="result_box">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            
                            <div class="rating">
                                <div class="text-center">
                                    <img src="{{'assets/images/expand_icon.svg'}}" class="collapse_icon" width="45" alt="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="boxes_container box_btns">
                        <div class="clearfix"></div>

                            @foreach($schools as $school)
                                <div class="left_box">
                                    <form method="post" action="{{url('detail-comparison')}}">
                                        {{csrf_field()}}
                                        <input type="hidden" value="{{$school_code}}" name="school_codes">
                                        <button type="submit" class="btn btn-block btn_custom btn_search">Ämnesbetyg</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
						<div class="clearfix"></div>
                    </div>
                </div>

            </div>

        </div>
    </section>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <button style="margin:10px 0 25px 0px; width: 200px; padding-top: 2px; padding-bottom: 2px; padding-right: 20px" onclick="window.location = 'map'" class="btn btn-block btn_custom btn_search"> <img style="transform: rotate(90deg)" src={{asset("assets/images/expand_icon.svg")}}> Gör en ny sökning</button>
            </div>
        </div>
    </div>
</div>
</main>
    <style>
        .popover{
            top:-100px !important;
        }
        .popover .arrow{
            top:26% !important;
        }
        
        .boxes_container_single .rating .rating_line{width: 84%}
        .boxes_container_double .rating .rating_line{width: 92%}
    </style>
@endsection

@section('script')

    <script type="text/javascript" src="{{ asset('user_assets/scripts/mCustomScrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/user/vuejs/premium_bar.js') }}"></script>
    <!--    Script   -->

    <script>
        $(document).ready(function() {
            var multi_boxes = $('.boxes_container:first .left_box').length;
            var multi_boxe_width = $('.boxes_container:first .left_box:first').outerWidth() + 1;
            //alert(multi_boxe_width*multi_boxes);
            var tp_drop = 188;
            var new_tp_drop = "";


            $('.boxes_container:first .result_container').css('margin-bottom','0')

            
            $('[data-toggle="popover"]').popover();




            $('.boxes_container').css('min-width', multi_boxes * multi_boxe_width + 'px');

            $('.boxes_container:eq(1) .collapse_icon').on('click', function() {
                $(".boxes_container:eq(1)").toggleClass("collapsed_line");
            });

            $('.collapse_icon').on('click', function() {
                var protocol = location.protocol;
                var slashes = protocol.concat("//");
                var host = slashes.concat(window.location.hostname);
                if ($(this).attr('src') == host+'/assets/images/expand_icon.svg') {
                    
                    $(this).attr('src', host+'/assets/images/collapse_icon.svg');
                    $(this).parent('div').nextAll('.rating_line').find('.line_icon').css('background', '#f5f5f5');
                } else {
                    $(this).attr('src', host+'/assets/images/expand_icon.svg');
                }

                $(this).parents('.boxes_container').children('.left_box').toggleClass('slide_now');
            });

            $(window).on('resize', function() {
                setTimeout("line_width()", 100);
                

                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && viewport().width <= 767) {
                    // some code..
                    $('.rating').css('left', '0');
                    $('.boxes_container').css('width', '100%').css('min-width','100%');
                    $('.boxes_container').each(function(){
                        $(this).children('.left_box').hide();
                        $(this).children('.left_box:eq(0)').show();
                        $(this).children('.left_box:eq(1)').show();
                    });
                } else if (viewport().width <= 767) {
                    $('.rating').css('left', '0');
                    $('.left_box').parentsUntil('.boxes_container').css('width', '100%').css('min-width','100%');
                    // mobile view port
                    $('.boxes_container').css('width', '100%').css('min-width','100%');

                    $('.boxes_container').each(function(){
                        $(this).children('.left_box').hide();
                        $(this).children('.left_box:eq(0)').show();
                        $(this).children('.left_box:eq(1)').show();
                    });

//                    if ($(document).scrollTop() >= $('.compare_fixed_right').offset().top) {
//                        $('.compare_fixed_right,.compare_header,.compare_header_right').addClass('rel');
//                        $('.compare_header,.compare_header_right').css('top', $(document).scrollTop() - 270 + 'px');
//
//
//                        console.log(new_tp_drop + ' doc: ' + console.log($(document).scrollTop()) + ' tp: ' + console.log(tp_drop))
//
//                        $('.wrapper-dropdown-3').css('top', new_tp_drop);
//
//                        $('.compare_container').removeAttr('id').addClass('sticky');
//                    }
//                    else {
//                        $('.compare_fixed_right').removeClass('rel');
//
//                        $('.compare_header,.compare_header_right').css('top', '0px')
//
//                        $('.multi_skolval_contaniner').attr('id', 'sticky').removeClass('sticky');
//                    }

                } else if (viewport().width > 767) {
                    //console.log(viewport().width > 767);
                    var multi_boxes = $('.boxes_container:first .left_box').length;
                    var multi_boxe_width = $('.boxes_container:first .left_box:first').outerWidth() + 1;
                    $('.boxes_container').width(multi_boxe_width * multi_boxes);
                    $('.boxes_container').css('min-width', multi_boxe_width * multi_boxes + 'px');
                    $('.left_box').show();

                    if($('.overflow_scroll').width() < (multi_boxes*multi_boxe_width)){
                        $(".overflow_scroll").mCustomScrollbar({
                            axis: "x",
                            theme: "inset-dark",
                            mouseWheel: false,
                            advanced:{
                                updateOnContentResize: true    // <- the solution
                            },
                            callbacks: {
                                whileScrolling: function() {


                                    var observer = new MutationObserver(function(mutations) {
                                        mutations.forEach(function(mutationRecord) {
                                            var lft_num = parseInt(target.style.left);

                                            $('.rating').css('left', Math.abs(lft_num) + 'px');
                                        });
                                    });

                                    var target = document.getElementById('mCSB_1_container');
                                    observer.observe(target, {
                                        attributes: true,
                                        attributeFilter: ['style']
                                    });
                                }
                            }
                        });
                    }
                }
                // location = this.location.href;

                if($('.overflow_scroll').width() < (multi_boxes*multi_boxe_width)) {
                    $('.rating').width($('.overflow_scroll').width());
                }
                else{$('.rating').width($('.boxes_container').width());}
            });
            $('.boxes_container:last').addClass('box_btns');
            setTimeout(function() {
                $('.collapse_icon:not(:first)').trigger('click');
            }, 10);

            $(window).on('load', function() {
				$(".box_btns .left_box").css("min-height", "80px");
				$(".overflow_scroll").css("background","#f5f5f5");
				
                if(multi_boxes == 1){
                    $('.boxes_container').addClass('boxes_container_single');
                }
                
                else if(multi_boxes == 2){
                    $('.boxes_container').addClass('boxes_container_double');
                }
                $('.boxes_container').width(multi_boxe_width * multi_boxes);
                $('.boxes_container').css('min-width', multi_boxe_width * multi_boxes + 'px');
                if($('.overflow_scroll').width() < (multi_boxes*multi_boxe_width)) {
                    $('.rating').width($('.overflow_scroll').width());
                }
                else{$('.rating').width($('.boxes_container').width());}
                $('#mCSB_1_container').css('width','100%');
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && viewport().width <= 767) {
                    // some code..
                    //$('.boxes_container').css('width', '100%');

                    //$('.boxes_container .left_box:not(.boxes_container .left_box:eq(0),.boxes_container .left_box:eq(1))').hide();

					$('.rating').css('left', '0');
                    $('.boxes_container').css('width', '100%').css('min-width','100%');
                    $('.boxes_container').each(function(){
                        $(this).children('.left_box').hide();
                        $(this).children('.left_box:eq(0)').show();
                        $(this).children('.left_box:eq(1)').show();
                    });
				} else if (viewport().width <= 767) {

                    // mobile view port
                    $('.boxes_container').css('width', '100%').css('min-width','100%');
                    $('.boxes_container').each(function(){
                        $(this).children('.left_box').hide();
                        $(this).children('.left_box:eq(0)').show();
                        $(this).children('.left_box:eq(1)').show();
                    });

                } else {
                        console.log($('.overflow_scroll').width() +' - '+ (multi_boxes*multi_boxe_width))
                    if($('.overflow_scroll').width() < (multi_boxes*multi_boxe_width)){
                    setTimeout(function(){$(".overflow_scroll").mCustomScrollbar({
                        axis: "x",
                        theme: "inset-dark",
                        mouseWheel: false,
                        advanced:{
                            updateOnContentResize: true    // <- the solution
                        },
                        callbacks: {
                            whileScrolling: function() {


                                var observer = new MutationObserver(function(mutations) {
                                    mutations.forEach(function(mutationRecord) {
                                        var lft_num = parseInt(target.style.left);

                                        $('.rating').css('left', Math.abs(lft_num) + 'px');
                                    });
                                });

                                var target = document.getElementById('mCSB_1_container');
                                observer.observe(target, {
                                    attributes: true,
                                    attributeFilter: ['style']
                                });
                            }
                        }
                    });}, 300);
                    }
                }
//                if ($(document).scrollTop() >= $('.compare_fixed_right').offset().top && viewport().width <= 767) {
//                    tp_drop = $('.wrapper-dropdown-3,.wrapper-dropdown-3:hidden').offset().top;
//                }

                //new_tp_drop = $(document).scrollTop() - (tp_drop + 1);
                setTimeout("line_width()", 300);
            });



            $("#myModal").on('show.bs.modal', function () {
                $("#close_1").popover("hide");
            });

            //$(".boxes_container:eq(1)").addClass("collapsed_line");
            //$(".result_icon").popover(options);
        });

        function line_width(){
            $(".rating").each(function(){
                var new_width = $(this).width() - $(this).children(".rating_text").outerWidth() - 40;
                //alert($(this).width())
                $(this).children(".rating_line").width(new_width).css("right","40px");
            });
        }

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
    </script>
    
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
<div class="modal fade" id="warningModal" style="z-index:10000; margin-top: 115px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Risk för att meritvärdet inte är korrekt. Skolan har flera varningstrianglar på ämnesbetygen.</p>
                    {{--<p>Kan man lita på betygen? Sätter inte vissa skolor ”glädjebetyg” för att bli mer attraktiva? Jo, det händer. Därför har vi jämfört betygsresultaten med resultaten på nationella prov. Om vi har funnit att dessa avviker för mycket så har vi satt ut en varningstriangel.</p> --}}
                    {{--<p>Triangeln varnar för att en skolas betygsnivåer inte stämmer med vad eleverna faktiskt kan – eller i alla fall har visat att de kan på de nationella proven. Ibland är betygen för låga – ibland för höga. Det är vanligare att en skola sätter för höga än för låga betyg. När du ser varningstriangeln så ska du därför vara försiktig med att dra slutsatser av de faktiska betygsresultaten. </p> --}}
                </div>
            </div>
        </div>
    </div>    
@endsection

