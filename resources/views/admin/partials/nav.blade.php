<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ url('/') }}"><img style="float:left;" src="{{ asset('assets/images/logo.png') }}" alt=""> <span style="float: left; margin-left: 15px;">Salsa</span></a>
        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li>
                <a class="sidebar-control sidebar-main-toggle hidden-xs" data-container="body" data-placement="bottom" title="" data-popup="tooltip" data-original-title="Mini Sidebar">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
            <li>
                <a class="sidebar-control sidebar-main-hide hidden-xs" data-container="body" data-placement="bottom" title="" data-popup="tooltip" data-original-title="Hide Sidebar">
                    <i class="icon-lan3"></i>
                </a>
            </li>
        </ul>



        <ul class="nav navbar-nav navbar-right">


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-bell3"></i>
                    <span class="visible-xs-inline-block position-right">Messages</span>
                    {{--<span class="badge bg-warning-400">3</span>--}}
                </a>

                <div class="dropdown-menu dropdown-content width-350">
                    <div class="dropdown-content-heading">
                        Notifications
                    </div>

                    <ul class="media-list dropdown-content-body">

                    </ul>

                    <div class="dropdown-content-footer">
                        <a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
                    </div>
                </div>
            </li>

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="">

                    @if (Auth::check())
                    <span>{{ Auth::user()->name }}</span>
                    @else
                        <span>Welcome Guest</span>
                    @endif
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">

                    <li><a href="{{ url('/logout') }}"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>