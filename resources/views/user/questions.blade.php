@extends('user.partials.masterpage')
@section('content')
<div class="top_banner on_pc"><div class="banner_text"><h1>Vi hjälper dig hitta rätt</h1> <span>Skolguiden.nu hjälper dig jämföra och välja skola.</span></div></div>
<main id="register">
<!--    <div class="title_text on_pc">
        <span>Idag är det 43 dagar kvar</span>
    </div>-->
    <section id="container" class="reg_step_3">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="school_line">
                        <span class="line_text on_pc">Användaruppgifter</span>

                        <span class="line_text on_pc">Betala</span>

                        <span class="line_text on_pc">Färdig</span>
  
                        <span class="img-circle status_circle circle_inactive" style="left: 0%; z-index: 1;"></span>
                        <span class="img-circle status_circle circle_inactive" style="left: 47%; z-index: 1;"></span>

                        <span class="img-circle status_circle circle_green" style="left: 97%; z-index: 2;"></span>
                    </div>
                    <div class="clearfix"></div>
                    <form class="loginform">

                        <h3 class="">Tack<span class="on_pc"> för din betalning</span>!</h3>
                        <div class="line on_mobile_i_b">&nbsp;</div>
                        <div class="text-center">
                            <img src="{{'assets/images/check.png'}}" width="37" class="tick_img">
                        </div>
                        <p class="gen_text" style="font-size: 13px;">Ditt köp har gått igenom. För bästa service vänligen besvara följande frågor:</p>                        
                        
                        <span style="font-size:20px;" v-for="error in errors" class="text-danger"> @{{error}} </span>
                         
                        <div class="row login_controls">
                                <input class="form-control input_control input_control_rounded" v-model="post_number" placeholder="Ange ditt postnummer" type="text" required>
                        </div>

                        
                        <div class="login_controls">
                            <table align="center" class="children_numbers">
                                <tbody><tr>
                                    <td>Hur många barn i skolåldern har du?</td>
                                    <td>
                                        <select v-model="selected" v-on:change="select_children" name="" id="no_children"  class="form-control input_control" style="border-radius:5px;">
                                            <option value="Select">Select</option>                                    
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>

<!--                                        <div id="dd" class="wrapper-dropdown-3" tabindex="1">
                                            <span>1</span>
                                            <ul class="dropdown">
                                                <li><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                            </ul>
                                        </div>-->
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                        
                        <div class="row login_controls dynamic">
                            <div v-for="(n, index) in children" class="cross_container">
                                <input :id="n.id" v-model="n.value" class="form-control input_control input_control_rounded" placeholder="Ålder på barn " type="text">
                                <a class="btn btn_cross" v-on:click="remove(index)">X</a>
                            </div>
                        </div>
<!--                   <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2 mb-15"><input class="form-control" placeholder="Ålder på barn 2" type="text"></div>
                        </div>-->
<!--                        <button type="submit" class="login">Till skolval</button>-->
<!--<button type="button" href="{{url('/home')}}" class="login">Till skolval</button>-->
                    </form>
                    <div class="clearfix"></div>
<!--                    <button type="button"  class="login"><a href="{{url('/home')}}" style="color:white;">Till skolval</a></button>-->
                <button type="button" v-on:click="add_children_data()"  class="login btn btn-block btn_custom btn_reg">Till Skolguiden Premium</button>
                </div>
            </div>

        </div>

      
    </section>
</main>


<script src="{{asset('js/user/vuejs/questions.js')}}"></script>

@endsection
