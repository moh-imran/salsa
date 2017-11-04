@extends('user.partials.masterpage')
@section('content')
<div class="container-fluid">
       <main>
       
        <p>&nbsp;</p>
        <h4 align="center">Betala</h4>
        <div class="line">&nbsp;</div>

        <p>&nbsp;</p>
<!--        <form class="loginform">
            <input type="text" class="form-control" placeholder="Card holder">
            <input type="text" class="form-control" placeholder="Card number">
            <div class="row clearfix">
                <div class="col-xs-6">
                    <input type="number" class="form-control" placeholder="00/00">
                </div>
                <div class="col-xs-6">
                    <input type="text" class="form-control" placeholder="CCV">
                </div>
            </div>
            <button type="submit" class="login">Betala 99:- nu</button>
        </form>-->

              {!! Form::open(['url' => route('selected-municipality'), 'data-parsley-validate', 'id' => 'payment-form', 'class' => 'loginform']) !!}
             
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
                        'placeholder'                   => 'Community Name',
                        'name'                          => 'community_title'
                        ]) !!}
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
    </main>
</div>

@endsection
    