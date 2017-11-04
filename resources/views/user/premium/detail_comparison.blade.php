@extends('user.partials.masterpage')
@section('style')
    <link href="{{ asset('user_assets/css/mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('content')
    <main id="schools_compare">
         
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
<!--        <div class="title_text on_pc">
            <span>Idag är det 43 dagar kvar</span>
        </div>-->
        <section id="container">
            <div class="clearfix"></div>
            
            <article id="width_set">

                <div class="container container_custom">
                    <div class="row on_pc">
<!--                        <div class="col-md-8 col-md-offset-2 text-center">
                            <p class="text_gen">Punkterna på linjen representerar grundskolorna i <b> {{ $community_title }} </b>och hur de ligger till i jämförelse med alla svenska grundskolor enligt Skolverkets Salsa-värden. <span style="cursor:pointer;" data-toggle="modal" data-target="#myModal">Läs mer om SALSA…</span></p>
                            <div class="line on_pc"></div>
                            <div class="clearfix"></div>
                        </div>-->
                    </div>


                    <div class="row reverse">
                        <div class="text-center">
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
                        </div>

                        <div class="compare_container" id="sticky">
                            <!--<div class="compare_side_text compare_header">
                                <span>Ämne</span>
                            </div>-->
                            <div class="compare_fixed_left">
                                <div class="compare_side_text compare_header">
                                    <span>Ämne</span>
                                    <div class="compare_side_text bg_white" style="border-bottom: none; border-top: 1px solid #ececec">

                                    </div>
                                </div>
                                @foreach($subjects as $subject)
                                @if($subject->title != 'Moderna språk, elevens val' && $subject->title != 'Modersmål' && $subject->title != 'Svenska som andraspråk')
                                    <div class="compare_side_text">
                                        <span>{{$subject->title}}</span>
                                    </div>
                                @endif
                                @endforeach
                                <div class="compare_side_text">
                                    {{--<span>Antal lärare</span>--}}
                                </div>
                                <div class="compare_side_text">
                                    <span>Antal lärare</span>
                                </div>
                                <div class="compare_side_text">
                                    <span>Antal elever per heltidslärare</span>
                                </div>
                                <div class="compare_side_text">
                                    <span>Andel lärare med pedagogisk utbildning</span>
                                </div>

                            </div>

                            <div class="compare_fixed_right">
                                <div id="dd" class="wrapper-dropdown-3 on_mobile_i_b" tabindex="1">
                                    <span class="school_selected">{{ $schools[0]? $schools[0]->title : 'Ladubacksskolan' }}</span>
                                    <ul class="dropdown">
                                        @foreach($schools as $school)
                                            <li>
                                                <a href="#">{{$school->title}}
                                                    {{--@if($school->schoolTriangle != null && $school->schoolTriangle->triangle_count > $warning_at)--}}
                                                    {{--&nbsp;--}}
                                                    {{--<img src="{{asset('assets/images/warning_icon.svg')}}" alt="" class="mCS_img_loaded" data-toggle="modal" data-target="#warningModal">--}}
                                                    {{--@endif--}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div> 
                                <div class="compare_right_container">
                                    <div class="compare_right_blocks">
                                        @foreach($schools as $school)
                                        <div class="compare_block">
                                            <div class="compare_header_right">
                                                <h3>
                                                    <span>
                                                        {{$school->title}}
                                                        {{--@if($school->schoolTriangle != null && $school->schoolTriangle->triangle_count > $warning_at)--}}
                                                            {{--&nbsp;--}}
                                                            {{--<img src="{{asset('assets/images/warning_icon.svg')}}" alt="" class="mCS_img_loaded" data-toggle="modal" data-target="#warningModal">--}}
                                                        {{--@endif--}}
                                                    </span>
                                                </h3>
                                                <div class="block_50">
                                                    <h4><span>Betygsresultat</span></h4>
                                                </div>

                                                <div class="block_50">
                                                    <h4><span>Nationella prov</span></h4>
                                                </div>

                                                <div class="sticky_white">
                                                    <div class="block_25">
                                                        <h5><span>Andel godkända</span></h5>
                                                    </div>
                                                    <div class="block_25">
                                                        <h5><span>Medelvärde</span></h5>
                                                    </div>
                                                    <div class="block_25">
                                                        <h5><span>Andel deltagit</span></h5>
                                                    </div>
                                                    <div class="block_25">
                                                        <h5><span>Medelvärde</span></h5>
                                                    </div>
                                                </div>
                                            </div>

                                                @foreach($subjects as $subject)
                                                @if($subject->title != 'Moderna språk, elevens val' && $subject->title != 'Modersmål' && $subject->title != 'Svenska som andraspråk')
                                                    <div class="block_percentage">
                                                    @if(! $school->grade9Data->where('subject_id', $subject->id)->isEmpty())
                                                        @if($grade9Data = $school->grade9Data->where('subject_id', $subject->id)->first())@endif
                                                        @if($grade9Data->share_ae != null)
                                                            <div class="block_25">
                                                                <div class="percentage_rounded">
                                                                    @if($school->schoolPupilTeacherStat->percent_teacher_pedagogical_degree > 0)
                                                                    <span class="{{$grade9Data->color_share_ae}}">
                                                                        @if($grade9Data->share_ae > 100)
                                                                        {{100}} %
                                                                        @else
                                                                        {{$grade9Data->share_ae}}%
                                                                        @endif
                                                                    </span>
                                                                    
																	
                                                                    @if($grade9Data->show_participiation_triangle['show_participiation_triangle'] == 1)
                                                                        <a href="javascript:;" class="img_icon">
                                                                            <img src="{{asset('assets/images/warning_icon.svg')}}" alt="" class="mCS_img_loaded" data-toggle="modal" data-target="#warningModal">
                                                                        </a>
                                                                    @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="block_25">
                                                                &nbsp;
                                                            </div>
                                                        @endif
                                                        @if($grade9Data->merit_points != null)
                                                            <div class="block_25">
                                                                <div class="percentage_rounded">
                                                                    <span class="{{$grade9Data->color_merit_points}}">
                                                                        {{$grade9Data->merit_points}}
                                                                    </span>
                                                                    
                                                                    @if($grade9Data->show_deviation_triangle['show_deviation_triangle'] == 1)
                                                                        <a href="javascript:;" class="img_icon">
                                                                            <img src="{{asset('assets/images/warning_icon.svg')}}" alt="" class="mCS_img_loaded" data-toggle="modal" data-target="#warningModal2">
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="block_25">
                                                                &nbsp;
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="block_25">
                                                            &nbsp;
                                                        </div>
                                                        <div class="block_25">
                                                            &nbsp;
                                                        </div>
                                                    @endif
 
                                                    @if(! $school->nationalResultsData->where('subject_id', $subject->id)->isEmpty())
                                                        @if($nationalResultsData = $school->nationalResultsData->where('subject_id', $subject->id)->first())@endif
                                                        @if($nationalResultsData->share_participated != null)
                                                            <div class="block_25">
                                                                <div class="percentage_rounded">
                                                                    @if($school->schoolPupilTeacherStat->percent_teacher_pedagogical_degree > 0)
                                                                    <span class="@if($nationalResultsData->color_share_participated){{$nationalResultsData->color_share_participated}}@else gray @endif">
                                                                        @if($nationalResultsData->share_participated > 100)
                                                                        {{ 100 }}%
                                                                        @else
                                                                        {{number_format((float)$nationalResultsData->share_participated, 1, '.', '')}}%
                                                                        @endif
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="block_25">
                                                                &nbsp;
                                                            </div>
                                                        @endif
                                                        @if($nationalResultsData->merit_points != null)
                                                            <div class="block_25">
                                                                <div class="percentage_rounded">
                                                                    <span class="@if($nationalResultsData->color_merit_points){{$nationalResultsData->color_merit_points}}@else gray @endif">
                                                                        {{$nationalResultsData->merit_points}}
                                                                    </span>

                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="block_25">
                                                                &nbsp;
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="block_25">
                                                            &nbsp;
                                                        </div>
                                                        <div class="block_25">
                                                            &nbsp;
                                                        </div>
                                                    @endif
                                                    </div>
                                                @endif
                                                @endforeach
                                            <div class="block_percentage bg_white">

                                            </div>

                                            <div class="block_percentage">
                                                <div class="text-center">
                                                    <div class="percentage_rounded">
                                                        <span class="gray">
                                                            {{$school->schoolPupilTeacherStat->teachers_count}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="block_percentage">
                                                <div class="text-center">
                                                    <div class="percentage_rounded">
                                                        <span class="{{$school->schoolPupilTeacherStat->color_students_per_teacher}}">
                                                            {{$school->schoolPupilTeacherStat->students_per_teacher}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="block_percentage">
                                                <div class="text-center">
                                                    <div class="percentage_rounded">
                                                        @if($school->schoolPupilTeacherStat->percent_teacher_pedagogical_degree > 0)
                                                        <span  class="{{$school->schoolPupilTeacherStat->color_percent_teacher_pedagogical_degree}}">
                                                            @if($school->schoolPupilTeacherStat->percent_teacher_pedagogical_degree >100)
                                                                {{100}}%
                                                            @else
                                                            {{$school->schoolPupilTeacherStat->percent_teacher_pedagogical_degree}}%
                                                            @endif
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </article>
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
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('user_assets/scripts/mCustomScrollbar.js') }}"></script>

    <script>
        var boxe_width = $('.compare_block').outerWidth() + 30;
        var boxes = $('.compare_block').length;
        var boxes_width = '';
        var tp_drop = 188;
        var new_tp_drop = "";
        var display_i = 0;
        $(document).ready(function() {
//            $('[data-toggle="popover"]').popover();

            $(document).on('scroll', function() {
                if ($(document).scrollTop() >= $('.compare_fixed_right').offset().top) {
                    $('.compare_fixed_right,.compare_header,.compare_header_right').addClass('rel');
                    $('.compare_header,.compare_header_right').css('top', $(document).scrollTop() - 270 + 'px');

                    // if (tp_drop < 0) {
                    //     tp_drop = 0;
                    // } else {
                    //     var new_tp_drop = $(document).scrollTop() - (tp_drop + 40);
                    //     console.log(new_tp_drop)
                    // }

                    if ($(document).scrollTop() < $('.compare_fixed_right').offset().top && viewport().width <= 768) {
                        new_tp_drop = '46%';
                    }
                    else if($(document).scrollTop() > $('.compare_fixed_right').offset().top && viewport().width >= 767){
                        new_tp_drop = $(document).scrollTop() - (tp_drop + 40);
                        $('.compare_header,.compare_header_right').addClass("sticky_desktop");
                        $('.compare_header,.compare_header_right').css('top', $(document).scrollTop() - 200 + 'px');
                    }
                     else {
                        new_tp_drop = $(document).scrollTop() - (tp_drop + 40);
                    }

                    $('.wrapper-dropdown-3').css('top', new_tp_drop + 'px');

                    $('.compare_container').removeAttr('id').addClass('sticky');
                } else {
                    $('.compare_fixed_right').removeClass('rel');
                    $('.wrapper-dropdown-3').css('top', '-50px')
                    $('.compare_header,.compare_header_right').css('top', '0px');

                    $('.compare_container').attr('id', 'sticky').removeClass('sticky');
                }
            });

            $(window).on('resize', function() {
                //$('.compare_right_blocks').width(boxe_width * boxes);
                if ($(document).scrollTop() < $('.compare_fixed_right').offset().top && viewport().width <= 768) {
                    new_tp_drop = '46%';
                } else {

                    new_tp_drop = $(document).scrollTop() - (tp_drop + 40);
                }
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && viewport().width <= 768) {
                    // some code..
                    $('.compare_right_blocks').css('width', '100%');

                    $('.compare_block:not(.compare_block:eq(' + display_i + '))').hide();
                } else if (viewport().width <= 768) {
                    $('.compare_right_blocks').parentsUntil('.compare_right_container').css('width', '100%');
                    // mobile view port
                    $('.compare_right_blocks').css('width', '100%');

                    $('.compare_block:not(.compare_block:eq(' + display_i + '))').hide();

                    if ($(document).scrollTop() >= $('.compare_fixed_right').offset().top) {
                        $('.compare_fixed_right,.compare_header,.compare_header_right').addClass('rel');
                        $('.compare_header,.compare_header_right').css('top', $(document).scrollTop() - 270 + 'px');


                        console.log(new_tp_drop + ' doc: ' + console.log($(document).scrollTop()) + ' tp: ' + console.log(tp_drop))

                        $('.wrapper-dropdown-3').css('top', new_tp_drop);

                        $('.compare_container').removeAttr('id').addClass('sticky');
                    } else {
                        $('.compare_fixed_right').removeClass('rel');
                        $('.wrapper-dropdown-3').css('top', '-50px')
                        $('.compare_header,.compare_header_right').css('top', '0px')

                        $('.compare_container').attr('id', 'sticky').removeClass('sticky');
                    }

                } else if (viewport().width > 767) {
                    //console.log(viewport().width > 767);
                    $('.compare_right_blocks').width(boxe_width * boxes);
                    $('.compare_block').show();

                    $(".compare_right_container").mCustomScrollbar({
                        axis: "x",
                        theme: "inset-dark",
                        mouseWheel: false
                    });
                }
                // location = this.location.href;


            });

        });

        $(window).on('load', function() {

            $('.compare_right_blocks').width(boxe_width * boxes);
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && viewport().width <= 768) {
                // some code..
                $('.compare_right_blocks').css('width', '100%');

                $('.compare_block:not(.compare_block:first)').hide();
            } else if (viewport().width <= 767) {

                // mobile view port
                $('.compare_right_blocks').css('width', '100%');

                $('.compare_block:not(.compare_block:first)').hide();

            } else {
                $(".compare_right_container").mCustomScrollbar({
                    axis: "x",
                    theme: "inset-dark",
                    mouseWheel: false
                });
            }
            if ($(document).scrollTop() >= $('.compare_fixed_right').offset().top && viewport().width <= 768) {
                tp_drop = $('.wrapper-dropdown-3,.wrapper-dropdown-3:hidden').offset().top;
            }
            else{
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    tp_drop = 120
                }
            }

            new_tp_drop = $(document).scrollTop() - (tp_drop + 40);


        });

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

    <script>
        // dropdown function...
        function DropDown(el) {
            this.dd = el;
            this.placeholder = this.dd.children('span');
            this.opts = this.dd.find('ul.dropdown > li');
            this.val = '';
            this.index = -1;
            this.initEvents();
        }
        DropDown.prototype = {
            initEvents: function() {
                var obj = this;

                obj.dd.on('click', function(event) {
                    $(this).toggleClass('active');
                    return false;
                });

                obj.opts.on('click', function() {
                    var opt = $(this);
                    obj.val = opt.text();
                    obj.index = opt.index();
                    obj.placeholder.text(obj.val);
                    $('.compare_block').hide();
                    $('.compare_block:eq(' + obj.index + ')').show();
                    display_i = obj.index;
                });
            },
            getValue: function() {
                return this.val;
            },
            getIndex: function() {
                return this.index;
            }
        }


        // dropdown function...

        $(document).ready(function() {
            var dd = new DropDown($('#dd'));

            $(document).click(function() {
                // dropdown call
                $('.wrapper-dropdown-3').removeClass('active');
            });
        });
    </script>
<div class="modal fade" id="warningModal" style="z-index:10000; margin-top: 115px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Risk för att andelen godkända inte är korrekt eftersom den avviker för mycket från resultatet på nationellt prov.</p>
                   {{--<p> Kan man lita på betygen? Sätter inte vissa skolor ”glädjebetyg” för att bli mer attraktiva? Jo, det händer. Därför har vi jämfört betygsresultaten med resultaten på nationella prov. Om vi har funnit att dessa avviker för mycket så har vi satt ut en varningstriangel.</p> <p>Triangeln varnar för att en skolas betygsnivåer inte stämmer med vad eleverna faktiskt kan – eller i alla fall har visat att de kan på de nationella proven. Ibland är betygen för låga – ibland för höga. Det är vanligare att en skola sätter för höga än för låga betyg. --}}
                       {{--När du ser varningstriangeln så ska du därför vara försiktig med att dra slutsatser av de faktiska betygsresultaten. </p>--}}
                </div>
            </div>
        </div>
</div>    
<div class="modal fade" id="warningModal2" style="z-index:10000; margin-top: 115px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Risk för att betyget inte är korrekt eftersom det avviker för mycket från resultatet på nationellt prov.</p>
                   {{--<p> Kan man lita på betygen? Sätter inte vissa skolor ”glädjebetyg” för att bli mer attraktiva? Jo, det händer. Därför har vi jämfört betygsresultaten med resultaten på nationella prov. Om vi har funnit att dessa avviker för mycket så har vi satt ut en varningstriangel.</p> <p>Triangeln varnar för att en skolas betygsnivåer inte stämmer med vad eleverna faktiskt kan – eller i alla fall har visat att de kan på de nationella proven. Ibland är betygen för låga – ibland för höga. Det är vanligare att en skola sätter för höga än för låga betyg. --}}
                       {{--När du ser varningstriangeln så ska du därför vara försiktig med att dra slutsatser av de faktiska betygsresultaten. </p>--}}
                </div>
            </div>
        </div>
</div>
@endsection