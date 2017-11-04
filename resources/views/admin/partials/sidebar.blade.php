
<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="#" class="media-left"><img src="{{ asset('assets/images/placeholder.jpg') }}" class="img-circle img-sm" alt=""></a>
                    <div class="media-body">
                        @if (Auth::check())
                            <span class="media-heading text-semibold">{{ Auth::user()->name }}</span>
                        @endif
                        <div class="text-size-mini text-muted">
                            <i class="icon-pin text-size-small"></i> &nbsp;{{ Auth::user()->roles()->value('title') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
                    <li ><a href="{{ url('admin/dashboard') }}"><i class="icon-home4"></i> <span class="b-cursor">Dashboard</span></a></li>
                    <li >
                        <a><i class="icon-user"></i> <span>Manage Data</span></a>
                        <ul>
                            <li><a href="{{ url('admin/user') }}"><i class="icon-user"></i> <span class="b-cursor">Admin Users</span></a></li>
                            <li><a href="{{ url('admin/client') }}"><i class="fa fa-user"></i> <span class="b-cursor">Customers</span></a></li>
<!--			    <li><a href="{{ url('admin/children') }}"><i class="fa fa-user"></i> <span class="b-cursor">Children</span></a></li>-->
                        </ul>
                    </li>
                    <li>
                        <a><i class="fa fa-database"></i> <span>Manage Data</span></a>
                        <ul>
                            <li><a href="{{ url('admin/community') }}"><i class="fa fa-group"></i> Community</a></li>
                            <li><a href="{{ url('admin/school') }}"><i class="fa fa-graduation-cap"></i> School</a></li>
                            <li><a href="{{ url('admin/grade9data') }}"><i class="fa fa-graduation-cap">9</i> Grade9 Data</a></li>
                            <li><a href="{{ url('admin/national-result-data') }}"><i class="fa fa-trophy"></i> National Result Data</a></li>
                            <li><a href="{{ url('admin/school-salsa-value') }}"><i class="fa fa-tasks"></i> School Salsa Value</a></li>
                            <li><a href="{{ url('admin/qualify-upper-sec-data') }}"><i class="fa fa-pie-chart"></i> Qualify Upper Sec Data</a></li>
                            <li><a href="{{ url('admin/school-pupil-teacher-stat') }}"><i class="fa fa-pie-chart"></i> School Pupil Teacher Stat</a></li>
                            <li><a href="{{ url('admin/community-salsa-value') }}"><i class="fa fa-pie-chart"></i> Community Salsa Value</a></li>
                            <li><a href="{{ url('admin/subject') }}"><i class="fa fa-pie-chart"></i> Subject</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('admin/import/community') }}"><i class="icon-shuffle"></i> <span class="b-cursor"> Import Data</span></a>
                    </li>
                    <li>
                        <a><i class="fa fa-gears"></i> <span>Settings</span></a>
                        <ul>
                            <li><a href="{{ url('admin/setting') }}"><i class="fa fa-gear"></i> General Settings</a></li>
                            <li><a href="{{ url('admin/colorcode') }}"><i class="fa fa-cubes"></i> Color Codes</a></li>
                            <li><a href="{{ url('admin/triangles') }}"><i class="fa fa-exclamation-triangle"></i> Triangles</a></li>
							
                        </ul>
                    </li>
					
		    <li>
                        <a><i class="fa fa-file-excel-o"></i> <span>Export</span></a>
                        <ul>
                            <li><a href="{{ url('admin/download') }}"><i class="fa fa-file-excel-o"></i> Subject Warning Triangles</a></li>
                        </ul>
                    </li>
                    {{--<li>--}}
                        {{--<a href="{{ url('settings') }}"><i class="fa fa-cogs"></i> <span class="b-cursor">System Settings </span></a>--}}
                   {{--</li>--}}

                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
