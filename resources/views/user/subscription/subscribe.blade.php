@extends('user.partials.masterpage')
@section('content')
<div class="top_banner on_pc">
    <div class="banner_text">
        <h1>Vi hjälper dig hitta rätt</h1>
        <span>Skolguiden.nu hjälper dig jämföra och välja skola.</span>
    </div>
</div>

<main id="register">
<!--    <div class="title_text mb-15 on_pc">
        <span>Idag är det 43 dagar kvar</span>
    </div>-->

    <section id="container" class="reg_step_2">
        <div class="clearfix"></div>
        <div class="container container_custom">

            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="school_line">
                        <span class="line_text on_pc">Användaruppgifter</span>

                        <span class="line_text on_pc">Betala</span>

                        <span class="line_text on_pc">Färdig</span>

                        <span class="img-circle status_circle circle_inactive" style="left: 0%; z-index: 1;"></span>
                        <span class="img-circle status_circle circle_green" style="left: 47%; z-index: 1;"></span>

                        <span class="img-circle status_circle circle_inactive" style="left: 97%; z-index: 2;"></span>

                    </div>

                    <div class="text-center">
                        <h3><span class="on_pc">Skolvalsguiden Premium</span> <span class="on_mobile_i_b">Vilka kort funkar med Stripe?</span> </h3>

                        <div class="line on_mobile_i_b"></div>                    

                    </div>


                    {!! Form::open(['url' => route('order-post'), 'data-parsley-validate', 'id' => 'payment-form', 'class' => 'loginform']) !!}
                    @if (Session::has('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ Session::get('success') }}</strong>
                    </div>
                    @endif
                    @if (Session::has('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ Session::get('error')}}</strong>
                    </div>
                    @endif

                    <div class="text-center login_controls" id="cc-group">
                        <!--                    {!! Form::label(null, 'Credit card number:') !!}-->
                        {!! Form::text(null, null, [
                        'class'                         => 'form-control input_control ',
                        'required'                      => 'required',
                        'data-parsley-required-message'   => 'Ange korrekt kortnummer',
                        'placeholder'                   => 'Kortnummer',
                        'data-stripe'                   => 'number',
                        'data-parsley-type'             => 'number',
                        'maxlength'                     => '16',
                        'data-parsley-trigger'          => 'change focusout',
                        'data-parsley-class-handler'    => '#cc-group'
                        ]) !!}
                    </div>

                    <div class="text-center login_controls" id="ccv-group">
                        <!--                    {!! Form::label(null, 'CVC (3 or 4 digit number):') !!}-->
                        {!! Form::text(null, null, [
                        'class'                         => 'form-control input_control ',                        
                        'required'                      => 'required',
                        'data-parsley-required-message'   => 'Ange korrekt cvv',
                        'placeholder'                   => 'CVV',
                        'data-stripe'                   => 'cvc',
                        'data-parsley-type'             => 'number',
                        'data-parsley-trigger'          => 'change focusout',
                        'maxlength'                     => '4',
                        'data-parsley-class-handler'    => '#ccv-group'
                        ]) !!}
                    </div>

                    <div class="text-center login_controls">    
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="text-center" id="exp-m-group">
                                    <!--                        {!! Form::label(null, 'Ex. Month') !!}-->
                                    {!! Form::selectMonth(null, null, [
                                    'class'                 => 'form-control input_control input_control_rounded',
                                    'style'                        => 'border-radius:0px',
                                    'placeholder'           => 'Månad',
                                    'required'              => 'required',
                                    'data-parsley-trigger'          => 'change focusout',
                                    'data-parsley-required-message'   => 'Ange korrekt Månad',
                                    'data-stripe'           => 'exp-month'
                                    
                                    ], '%m') !!}
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="text-center" id="exp-y-group">
                                    <!--                        {!! Form::label(null, 'Ex. Year') !!}-->
                                    {!! Form::selectYear(null, date('Y'), date('Y') + 10, null, [
                                    'class'             => 'form-control input_control input_control_rounded',
                                    'style'                        => 'border-radius:0px',
                                    'placeholder'       => 'År',
                                    'required'          => 'required',
                                    'data-parsley-trigger'          => 'change focusout',
                                    'data-parsley-required-message'   => 'Ange korrekt År',
                                    'data-stripe'       => 'exp-year'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center login_controls">
                        <button type="submit" class="login" id="submitBtn" style="margin-bottom: 10px;" >
                            Skolguiden Premium <br/>
                            99 kronor engångsavgift för att se alla skolors resultat
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="payment-errors" style="color: red;margin-top:10px;"></span>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </section>
</main>
@include('user.partials.script')
<!-- PARSLEY -->
<script>
    window.ParsleyConfig = {
        errorsWrapper: '<span class="help-block"></span>',
        errorTemplate: '<strong style="color: #a94442;"></strong>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };
</script>

<!--<script src="https://parsleyjs.org/dist/parsley.js"></script>-->
<script src="js/user/parsley.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    Stripe.setPublishableKey("<?php echo env('STRIPE_KEY') ?>");
    jQuery(function ($) {        
        $('#payment-form').submit(function (event) {            
            var $form = $(this);
            $form.parsley().subscribe('parsley:form:validate', function (formInstance) {
                //formInstance.submitEvent.preventDefault();
           
                return false;
            });
            
            $form.find('#submitBtn').prop('disabled', true);
            Stripe.card.createToken($form, stripeResponseHandler);
            return false;
        });
    });
    function stripeResponseHandler(status, response) {
      
        var $form = $('#payment-form');
        if (response.error) {            
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').addClass('alert alert-danger');
            $form.find('#submitBtn').prop('disabled', false);
            $('#submitBtn').button('reset');
        } else {
            var token = response.id;
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            $form.get(0).submit();
        }
    };
</script>
@endsection
