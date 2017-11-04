@extends('user.partials.masterpage')
@section('content')
<div class="top_banner"><div class="banner_text"><h1>Vi hjälper dig hitta rätt</h1> <span>Skolguiden.nu hjälper dig jämföra och välja skola.</span></div></div>
<!--    <div class="title_text border_top_none">
        <span>Idag är det 43 dagar kvar</span>
    </div>-->
<main id="profile_edit">
    <section id="container">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="text-center">
                            <h1 class="heading_text">Ditt medlemskap</h1>

                            <h3 class="sub_heading">Du är medlem till <b> @{{subscription_ends_at}} </b>.</h3>
                            <a class="btn btn-block btn_custom btn_renew" href="javascript:;">Förnya / Betala</a>

                            <h1 class="heading_text heading_edit">Ditt medlemskap</h1>
                        </div>
                    <form class="">
                        <span style="font-size:20px;" v-for="error in errors" class="text-danger"> @{{error}} </span>
                        <span style="font-size:20px;" v-for="succe in success" class="text-success"> @{{succe}} </span>
                        
        
                            <div class="text-center login_controls">    
                                <input class="form-control input_control" v-model="email" placeholder="E-postadress" type="text" required>
                                <input class="form-control input_control" type="password" v-model="password" placeholder="Lösenord"  required>
                                
                            </div>
                        <div class="login_controls">
                            <input class="form-control input_control input_control_rounded" v-model="post_number" placeholder="Ange ditt postnummer" type="text" required>
                        </div>
                        
<!--                        <div class="login_controls">
                            <table align="right" class="children_numbers">
                                <tbody><tr>
                                    <td>Antal barn:</td>
                                    <td>
                                        <select name="" class="form-control input_control input_control_rounded">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                            <option value="">3</option>
                                            <option value="">4</option>
                                            <option value="">5</option>
                                        </select>

                                        <div id="dd" class="wrapper-dropdown-3" tabindex="1">
                                            <span>1</span>
                                            <ul class="dropdown">
                                                <li><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>-->
                        
                        <div class="row login_controls">
                            <table align="right" class="children_numbers">
                                <tbody><tr>
                                    <td>Antal barn:</td>
                                    <td>
                                        <select v-model="selected" v-on:change="select_children" name="" id="no_children"  class="form-control input_control input_control_rounded">
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
                                <input :id="n.id" v-model="n.value" class="form-control input_control input_control_rounded" placeholder="Ålder på barn" type="text">
                                <a class="btn btn_cross" v-on:click="remove(index)">X</a>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <!--                    <button type="button"  class="login"><a href="{{url('/home')}}" style="color:white;">Till skolval</a></button>-->
                    <button type="button" v-on:click="add_children_data()"  class="btn btn-block btn_custom btn_update">Till skolval</button>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="{{asset('js/user/vuejs/account.js')}}"></script>
<!--<script>
    $(document).ready(function(){
var dd = new DropDown($('#dd'));
            $(document).click(function () {
                // dropdown call
                $('.wrapper-dropdown-3').removeClass('active');
            });
        });
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
                initEvents: function () {
                    var obj = this;

                    obj.dd.on('click', function (event) {
                        $(this).toggleClass('active');
                        return false;
                    });

                    obj.opts.on('click', function () {
                        var opt = $(this);
                        obj.val = opt.text();
                        obj.index = opt.index();
                        obj.placeholder.text(obj.val);
                        vu_obj.select_children(obj.index, elems);
                    });
                },
                getValue: function () {
                    return this.val;
                },
                getIndex: function () {
                    return this.index;
                }
            }


            // dropdown function...
</script>    -->
@endsection
