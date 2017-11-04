@extends('admin.layouts.admin_app')

@section('content')

    <!-- Form with validation -->
    <form role="form" method="POST" action="{{ url('login') }}" class="form-validate" novalidate="novalidate">
        {!! csrf_field() !!}
        <div class="panel panel-body login-form">
            <div class="text-center">
                <div style="padding: 25px;" class="icon-object border-slate-300 text-slate-300">
                    <img style="width: 203px;" src="{{ asset('assets/images/logo.png') }}" alt="Salsa"/>
                </div>
                <h5 class="content-group">Login to your account
                    <small class="display-block">Your credentials</small>
                </h5>
            </div>

            <div>
            @if (count($errors) > 0)
                <!-- Form Error List -->

                    <div class="alert bg-danger alert-styled-left">
                        <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">Oh snap!</span><br />
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

            </div>

            <div class="form-group has-feedback has-feedback-left">
                {{--<input type="text" class="form-control" value="{{ old('email') }}" placeholder="email" name="email"--}}
                <input type="text" class="form-control" placeholder="Email" name="email"
                       required="required">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
            </div>

            <div class="form-group login-options">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" class="control-success">
                                Remember
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-6 text-right">
                        <a href="{{ url('/password/reset') }}">Forgot password?</a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i>
                </button>
            </div>

        </div>
    </form>
    <!-- /form with validation -->
@endsection

