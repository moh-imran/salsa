<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                @yield('page-title')
            </h4>
         </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ url("/admin/dashboard") }}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">@yield('breadcrumbs')</li>
        </ul>


    </div>
</div>
