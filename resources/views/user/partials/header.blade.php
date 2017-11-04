<style>
    @media (max-width:991px){
    .navbar-default .col-sm-9{
        padding:0;
    }
    }
</style>    

<header class="clearfix container-fluid p0 m0">
        <nav class="navbar navbar-default mt-0">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="col-xs-12 col-sm-3">
                    <div class="navbar-header">
                    <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">-->
                    <span class="sr-only">Toggle navigation</span>
                    @if (!(Auth::check()))
                    <ul class="nav navbar-nav navbar-right navbar-toggle login_menu collapsed">
                        <!--<li><a href="{{ url('/login') }}"><a href="{{ url('/login') }}" class="">Login</a></a></li>-->
                        <li class="{{ Request::is('login') ? 'active' : '' }}"><a href="{{ url('/login') }}" class="">Logga in</a></li>
                    </ul>
                    @elseif (Auth::check())
                     <ul class="nav navbar-nav navbar-right navbar-toggle login_menu collapsed">                               
                         <li><a style="background:none;" href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                                 <img src="{{ asset('assets/images/sign-in.svg')}}" alt="" width="33">
                                    </a></li>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                          </ul>  
                   @endif
                <!--</button>-->

                        <a class="navbar-brand p0" href="{{url('/')}}"><img src="{{ asset('assets/images/skolvals-logo.png')}}" alt="Skolguiden.nu" title="Skolguiden.nu" class="img-responsive logo mt-10"></a>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <ul class="nav navbar-nav mobile_nav" >



                        @if(!is_paid_user())
                        <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Skolval</a></li>
                        @endif

                        @if(is_paid_user())
                            <li class="{{ Request::is('map') ? 'active' : '' }}"><a href="{{ url('/map') }}">Premium</a></li>
                        @else
                            <li class="{{ Request::is('premium') ? 'active' : '' }}"><a href="{{ url('/premium') }}">Premium</a></li>
                        @endif
                        
                        <li class="{{ Request::is('about') ? 'active' : '' }}"><a href="{{ url('/about') }}">Om oss</a></li>
                        <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="{{ url('/contact') }}">Kontakt</a></li>
                    </ul>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right list-inline">



                            @if(Auth::check())
                            <li><a href="{{url('account')}}">Mitt konto</a></li>

                            @endif
                            @if (!(Auth::check()))
                            <li class="{{ Request::is('login') ? 'active' : '' }}"><a href="{{ url('/login') }}">Logga in</a></li>
                            @elseif (Auth::check())
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                    Logga ut
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>