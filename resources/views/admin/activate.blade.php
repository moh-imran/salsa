@extends('admin.layouts.admin_app')

@section('content')

    <!-- Form with validation -->
    <form role="form" method="POST" action="{{ route('admin.activate', [$user->id]) }}" class="form-validate" novalidate="novalidate">
        {!! csrf_field() !!}
        <input name="_method" type="hidden" value="PUT">
        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><img src="{{ asset('assets/images/logo.png') }}" alt="LulaRoe"/></div>
                <h5 class="content-group">Your account information
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
                <input type="text" class="form-control" value="{{$user->name}}" placeholder="Name" name="name"
                       required="required">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="text" class="form-control" value="{{$user->phone}}" placeholder="Phone" name="phone">
                <div class="form-control-feedback">
                    <i class="icon-phone text-muted"></i>
                </div>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn bg-blue btn-block">Save <i class="icon-arrow-right14 position-right"></i>
                </button>
            </div>

        </div>
    </form>
    <!-- /form with validation -->
@endsection

