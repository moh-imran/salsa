@extends('user.partials.masterpage')
@section('content')
<main id="register">
    <div class="jumbotron text-center">
        <h1>Vi hjälper dig hitta rätt</h1>
        <p class="mb-0">Skolguiden.nu hjälper dig jämföra och välja skola.</p>
    </div>
<!--    <div class="title_text mb-15">
        <span>Idag är det 43 dagar kvar</span>
    </div>-->
    <section id="container" class="mt-50">
        <div class="container container_custom">

            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
<!--                    <div class="school_line">
                        <span class="line_text">Användaruppgifter</span>

                        <span class="line_text">Betala</span>

                        <span class="line_text">Färdig</span>

                        <span class="img-circle status_circle circle_inactive" style="left: 0%; z-index: 1;"></span>
                        <span class="img-circle status_circle circle_green" style="left: 47%; z-index: 1;"></span>

                        <span class="img-circle status_circle circle_inactive" style="left: 96%; z-index: 2;"></span>
                    </div>-->
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>

                    {!! Form::open(['url' => route('update-credit-card'), 'data-parsley-validate', 'id' => 'payment-form', 'class' => 'loginform']) !!}
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

                    <div class="form-group" id="cc-group">
                        <!--                    {!! Form::label(null, 'Credit card number:') !!}-->
                        {!! Form::text(null, null, [
                        'class'                         => 'form-control',
                        'required'                      => 'required',
                        'placeholder'                   => 'Card number',
                        'data-stripe'                   => 'number',
                        'data-parsley-type'             => 'number',
                        'maxlength'                     => '16',
                        'data-parsley-trigger'          => 'change focusout',
                        'data-parsley-class-handler'    => '#cc-group'
                        ]) !!}
                    </div>
                    <div class="form-group" id="ccv-group">
                        <!--                    {!! Form::label(null, 'CVC (3 or 4 digit number):') !!}-->
                        {!! Form::text(null, null, [
                        'class'                         => 'form-control',
                        'required'                      => 'required',
                        'placeholder'                   => 'CVV',
                        'data-stripe'                   => 'cvc',
                        'data-parsley-type'             => 'number',
                        'data-parsley-trigger'          => 'change focusout',
                        'maxlength'                     => '4',
                        'data-parsley-class-handler'    => '#ccv-group'
                        ]) !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="exp-m-group">
                                <!--                        {!! Form::label(null, 'Ex. Month') !!}-->
                                {!! Form::selectMonth(null, null, [
                                'class'                 => 'form-control',
                                'placeholder'           => 'Ex. Month',
                                'required'              => 'required',
                                'data-stripe'           => 'exp-month'
                                ], '%m') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="exp-y-group">
                                <!--                        {!! Form::label(null, 'Ex. Year') !!}-->
                                {!! Form::selectYear(null, date('Y'), date('Y') + 10, null, [
                                'class'             => 'form-control',
                                'placeholder'       => 'Ex. Year',
                                'required'          => 'required',
                                'data-stripe'       => 'exp-year'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Betala 99:- nu', ['class' => 'login', 'id' => 'submitBtn', 'style' => 'margin-bottom: 10px;']) !!}
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

        </div>
    </section>
</main>
@include('user.partials.script')
<!-- PARSLEY -->
<script>
    window.ParsleyConfig = {
        errorsWrapper: '<div></div>',
        errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };
</script>

<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    Stripe.setPublishableKey("<?php echo env('STRIPE_KEY') ?>");
    jQuery(function ($) {
        $('#payment-form').submit(function (event) {
            var $form = $(this);
            $form.parsley().subscribe('parsley:form:validate', function (formInstance) {
                //formInstance.submitEvent.preventDefault();
                //alert();
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
